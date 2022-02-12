<?php
namespace shop{

    use database\Cart;
    use database\DatabaseRequests;
    use database\exceptions\DatabaseException;
    use database\exceptions\NoUser;
    use database\Product;
    use database\User;
    use Exception;

class NotificationFactory{


        function __construct(private DatabaseRequests $dbr){}

        public function notifyNewUser(User $user):bool{
            $username = $user->Username;
            return $this->dbr->createNotification("Benvenuto $username, e grazie per esserti registrato",$user->UserID);
        }


        public function notifyOrderCreation(int $userid,int $orderId):bool{
            return $this->dbr->createNotification("L'ordine #$orderId è stato creato",$userid);
        }

        public function notifyVendorWithProductToSend(int $orderId,Cart $cart):bool{
            foreach($cart->Items as $item){
                try{
                $userid = $this->dbr->getVendorByProduct($item->ProductID);
                $product = $this->dbr->getProductById($item->ProductID)["Name"];
                $this->dbr->createNotification("Spedire '$product' x$item->Quantity, per l'ordine $orderId!",$userid);
                }catch(NoUser $e){}
            }
            return true;
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

        public function notifyProductOutOfStock(Product $product):bool{
            $productId=$product->ProductID;
            $productName=$product->Name;
            return $this->dbr->createNotification("Il prodotto #$productId \"$productName\" è esaurito!",$this->dbr->getVendorByProduct($productId));
        }
    }
}
?>