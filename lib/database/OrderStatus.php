<?php
namespace database{

    use InvalidArgumentException;
    use ValueError;

class OrderStatus{

        static public function AT_STORAGE():OrderStatus
        {
            return new self("AtStorage");
        }

        static public function DEPARTED():OrderStatus{
            return new self("Departed");
        }

        static public function DELIVERED():OrderStatus{
            return new self("Delivered");
        }

        static public function COLLECTED():OrderStatus{
            return new self("Collected");
        }

        private function __construct(private string $value)
        {
        }

        static public function getStatusByString(string $status):OrderStatus{
            switch ($status) {
                case 'AtStorage':
                    return self::AT_STORAGE();
                break;

                case 'Departed':
                    return self::DEPARTED();
                break;

                case 'Delivered':
                    return self::DELIVERED();
                break;
                
                case 'Collected':
                    return self::COLLECTED();
                break;                
                    
                default:
                    throw new ValueError("the status '$status' doesn't  exist");
                break;
            }
        }
        
        public function __toString()
        {
            return $this->value;
        }
    }
}
?>