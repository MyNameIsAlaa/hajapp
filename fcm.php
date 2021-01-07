<?php

require __DIR__ . '/vendor/autoload.php';

use Kreait\Firebase\Factory;
use Kreait\Firebase\ServiceAccount;
use Kreait\Firebase\Messaging\CloudMessage;
use Kreait\Firebase\Messaging\Notification;

class FCM
{

    private $firebase;

    public function __construct()
    {
        try {
            //code...
            $serviceAccount = ServiceAccount::fromJsonFile(__DIR__ . '/hajtours-1557219655389-e58163396280.json');
            $this->firebase = (new Factory)->withServiceAccount($serviceAccount)->create();
        } catch (\Throwable $th) {
            //throw $th;
            echo "error: " . $th;
        }
    }

    public function sendMessage($message)
    {
        $messaging = $this->firebase->getMessaging();
        $fcm_message = CloudMessage::new()->withTarget('topic', 'message')->withNotification(['title' => 'Haj Tours', 'body' => $message]);
        $messaging->send($fcm_message);
    }
}
