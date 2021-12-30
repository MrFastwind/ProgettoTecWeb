<?php

namespace database{

    use database\exceptions\mysqliBindException;
    use database\exceptions\UserExistAlready;
    use database\exceptions\UserNotExist;
    use LengthException;
    use mysqli;
    use mysqli_sql_exception;
    use mysqli_driver;

    //TODO:REFACTOR CODE (TO LONG)
class DatabaseRequests{
        private $db;

        public function __construct($servername, $username, $password, $dbname, $report_mode=MYSQLI_REPORT_STRICT){
            $driver = new mysqli_driver();
            $driver->report_mode = $report_mode;
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
            $stmt = $this->db->prepare($query);
            if (!$stmt){
                throw new mysqli_sql_exception($this->db->error);
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
         * hasRowsChanged
         * @return bool
         */
        private function hasRowsChanged():bool{
            return $this->db->affected_rows>0;
        }

        ## Category
        
        /**
         * getCategories
         *
         * @return array containing a dictionary of id, name of Category
         */
        //TODO: CHANGE to executeQuery
        //TODO: CHANGE to single/multi rows
        public function getCategories(){
            $stmt = $this->db->prepare("SELECT * FROM Category");
            $stmt->execute();
            $result = $stmt->get_result();

            return $result->fetch_all(MYSQLI_ASSOC);
        }

            
        /**
         * getCategoryById
         *
         * @param  int $idcategory the id of the category
         * @return string containing the name
         */
        //TODO: CHANGE to executeQuery
        //TODO: CHANGE to single row
        public function getCategoryById($idcategory){
            $stmt = $this->db->prepare("SELECT Name FROM Category WHERE CategoryID=?");
            $stmt->bind_param('i',$idcategory);
            $stmt->execute();
            $result = $stmt->get_result();

            return $result->fetch_all(MYSQLI_ASSOC);
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
         * @return array as the dictionary of Product 
         */
        //TODO: CHANGE to executeQuery
        //TODO: CHANGE to single row
        public function getProductById($id){
            $query = <<<SQL
            SELECT ProductID, Product.Name as Name, Image, Description, Quantity, Price, Username as Vendor, Category.Name as Category
            FROM Product, User, Category
            WHERE ProductID=? AND UserID=VendorID AND Product.CategoryID=Category.CategoryID
            SQL;
            $stmt = $this->db->prepare($query);
            $stmt->bind_param('i',$id);
            $stmt->execute();
            $result = $stmt->get_result();

            return $result->fetch_all(MYSQLI_ASSOC);
        }

        /**
         * getRandomProducts
         * 
         * @param int $n the number of random item to return, default is 1
         * @return array containing a dictionary of id, name, image_path, description of Product
         */
        //TODO: CHANGE to executeQuery
        public function getRandomProducts($n=1){
            $query = <<<SQL
            SELECT ProductID, Name, Image, Description, Quantity, Price, Category.Name as Category, Username as Vendor
            FROM Product, Category, 
            WHERE Category.CategoryID = Product.CategoryID
            ORDER BY RAND()
            LIMIT ?
            SQL;
            $stmt = $this->db->prepare($query);
            if ($stmt == false){
                var_dump($this->db->error);
            }
            $stmt->bind_param('i',$n);
            $stmt->execute();
            $result = $stmt->get_result();

            return $result->fetch_all(MYSQLI_ASSOC);
        }
        
        /**
         * getProductsByCategory
         *
         * @param  int $idcategory
         * @return array
         */
        //TODO: CHANGE to executeQuery
        public function getProductsByCategory($idcategory,$start=0,$n=10){
            $query = <<<SQL
            SELECT ProductID, Product.Name, Image, Description, Quantity, Price, Username as Vendor, Category.Name as Category
            FROM Product, User, Category
            WHERE Category.CategoryID=? AND UserID=VendorID AND Product.CategoryID=Category.CategoryID
            LIMIT ? OFFSET ?
            SQL;
            $stmt = $this->db->prepare($query);
            $stmt->bind_param('iii',$idcategory,$n,$start);
            $stmt->execute();
            $result = $stmt->get_result();

            return $result->fetch_all(MYSQLI_ASSOC);
        }
        
        /**
         * getProductsLike
         *
         * @param  mixed $search
         * @param  mixed $start
         * @param  mixed $n
         * @return array
         */
        //TODO: CHANGE to executeQuery
        public function getProductsLike(string $search,$start=0,$n=10):array{
            $search = '%'.$search.'%';
            $query = <<<SQL
            SELECT ProductID, Product.Name, Image, Description, Quantity, Price, Username as Vendor, Category.Name as Category
            FROM Product, User, Category
            WHERE ( Product.Name LIKE ? OR Product.Description LIKE ?) AND UserID=VendorID AND Product.CategoryID=Category.CategoryID
            LIMIT ? OFFSET ?
            SQL;
            $stmt = $this->db->prepare($query);
            $stmt->bind_param('ssii',$search,$search,$n,$start);
            $stmt->execute();
            $result = $stmt->get_result();
            return $result->fetch_all(MYSQLI_ASSOC);
        }
        
        /**
         * createProduct
         *
         * @param  mixed $name
         * @param  mixed $description
         * @return bool
         */

         //TODO: CHANGE to executeQuery
         //TODO: CHANGE to boolean result
        public function createProduct(string $name, string $description, string $image, int $quantity, int $price, int $vendorId, int $categoryId):bool
        {
            $query = <<<SQL
            BEGIN
            INSERT INTO Product (Name,Image,Description,Quantity,Price,VendorID,CategoryID)
            VALUES (?,?,?,?,?,?,?)
            COMMIT
            SQL;
            $stmt = $this->db->prepare($query);
            $stmt->bind_param('ssss',$name,$image,$description,$quantity,$price,$vendorId,$categoryId);
            $stmt->execute();
            $result = $stmt->get_result();

            return $result->fetch_all(MYSQLI_ASSOC);
        }

        ## User
        
        /**
         * getUsers
         *
         * @return array
         */
        //TODO: CHANGE to executeQuery
        public function getUsers(){
            $query = $this::USER_QUERY . " WHERE Enable = True";
            $stmt = $this->db->prepare($query);
            $stmt->execute();
            $result = $stmt->get_result();

            return $result->fetch_all(MYSQLI_ASSOC);
        }
        
        /**
         * getUserById
         *
         * @param  int $userid
         * @return array
         */
        public function getUserById($userid){

            $query = $this::USER_QUERY . " WHERE Enable = True AND UserID=?";

            $result = $this->executeQuery($query,MYSQLI_ASSOC,'iii',$userid,$userid,$userid);

            //TODO: change in 2 checks, it could be a db error.
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
         * checkLogin
         *
         * @param  mixed $username of the user
         * @param  mixed $password hashed
         * @return array as dictionary of User
         */
        //TODO: CHANGE to executeQuery
        //TODO: CHANGE to boolean result
        public function checkLogin($username, $password){
            $query = "SELECT UserID, Username, Email FROM Users WHERE Enable = True AND Username = ? AND PasswordHash = ?";
            $stmt = $this->db->prepare($query);
            $stmt->bind_param('ss',$username, $password);
            $stmt->execute();
            $result = $stmt->get_result();

            return $result->fetch_all(MYSQLI_ASSOC);
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
            $this->executeQuery($query,MYSQLI_ASSOC,"i",$userId);
            if($this->hasRowsChanged()){
                return true;
            }
            return false;
        }

        //TODO: CHANGE to executeQuery
        //TODO: CHANGE to row
        public function getCartByUser($userid){
            $query = <<<SQL
            SELECT ProductID, Product.Name, Image, Description, CartItem.Quantity as ItemQuantity, Price
            FROM Client, CartItem, Product
            WHERE UserID = ? AND Client.CartID = CartItem.CartID AND Product.ProductID = CartItem.ProductID
            SQL;
            $stmt = $this->db->prepare($query);
            $stmt->bind_param('i',$userid);
            $stmt->execute();
            $result = $stmt->get_result();

            return $result->fetch_all(MYSQLI_ASSOC);
        }

    }
}
?>