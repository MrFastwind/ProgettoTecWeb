<?php

namespace database{

    class User{

        public function __construct(
            public int $UserID,
            public string $Username,
            public string $Email,
            public string $PasswordHash,
            public mixed $isClient,
            public mixed $isVendor
        ){

        }
    }
}
?>