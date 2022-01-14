<?php

namespace database{

    use database\exceptions\mysqliBindException;
    use database\exceptions\NoCart;
    use database\exceptions\UserExistAlready;
    use database\exceptions\UserNotExist;
    use LengthException;
    use LogicException;
    use mysqli;
    use mysqli_sql_exception;
    use mysqli_driver;

    //TODO:REFACTOR CODE (TO LONG)
class DatabaseRequests{
        private $db;
        private $connection_data;

        public function __construct($servername, $username, $password, $dbname, $report_mode=MYSQLI_REPORT_STRICT){
            $driver = new mysqli_driver();
            $driver->report_mode = $report_mode;
            $this->connection_data = array(
                "hostname" => $servername,
                "username" => $username,
                "password" => $password,
                "database" => $dbname);
            $this->db = new mysqli($servername, $username, $password, $dbname);
            if ($this->db->connect_error) {
                die("Connection failed: " . $this->db->connect_error);
            }
        }

        const USER_QUERY = <<<SQL
        SELECT UserID, Username, Email, PasswordHash, EXISTS(
                SELECT *
                FROM Client
                WHERE UserID=?
            ) as isClient, EXISTS(
                SELECT *
                FROM Vendor
                WHERE UserID=?
            ) as isVendor
        FROM User
        SQL;

        
        /**
         * executeQuery
         *
         * @param  string $query
         * @param  int $result_mode
         * @param  string $params_string
         * @param  array $params
         * @return array|bool false if fails to execute true if is not a set
         * @throws mysqli_sql_exception if statement syntax is wrong
         * @throws LengthException if the number of parameters is different from the string
         * @throws mysqliBindException if the type of bind is wrong
         */
        private function executeQuery(string $query, int $result_mode=MYSQLI_ASSOC,string $params_string='', ...$params):array|bool{
            return $this->executeTransactionQuery($this->db, $query, $result_mode, $params_string, ...$params);
        }
        
        /**
         * executeTransactionQuery
         *
         * @param  mysqli $db
         * @param  string $query
         * @param  int $result_mode
         * @param  string $params_string
         * @param  array $params
         * @return array|bool false if fails to execute true if is not a set
         * @throws mysqli_sql_exception if statement syntax is wrong
         * @throws LengthException if the number of parameters is different from the string
         * @throws mysqliBindException if the type of bind is wrong
         */
        private function executeTransactionQuery(mysqli $db, string $query, int $result_mode=MYSQLI_ASSOC,string $params_string='', ...$params):array|bool{
            $stmt = $db->prepare($query);
            if (!$stmt){
                throw new mysqli_sql_exception($db->error);
            }
            if (strlen($params_string)>0){
                if(strlen($params_string)!=count($params)){
                    throw new LengthException("Statement binds and number parameters doesn't match!");                    
                }
                if (!$stmt->bind_param($params_string,...$params)){
                    throw new mysqliBindException();
                }
            }
            if(!$stmt->execute()){
                return false;
            }
            $result = $stmt->get_result();
            if(!$result){
                return true;
            }

            return $result->fetch_all((int)$result_mode);
        }
        
        /**
         * haveRowsChanged
         * @return bool
         */
        private function haveRowsChanged():bool{
            return $this->db->affected_rows>0;
        }

        ## Category
        
        /**
         * getCategories
         *
         * @return array
         */
        public function getCategories():array{
            $query= "SELECT * FROM Category";
            $result = $this->executeQuery($query,MYSQLI_ASSOC);
            if(is_array($result)){
                return $result;
            }
            return array();
        }

            
        /**
         * getCategoryById
         *
         * @param  int $idcategory the id of the category
         * @return string containing the name
         */
        public function getCategoryById($idcategory):array|false{
            $result = $this->executeQuery("SELECT Name FROM Category WHERE CategoryID=?"
                ,MYSQLI_ASSOC,'i',$idcategory);
            if(is_array($result)){
                return $result[0];
            }
            return false;
        }
        
        ## Product

        /**
         * getProducts
         *
         * @param  int $n
         * @return array
         */
        public function getProducts(int $start=0, int $n=-1, bool $random=false):array{
            $params = array();
            $param_string = '';
            $query = <<<SQL
            SELECT ProductID, Product.Name, Image, Description, Quantity, Price, Username as Vendor, Category.Name as Category
            FROM User, Product
            LEFT JOIN Category
            ON Product.CategoryID=Category.CategoryID
            WHERE UserID=VendorID 
            ORDER BY Category.Name
            SQL;
            if($random){
                $query .= ", rand()";
            }
            if($n > 0 && $start>-1){
                $query .= " LIMIT ? OFFSET ?";
                $params[] = $n;
                $params[] = $start;
                $param_string .= "ii";  
            }

            $result_set=$this->executeQuery($query,MYSQLI_ASSOC,$param_string,...$params);
            if(is_array($result_set)){
                return $result_set;
            }
            return array();
        }
        
        /**
         * getProductById
         *
         * @param  int $id of the Product
         * @return array|false as the dictionary of Product or false if not exist
         */
        public function getProductById($id):array|false{
            $query = <<<SQL
            SELECT ProductID, Product.Name as Name, Image, Description, Quantity, Price, Username as Vendor, Category.Name as Category
            FROM Product, User, Category
            WHERE ProductID=? AND UserID=VendorID AND Product.CategoryID=Category.CategoryID
            SQL;
            $result = $this->executeQuery($query,MYSQLI_ASSOC,'i',$id);
            if(is_array($result)){
                return $result[0];
            }
            return false;
        }

        /**
         * getRandomProducts
         * 
         * @param int $n the number of random item to return, default is 1
         * @return array containing dictionaries of id, name, image_path, description of Product
         */
        public function getRandomProducts($n=1):array{
            $query = <<<SQL
            SELECT ProductID, Name, Image, Description, Quantity, Price, Category.Name as Category, Username as Vendor
            FROM Product, Category, 
            WHERE Category.CategoryID = Product.CategoryID
            ORDER BY RAND()
            LIMIT ?
            SQL;
            $result = $this->executeQuery($query,MYSQLI_ASSOC,'i',$n);
            if(is_array($result)){
                return $result;
            }
            return array();
        }
        
        /**
         * getProductsByCategory
         *
         * @param  int $idcategory
         * @return array
         */
        public function getProductsByCategory($idcategory,$start=0,$n=10):array{
            $query = <<<SQL
            SELECT ProductID, Product.Name, Image, Description, Quantity, Price, Username as Vendor, Category.Name as Category
            FROM Product, User, Category
            WHERE Category.CategoryID=? AND UserID=VendorID AND Product.CategoryID=Category.CategoryID
            LIMIT ? OFFSET ?
            SQL;
            $result = $this->executeQuery($query,MYSQLI_ASSOC,
                'iii',$idcategory,$n,$start);
            if(is_array($result)){
                return $result;
            }
            return array();
        }
        
        /**
         * getProductsLike
         *
         * @param  mixed $search
         * @param  mixed $start
         * @param  mixed $n
         * @return array|bool
         */
        public function getProductsLike(string $search,$start=0,$n=10):array|bool{
            $search = '%'.$search.'%';
            $query = <<<SQL
            SELECT ProductID, Product.Name, Image, Description, Quantity, Price, Username as Vendor, Category.Name as Category
            FROM Product, User, Category
            WHERE ( Product.Name LIKE ? OR Product.Description LIKE ?) AND UserID=VendorID AND Product.CategoryID=Category.CategoryID
            LIMIT ? OFFSET ?
            SQL;
            $result=$this->executeQuery($query,MYSQLI_ASSOC,'ssii',$search,$search,$n,$start);
            if(is_array($result)){
                return $result;
            }
            return $result;
        }
        
        /**
         * createProduct
         *
         * @param  mixed $name
         * @param  mixed $description
         * @return bool
         */
        public function createProduct(string $name, string $description, string $image, int $quantity, int $price, int $vendorId, int $categoryId):bool
        {
            $query = <<<SQL
            INSERT INTO Product (Name,Image,Description,Quantity,Price,VendorID,CategoryID)
            VALUES (?,?,?,?,?,?,?)
            SQL;
            return $this->executeQuery($query,MYSQLI_ASSOC,'sssiiii',
                $name,$image,$description,$quantity,$price,$vendorId,$categoryId);
        }

        ## User
        
        /**
         * getUsers
         *
         * @return array
         */
        public function getUsers():array{
            $query = $this::USER_QUERY . " WHERE Enable = True";
            $result = $this->executeQuery($query);
            if(is_array($result)){
                return $result;
            }
            return array();
        }
        
        /**
         * getUserById
         *
         * @param  int $userid
         * @return array
         * @throws UserNotExist
         */
        public function getUserById($userid):array{

            $query = $this::USER_QUERY . " WHERE Enable = True AND UserID=?";
            $result = $this->executeQuery($query,MYSQLI_ASSOC,'iii',$userid,$userid,$userid);
            if(!$result || empty($result)){
                throw new exceptions\UserNotExist();
            }            
            return $result[0];
        }
        
        /**
         * getUserByName
         *
         * @param  int $name
         * @return array
         * @throws UserNotExist
         */
        public function getUserByName(string $name):array
        {
            $query = <<<SQL
            SELECT UserID
            FROM User
            WHERE Username = ? OR Email = ?
            SQL;
            $user = $this->executeQuery($query,MYSQLI_ASSOC, 'ss',$name,$name);
            if(!is_array($user)){
                throw new exceptions\UserNotExist();
            }
            return $this->getUserById($user[0]["UserID"]);
        }
        
        /**
         * registerClient
         *
         * @param  string $username
         * @param  string $password
         * @param  string $email
         * @return int
         * @throws UserExistAlready when can't make a user
         */
        public function registerClient(string $username, string $password, string $email){
            $id = $this->registerUser($username, $password, $email);
            $this->addUserToClientById($id);
            return $id;
        }
        
        /**
         * registerUser
         *
         * @param  string $username
         * @param  string $password
         * @param  string $email
         * @return int
         * @throws UserExistAlready if can't add user
         */
        private function registerUser($username, $password, $email): int{
            $query = <<<SQL
            INSERT INTO User (Username,PasswordHash,Email)
            VALUES (?,?,?)
            SQL;

            if($this->executeQuery($query,MYSQLI_ASSOC,'sss',$username,$password,$email)){
                return $this->getUserByName($username)['UserID'];
            }
            throw new exceptions\UserExistAlready();
        }
        
        /**
         * addUserToClientById
         *
         * @param  int $userId
         * @return bool
         */
        public function addUserToClientById(int $userId):bool{
            $query=<<<SQL
            INSERT INTO Client (UserID)
            VALUES (?)
            SQL;
            return $this->executeQuery($query,MYSQLI_ASSOC,"i",$userId);
        }

        //Cart
        
        /**
         * getCartByUser
         *
         * @param  int $userid
         * @return array
         */
        public function getCartByUser(int $userid):array|false{
            $query = <<<SQL
            SELECT CartItemID, CartItem.CartID as CartID, Product.ProductID, CartItem.Quantity as Quantity
            FROM Client, CartItem, Product
            WHERE UserID = ? AND Client.CartID = CartItem.CartID AND Product.ProductID = CartItem.ProductID
            SQL;
            $result = $this->executeQuery($query,MYSQLI_ASSOC,'i',$userid);
            if(is_array($result)){
                return $result;
            }
            return false;
        }

        /**
         * getCart
         *
         * @param  int $userid
         * @return array
         */
        public function getCart(int $cartId):array|false{
            $query = <<<SQL
            SELECT CartItemID, Cart.CartID as CartID, ProductID, CartItem.Quantity as Quantity
            FROM CartItem, Product
            WHERE CartItem.CartID = ? AND Product.ProductID = CartItem.ProductID
            SQL;
            $result = $this->executeQuery($query,MYSQLI_ASSOC,'i',$cartId);
            if(is_array($result)){
                return $result;
            }
            return false;
        }
        
        public function getUserCartId(int $userId):int{
            $query = <<<SQL
            SELECT Client.CartID as CartID
            FROM Client, Cart
            WHERE UserID = ? AND Client.CartID = Cart.CartID
            SQL;
            $result = $this->executeQuery($query,MYSQLI_ASSOC,'i',$userId);
            if(is_array($result) && !empty($result)){
                return $result[0]['CartID'];
            }
            throw new NoCart($userId);
        }


        /**
         * userHaveCart
         *
         * @param  int $userId
         * @return bool
         */
        public function userHaveCart(int $userId):bool{
            $query = <<<SQL
            SELECT EXISTS (
                SELECT 1
                FROM Client
                WHERE UserID=? AND CartID IS NOT NULL
            )AS RESULT
            SQL;
            $result = $this->executeQuery($query,MYSQLI_ASSOC,'i',$userId);
            if(is_array($result)){
                return $result[0]['RESULT'];
            }
            return false;
        }
        
        /**
         * getClientCartId
         *
         * @param  int $clientId
         * @return int|false false failed
         * @throws NoCart if has no cart
         */
        public function getClientCartId(int $clientId):int|false{
            if(!$this->getUserById($clientId)["isClient"]){
                return false;
            }
            $query = <<<SQL
            SELECT CartID
            FROM Client
            WHERE UserID = ?
            SQL;
            $result = $this->executeQuery($query,MYSQLI_ASSOC,'i',$clientId);
            if(is_array($result) && !empty($result)){
                if(empty($result[0]['CartID'])){
                    throw new NoCart($clientId);                    
                }
                return $result[0]['CartID'];
            }
            return false;
        }

        /**
         * addItemToCart
         * add product to cart with a quantity, use {@see database\DatabaseRequests::updateQuantityInCart} to update the quantity
         * 
         * @param  mixed $cartId
         * @param  mixed $productId
         * @param  mixed $number number of item to add by default 1
         * @return bool
         */
        public function addItemToCart(int $cartId, int $productId, int $number=1):bool{
            $this->removeItemFromCart($cartId, $productId);
            $query = <<<SQL
            INSERT INTO CartItem(CartID,ProductID,Quantity)
            VALUES (?,?,?)            
            SQL;

            return $this->executeQuery($query,MYSQLI_ASSOC,'iii',$cartId,$productId,$number);
        }
        
        /**
         * updateQuantityInCart
         * update the quantity, to add the item in the cart use {@see database\DatabaseRequests::addItemToCart} 
         *
         * @param  mixed $cartId
         * @param  mixed $productId
         * @param  mixed $number
         * @return bool
         */
        public function updateQuantityInCart(int $cartId, int $productId, int $number):bool{
            $query = <<<SQL
            UPDATE CartItem
            SET Quantity=?
            WHERE CartID=? AND ProductID=?          
            SQL;

            return $this->executeQuery($query,MYSQLI_ASSOC,'iii',$number,$cartId,$productId);
        }
                
        /**
         * removeItemFromCart
         * delete item from cart, use {@see database\DatabaseRequests::updateQuantityInCart} to change the quantity
         *
         * @param  int $cartId
         * @param  int $productId
         * @return bool
         */
        public function removeItemFromCart(int $cartId,int $productId):bool{
            $query = <<<SQL
            DELETE FROM CartItem
            WHERE CartID=? AND ProductID=?          
            SQL;
            return $this->executeQuery($query,MYSQLI_ASSOC,'ii',$cartId,$productId);
        }

        /**
         * createCartForUser
         *
         * @param  int $userId
         * @return bool
         */
        public function createCartForUser($userId):bool{
            $this->db->begin_transaction();
            $query =<<<SQL
            INSERT INTO Cart (ClientID)
            VALUE(?);
            SQL;
            if(!$this->executeQuery($query,MYSQLI_ASSOC,'i',$userId)){
                $this->db->rollback();
                return false;
            }
            $query=<<<SQL
            UPDATE Client
            SET CartID=?
            WHERE UserID=?;
            SQL;
            if(!$this->executeQuery($query,MYSQLI_ASSOC,'ii',$this->db->insert_id,$userId)){
                $this->db->rollback();
                return false;
            }
            return $this->db->commit();
        }
        
        /**
         * deleteCart
         *
         * @param  mixed $cartId
         * @return bool
         */
        //TODO: check if delete cascade works
        public function deleteCart($cartId):bool{
            $query =<<<SQL
            DELETE FROM Cart
            WHERE CartID=?
            SQL;

            return $this->executeQuery($query,MYSQLI_ASSOC,'i',$cartId);
        }

        /**
         * deleteCart
         *
         * @param  int $cartId
         * @return bool
         */
        //TODO: check if delete cascade works
        public function deleteCartOfUser($userId):bool{
            $cartId = $this->getUserCartId($userId);
            $this->db->begin_transaction();
            if(!$this->deleteCart($cartId)){
                $this->db->rollback();
                return false;
            }
            $query =<<<SQL
            UPDATE Client
            SET CartID = null
            WHERE UserID=?
            SQL;
            if(!$this->executeQuery($query,MYSQLI_ASSOC,'i',$userId)){
                $this->db->rollback();
                return false;
            }
            $this->db->commit();
            return true;
        }

        ## Orders
        
        /**
         * createOrderFromUserCart
         *
         * @param  int $userId
         * @return int
         */
        public function createOrderFromUserCart(int $userId):int|false{
            $cartId=$this->getClientCartId($userId);
            $this->db->begin_transaction();
            if(!$this->createOrder($cartId)){
                $this->db->rollback();
                return false;
            }
            if($this->createCartForUser($userId)){
                $this->db->rollback();
                return false;
            }
            return $this->db->commit();
        }
        
        /**
         * calculateTotalSum
         *
         * @param  int $cartId
         * @return array
         */
        public function calculateTotalSum(int $cartId):array{
            $query=<<<SQL
            SELECT sum(CartItem.Quantity * Product.Price) as Amount, sum(CartItem.Quantity) as Quantity  
            FROM CartItem 
            JOIN Product ON CartItem.ProductId=Product.ProductId
            WHERE CartID=?
            SQL;
            $result = $this->executeQuery($query,MYSQLI_ASSOC,'i',$cartId);
            if(!$result || empty($result)){
                return false;
            }
            return $result[0];
        }
        
        /**
         * createOrder
         *
         * @param  int $cartId
         * @return bool
         */
        //TODO: Error to create order
        public function createOrder(int $cartId):bool{
            $query=<<<SQL
            INSERT INTO `Order` (CartID)
            VALUES (?);
            SQL;
            $result = $this->executeQuery($query,MYSQLI_ASSOC,'i',$cartId);
            if(!$result || empty($result)){
                return false;
            }
            return $result[0]["OrderId"];
        }
    }
}
?>