<?php
namespace shop{

    use database\User;
    use database\DatabaseHelper;
    use database\DatabaseManager;
    use password_utils;

    # TODO: Login User + salting
    function login(string $user, string $password, DatabaseManager $databaseManager):User{

        $userData = $databaseManager->getFactory()->getUserBy($user, $password );
        if(empty($userData)){
            return false;
        }
        if(password_utils\verifyPassword($user,$userData->PasswordHash)){
            return $userData;
        }
        return null;
    }
    
    /**
     * registerClient
     *
     * @param  string $user
     * @param  string $password
     * @param  string $email
     * @param  DatabaseHelper $databaseHelper
     * @return User 
     */
    function registerClient(string $user, string $password, string $email, DatabaseHelper $databaseHelper):User{
        $salted = password_utils\generatePassword($password);
        $id_user = $databaseHelper->registerClient($user,$salted,$email);
        if(!$id_user){
            return new User(...$databaseHelper->getUserById($id_user));
        }
        return null;
    }
    # TODO: Register User
}

?>