<?php
namespace shop{

    use database\DatabaseManager;
    class Shop{
        

        public function __construct(private DatabaseManager $dbm){
            $this->um = new UserManager($dbm);
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
    }
}
?>