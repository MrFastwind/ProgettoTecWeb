<?php
namespace database{
    //TODO: divide in multiple factories

    use database\exceptions\DoesNotExist;
    use database\exceptions\NoCart;
    use database\exceptions\NotClient;
    use Exception;
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
         * @param  int $id
         * @return User
         */
        public function getUser(int $id): User
        {
            $user = $this->dbh->getUserById($id);
            if (!is_array($user)) {
                return NULL;
            }
            $user['isClient'] = (bool)$user['isClient'];
            $user['isVendor'] = (bool)$user['isVendor'];

            return new User(...$user);
        }
        
        /**
         * getUserBy
         *
         * @param  string $Name
         * @return User
         * @throws UserNotExists
         */
        public function getUserBy(string $Name): User
        {          
            return new User(...$this->dbh->getUserByName($Name));
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
                    $collection[$value["CategoryID"]] = $value["Name"];
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
            $item = $this->dbh->getProductById($id);
            if (empty($item)) {
                return NULL;
            }
            return new Product(...$item);
        }
                
        /**
         * getProductsLike
         *
         * @param  string $query
         * @param  int $start_position
         * @param  int $length
         * @return array
         */
        public function getProductsLike(string $query,int $start_position=0,int $length=10):array{
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
        
        /**
         * getProducts
         *
         * @param  mixed $start_position
         * @param  mixed $length
         * @param  mixed $random
         * @return array
         */
        public function getProducts($start_position = 0,$length = 10,bool $random=false):array
        {
            if (!$this->areArgsCorrects($length,$start_position)){
                return array();
            }
            $table = $this->dbh->getProducts($start_position, $length, $random);
            return $this->productList($table);
        }


        //Cart
        
        /**
         * getUserCart
         *
         * @param  mixed $userId
         * @return Cart
         * @throws NotClient
         */
        public function getUserCart(int $userId):Cart{
            $user = $this->getUser($userId);
            if(!$user->isClient){
                throw new NotClient();
            }
            if(!$this->dbh->userHaveCart($userId)){
                $this->dbh->createCartForUser($userId);
            }
            $cartId = $this->dbh->getClientCartId($userId);
            $result = $this->dbh->getCartByUser($userId);
            if(is_array($result)){
                $items = array();
                foreach($result as $item){
                    $items[$item['ProductID']]=new CartItem(...$item);
                }
                return new Cart($cartId,$userId,$items);
            }
        }

        /**
         * getCart
         *
         * @param  mixed $userId
         * @return Cart
         * @throws DoesNotExist
         */
        public function getCart(int $cartId):Cart{
            $userId = $this->dbh->getUserIdByCart($cartId);
            if (!$userId){
                throw new DoesNotExist("Cart doesn't exist");
            }
            $result = $this->dbh->getCart($cartId);
            if(is_array($result)){
                $items = array();
                foreach($result as $item){
                    $items[$item['ProductID']]=new CartItem(...$item);
                }
                return new Cart($cartId,$userId,$items);
            }
        }

        //Order
        
        /**
         * getOrder
         *
         * @param  int $orderId
         * @return Order
         */
        public function getOrder(int $orderId):Order{
            $order = $this->dbh->getOrder($orderId);
            return new Order(...$order);
        }


        # Utility
        
        protected function productList(array $table):array{
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