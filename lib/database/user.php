<?php

namespace database{

    use Exception;

class User extends DatabaseObject{

        public function __construct(
            public int $UserID,
            public string $Username,
            public string $Email,
            public string $PasswordHash,
            public mixed $isClient,
            public mixed $isVendor
        ){}

        public function pushToDatabase()
        {
            throw new Exception("Not Implemented!");
        }
    }
}
?>