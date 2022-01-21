<?php
namespace test{
    include ("../bootstrap.php");
    include_once("TestCase.php");

    use database\Cart;
    use database\DatabaseManager;
    use database\User;
    use DateInterval;
    use DateTime;
    use shop\exceptions\NoItemsInOrder;
    use shop\NotificationFactory;
    use shop\Shop;


    class TestNotification extends TestCase{
        private string $username = "test_user";
        private User $user;
        private NotificationFactory $notify;

        function __construct(private Shop $shop, private DatabaseManager $dbm){
            parent::__construct();
            
        }

        function beforeAll()
        {
            $this->notify = new NotificationFactory($this->dbm->getRequests());
            $this->user=$this->dbm->getFactory()->getUserBy($this->username);
        }

        public function testNewUser(){
            assert($this->notify->notifyNewUser($this->user),"Should have created notification");
            $this->dbm->getRequests()->deleteNotificationForUser($this->user->UserID);
        }

        public function testDeleteWithTime(){
            $this->dbm->getRequests()->deleteNotificationForUser($this->user->UserID);
            $date = new DateTime();
            $notification_number= count($this->dbm->getRequests()->getUserNotifications($this->user->UserID));
            $this->notify->notifyNewUser($this->user);
            $new_notification_number = count($this->dbm->getRequests()->getUserNotifications($this->user->UserID));
            assert($notification_number+1 == $new_notification_number,"Should be more notifications");
            $notification_number= $new_notification_number;
            $date->sub(new DateInterval("P1D"));
            $this->dbm->getRequests()->deleteNotificationForUserOlderThan($this->user->UserID,$date);
            $new_notification_number = count($this->dbm->getRequests()->getUserNotifications($this->user->UserID));
            assert($notification_number == $new_notification_number,"Should be the same amount of notifications");
            $date = (new DateTime())->add(new DateInterval("P1D"));
            $this->dbm->getRequests()->deleteNotificationForUserOlderThan($this->user->UserID,$date);
            $new_notification_number = count($this->dbm->getRequests()->getUserNotifications($this->user->UserID));
            assert( $new_notification_number<$notification_number,"Should be less notifications");
        }

    }
    new TestNotification($shop,$dbm);


}
?>