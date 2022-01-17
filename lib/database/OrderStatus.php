<?php
namespace database{

    class OrderStatus{

        static public function AT_STORAGE()
        {
            return new self("AtStorage");
        }

        static public function DEPARTED(){
            return new self("Departed");
        }

        static public function DELIVERED(){
            return new self("Delivered");
        }

        static public function COLLECTED(){
            return new self("Collected");
        }

        static private function __constructor(string $value)
        {
        }

        public function __toString()
        {
            return $this->value;
        }
    }
}
?>