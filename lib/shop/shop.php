<?php
namespace shop{

    use database\DatabaseManager;
    class Shop{
        

        public function __construct(private DatabaseManager $dbm){
            $this->um = new UserManager($dbm);
            $this->om = new OrderManager($dbm);
        }
        
        /**
         * getUserManager
         *
         * @return UserManager
         */
        public function getUserManager():UserManager
        {
            return $this->um;
        }

        public function getOrderManager():OrderManager{
            return $this->om;
        }
    }
}
?>