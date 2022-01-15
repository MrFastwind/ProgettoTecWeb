<?php
namespace shop{

    use database\DatabaseRequests;
    use database\exceptions\DatabaseException;

class NotificationFactory{


        function __construct(private DatabaseRequests $dbr){}

        public function notifyOrderCreation(int $userid,int $orderId):bool{
            return $this->dbr->createNotification("L'ordine $orderId è stato creato",$userid);
        }

        public function notifyOrderProgress(int $userid,int $orderId):bool{
            try{
                $orderStatus = $this->dbr->getOrder($orderId);
                if(empty($orderStatus)){
                    return false;
                }else{
                    $orderStatus=$orderStatus['OrderStatusID'];
                }
                //ask for order status
                return $this->dbr->createNotification("lo stato dell'ordine $orderId, è stato cambiato in: $orderStatus",$userid);
            }catch(DatabaseException $e){

            }
            return false;
        }
    }
}
?>