<?php
namespace shop{

    require_once($_SERVER["DOCUMENT_ROOT"] . "/bootstrap.php");
    use database\User;
    use database\DatabaseManager;
    use database\exceptions\UserNotExist;
    use database\exceptions\WrongPassword;
    use shop\exceptions\EmailIsInvalid;
    use utils\PasswordUtils;

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
            if(PasswordUtils::verifyPassword($password,$userData->PasswordHash)){
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

            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) throw new EmailIsInvalid($email);
            $salted = PasswordUtils::generatePassword($password);
            $id_user = $this->dbm->getRequests()->registerClient($user,$salted,$email);
            return $this->dbm->getFactory()->getUser($id_user);
        }
    }
}

?>