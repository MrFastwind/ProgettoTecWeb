<?php

namespace password_utils{
    
    /**
     * generatePassword
     * 
     * @param  string $Password
     * @return string the salted and hashed password
     */
    function generatePassword(string $Password):string
    {
        return password_hash($Password,PASSWORD_DEFAULT);
    }
    
    /**
     * verifyPassword
     *
     * @param  string $Password
     * @param  string $hashed
     * @return bool
     */
    function verifyPassword(string $Password, string $hashed):bool{
        return password_verify($Password,$hashed);
    }

}
?>