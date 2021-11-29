<?php
namespace database{
    class DatabaseObjectFactory{

        private $dbh;

        public function __construct(DatabaseHelper $dbh)
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

        /**
         * getProductByCategory
         *
         * @param  int $idCategory of the category
         * @param  int $start_position of the table list
         * @param  int $length of the table list
         * @return Products[]
         */
        public function getProductByCategory($idCategory,$start_position = 0,$length = 10): iterable
        {
            if ($length < 1 or $start_position < 0){
                return array();
            }
            $table = $this->dbh->getProductsByCategory($idCategory,$start_position,$length);
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

    }

}
?>