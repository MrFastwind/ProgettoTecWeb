<?php

namespace database{

    use JetBrains\PhpStorm\ArrayShape;
    use LengthException;
    use mysqli;
    use mysqli_sql_exception;
    use mysqli_stmt;

class DatabaseHelper{
        private $db;
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

        public function __construct($servername, $username, $password, $dbname){
            $this->db = new mysqli($servername, $username, $password, $dbname);
            if ($this->db->connect_error) {
                die("Connection failed: " . $this->db->connect_error);
            }        
        }

        private function executeQuery(string $query, int $result_mode=MYSQLI_ASSOC,string $params_string='', ...$params):mixed{
            $stmt = $this->db->prepare($query);
            if (!$stmt){
                throw new mysqli_sql_exception("Statement query syntax is wrong!");
            }
            if (strlen($params_string)>0){
                if(strlen($params_string)!=count($params)){
                    throw new LengthException("Statement binds and number parameters doesn't match!");                    
                }
                if (!$stmt->bind_param($params_string,$params)){
                    throw new mysqliBindException();
                }
            }
            if(!$stmt->execute()){
                return false;
            }

            return $stmt->get_result()->fetch_all($result_mode);
        }

        ## Category
        
        /**
         * getCategories
         *
         * @return array containing a dictionary of id, name of Category
         */
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
        public function getProducts(int $start=0, int $n=-1):array{
            $query = <<<SQL
            SELECT ProductID, Product.Name, Image, Description, Quantity, Price, Username as Vendor, Category.Name as Category
            FROM Product, User, Category
            WHERE UserID=VendorID AND Product.CategoryID=Category.CategoryID
            ORDER BY Category.Name
            SQL;
            if($n > 0 && $start>-1){
                $query .= " LIMIT ? OFFSET ?";
            }
            $stmt = $this->db->prepare($query);
            if($n > 0 && $start>-1){
                $stmt->bind_param('ii',$n,$start);
            }
            $stmt->execute();
            $result = $stmt->get_result();

            return $result->fetch_all(MYSQLI_ASSOC);
        }
        
        /**
         * getProductById
         *
         * @param  int $id of the Product
         * @return array as the dictionary of Product 
         */
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
        public function getUsers(){
            $query = $this::USER_QUERY . " WHERE Enable = True";
            $stmt = $this->db->prepare($query);
            $stmt->execute();
            $result = $stmt->get_result();

            return $result->fetch_all(MYSQLI_ASSOC);
        }

        public function getUserById($userid){

            $query = $this::USER_QUERY . " WHERE Enable = True AND UserID=?";

            $stmt = $this->db->prepare($query);
            if ($stmt == false){
                var_dump($this->db->error);
            }
            $stmt->bind_param('iii',$userid,$userid,$userid);
            $stmt->execute();
            $result = $stmt->get_result();

            return $result->fetch_all(MYSQLI_ASSOC);
        }
        
        /**
         * checkLogin
         *
         * @param  mixed $username of the user
         * @param  mixed $password hashed
         * @return array as dictionary of User
         */
        public function checkLogin($username, $password){
            $query = "SELECT UserID, Username, Email FROM Users WHERE Enable = True AND Username = ? AND PasswordHash = ?";
            $stmt = $this->db->prepare($query);
            $stmt->bind_param('ss',$username, $password);
            $stmt->execute();
            $result = $stmt->get_result();

            return $result->fetch_all(MYSQLI_ASSOC);
        }
        
        public function getUserByName(string $name)
        {
            $query = $this::USER_QUERY .' '. <<<SQL
            WHERE Username = ? OR Email = $name
            SQL;
            $stmt=$this->db->prepare($query);
            $stmt->bind_param('ss',$name,$name);
            $stmt->execute();
            $result = $stmt->get_result();

            return $result->fetch_all(MYSQLI_ASSOC);
        }

        public function registerClient($username, $password, $email){
            $query = <<<SQL
            BEGIN
            INSERT INTO Users (Username,PasswordHash,Email)
            VALUES (?,?,?)
            INSERT INTO Client (UserID)
            VALUES (LAST_INSERT_ID())
            COMMIT
            SQL;
            $stmt = $this->db->prepare($query);
            $stmt->bind_param('ssss',$username,$password,$email,$username);
            $stmt->execute();
            $result = $stmt->get_result();

            return $result->fetch_all(MYSQLI_ASSOC);
        }

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