<?php
namespace shop{

    require_once($_SERVER["DOCUMENT_ROOT"] . "/bootstrap.php");
    use database\User;
    use database\DatabaseManager;
    use database\exceptions\UserNotExist;
    use database\exceptions\WrongPassword;
    use shop\exceptions\EmailIsInvalid;
    use shop\exceptions\NotLoggedIn;
    use utils\PasswordUtils;

class UserManager{

        protected NotificationFactory $notify;

        public function __construct(private DatabaseManager $dbm){
            $this->notify=new NotificationFactory($this->dbm->getRequests());
        }
        
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
                $this->loginUser($userData);
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
            $user = $this->dbm->getFactory()->getUser($id_user);
            $this->notify->notifyNewUser($user);
            return $user;
        }
        
        /**
         * isUserLogged
         *
         * @return bool
         */
        public function isUserLogged():bool{
            return !empty($_SESSION['User']);
        }
        
        /**
         * getSessionUser
         *
         * @return User
         * @throws NotLoggedIn if user is not logged
         */
        public function getSessionUser():User{
            if(!$this->isUserLogged()){
                throw new NotLoggedIn();
            }
            return $_SESSION['User'];
        }
        
        /**
         * logOut
         *
         * @return void
         */
        public function logOut(){
            $this->sessionDestroy();
        }
        
        /**
         * sessionDestroy
         *
         * @return void
         */
        private function sessionDestroy(){
            session_destroy();
            session_reset();
            session_start();
        }
        
        /**
         * loginUser
         *
         * @param  User $user
         * @return void
         */
        private function loginUser(User $user){
            $this->sessionDestroy();
            $_SESSION['User']=$user;
        }
    }
}

?>