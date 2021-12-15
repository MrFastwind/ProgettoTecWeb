<?php

namespace password_utils{

    function generatePassword(string $Password):string
    {
        return password_hash($Password,PASSWORD_DEFAULT);
    }

    function verifyPassword(string $Password, string $hash):bool{
        return password_verify($Password,$hash);
    }

}
?>