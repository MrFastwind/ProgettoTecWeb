<?php

namespace database{

    class DatabaseManager
    {
        private DatabaseRequests $dbh;
        private DatabaseObjectFactory $factory;
        private DatabaseUpdater $updater;

        public function __construct($servername, $username, $password, $dbname)
        {
            $this->dbh= new DatabaseRequests($servername, $username, $password, $dbname);
            $this->factory = new DatabaseObjectFactory($this->dbh);
            $this->updater = new DatabaseUpdater($this->dbh);
        }
        
        public function getFactory():DatabaseObjectFactory{
            return $this->factory;
        }

        public function getUpdater():DatabaseUpdater{
            return $this->updater;
        }

        public function getRequests():DatabaseRequests{
            return $this->dbh;
        }
    }
    
}

?>