<?php
namespace database{
    require_once("database.php");
    class DatabaseObjectFactory{

        private $dbh;

        public function __construct(DatabaseHelper $dbh)
        {
            $this->dbh = $dbh;
        }

        public function getUser(int $id): User
        {
            $user = $this->dbh->getUserById($id);
            if (empty($user)) {
                die("Sql failed: User id " . $id . " doesn't exist!");
            }else {
                $user=$user[0];
            }
            $user['isClient'] = (bool)$user['isClient'];
            $user['isVendor'] = (bool)$user['isVendor'];

            return new User(...$user);
        }

        public function getProduct(int $id): Product
        {
            return new Product($this->dbh, $id);
        }
    }

}
?>