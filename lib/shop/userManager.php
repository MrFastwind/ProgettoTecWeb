<?php
namespace shop{

    require_once($_SERVER["DOCUMENT_ROOT"] . "/bootstrap.php");
    use database\User;
    use database\DatabaseRequests;
    use database\DatabaseManager;
    use database\UserNotExist;
    use database\WrongPassword;
    use password_utils;

class UserManager{

        public function __construct(private DatabaseManager $dbm){}
        
        /**
         * login
         *
         * @param  mixed $user
         * @param  mixed $password
         * @return User
         * @throws UserNotExist
         * @throws WrongPassword
         */
        function login(string $user, string $password):User{

            $userData = $this->dbm->getFactory()->getUserBy($user);
            if(password_utils\verifyPassword($password,$userData->PasswordHash)){
                return $userData;
            }
            throw new WrongPassword();
        }
        
        /**
         * registerClient
         *
         * @param  string $user
         * @param  string $password
         * @param  string $email
         * @return User
         * @throws UserExistAlready when can't make a user
         */
        function registerClient(string $user, string $password, string $email):User{
            $salted = password_utils\generatePassword($password);
            $id_user = $this->dbm->getRequests()->registerClient($user,$salted,$email);
            return $this->dbm->getFactory()->getUser($id_user["UserID"]);
        }
    }
}

?>