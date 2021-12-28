<?php
namespace database{
    //TODO: divide in multiple factories
    use password_utils as pu;
    class DatabaseObjectFactory{

        private $dbh;

        public function __construct(DatabaseRequests $dbh)
        {
            $this->dbh = $dbh;
        }
        
        /**
         * getUser
         *
         * @param  mixed $id
         * @return User
         */
        public function getUser(int $id): User
        {
            $user = $this->dbh->getUserById($id);
            if (empty($user)) {
                return NULL;
            }else {
                $user=$user[0];
            }
            $user['isClient'] = (bool)$user['isClient'];
            $user['isVendor'] = (bool)$user['isVendor'];

            return new User(...$user);
        }

        public function getUserBy(string $Name, string $Password ): User
        {
            $user = $this->dbh->getUserByName($Name);
            if(is_array($user)){
                if(pu\verifyPassword($Password,$user["PasswordHash"])){
                    return $this->getUser($user["UserID"]);
                }
                throw new WrongPassword();
            }
            
            return null;
        }
                
        /**
         * getCategories
         *
         * @return array compose of Id as a key and Name as value
         */
        public function getCategories(): array
        {
            $collection = array();
            $table = $this->dbh->getCategories();
            if(!empty($table)){
                foreach ($table as $key => $value) {
                    $collection[$value["Name"]] = $value["CategoryID"];
                }
            }
            return $collection;
        }
        

        /**
         * getProduct
         *
         * @param  mixed $id
         * @return Product
         */
        public function getProduct(int $id): Product
        {
            $item = $this->dbh->getUserById($id);
            if (empty($item)) {
                return NULL;
            }else {
                $item=$item[0];
            }
            return new Product(...$item);
        }

        public function getProductsLike(string $query,$start_position=0,$length=10):iterable{
            if (!$this->areArgsCorrects($length,$start_position)){
                return array();
            }
            $table = $this->dbh->getProductsLike($query,$start_position,$length);
            return $this->productList($table);
        }

        /**
         * getProductByCategory
         *
         * @param  int $idCategory of the category
         * @param  int $start_position of the table list
         * @param  int $length of the table list
         * @return Products[]
         */
        public function getProductsByCategory($idCategory,$start_position = 0,$length = 10): iterable
        {
            if (!$this->areArgsCorrects($length,$start_position)){
                return array();
            }
            $table = $this->dbh->getProductsByCategory($idCategory,$start_position,$length);
            return $this->productList($table);
        }

        public function getProducts($start_position = 0,$length = 10):iterable
        {
            if (!$this->areArgsCorrects($length,$start_position)){
                return array();
            }
            $table = $this->dbh->getProducts($start_position, $length);
            return $this->productList($table);
        }

        # Utility
        
        protected function productList(array $table):iterable{
            $collection = array();
            if(!empty($table)){
                foreach ($table as $key => $value) {
                    $collection[] = new Product(...$value);
                }
            }
            return $collection;
        }

        protected function userList(array $table):iterable{
            $collection = array();
            if(!empty($table)){
                foreach ($table as $key => $value) {
                    $collection[] = new User(...$value);
                }
            }
            return $collection;
        }

        protected function areArgsCorrects(int $length,int $start):bool
        {
            if ($length < 1 or $start < 0){
                return false;
            }
            return true;
        }

    }

}
?>