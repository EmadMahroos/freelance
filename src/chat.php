<?php
namespace MyApp;
use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;
include "../sock_save_sql.php";
class Chat implements MessageComponentInterface {
    protected $clients;
    public $userid;
    public $sender;
    public $reciever;
    public $array = array();
    public function __construct() {
        session_start();
        $this->clients = new \SplObjectStorage;
        echo "server started. \n";
    }

    public function onOpen(ConnectionInterface $conn) {
        // Store the new connection to send messages to later
        $this->clients->attach($conn);

        echo "New connection! ({$conn->resourceId})\n";
    }

    public function onMessage(ConnectionInterface $from, $msg) {
        $numRecv = count($this->clients) - 1;
        echo sprintf('Connection %d sending message "%s" to %d other connection%s' . "\n"
            , $from->resourceId, $msg, $numRecv, $numRecv == 1 ? '' : 's');
            $stmt = new \usersData();
            $data = json_decode($msg,true);
            if(isset($data['onlineperson']))
            {
                $this->array[$from->resourceId]=$data['onlineperson'];
                $this->userid = $data['onlineperson'];
                $stmt->changeOnlineStatus($this->userid,1);
            }
            if(isset($data['msg']))
            {
                $this->sender = $data['sender'];
                $this->reciever = $data['reciever'];
                $msg_time['msg_time'] = $stmt->saveMsgs($data['msg'],$this->sender,$this->reciever);
                            if($this->userid !=null)
                {
                    foreach ($this->clients as $client) {
                        if ($from !== $client) {
                            // The sender is not the receiver, send to each client connected
                            $client->send(json_encode($msg_time));
                        }
                    }                
                }
                
            }
            if(isset($data['notifications_seen']))
            {
                $stmt->updateNotificationSeen($data['userid'],"notificationss");
            }
            if(isset($data['sms_seen']))
            {
                $stmt->updateNotificationSeen($data['userid'],"sms_notifications");
            }
            if(isset($data['comment']))
            {
                $this_notification_owners['notification_owner'] = $stmt->addComment($data['comment_owner'],$data['job_id'],$data['comment']);
                if($this->userid !=null)
                {
                    foreach ($this->clients as $client) {
                        if ($from !== $client) {
                            // The sender is not the receiver, send to each client connected
                            $client->send(json_encode( $this_notification_owners));
                        }
                    }                
                }
            }            
            if($this->userid !=null)
            {
                foreach ($this->clients as $client) {
                    if ($from !== $client) {
                        // The sender is not the receiver, send to each client connected
                        $client->send($msg);
                    }
                }                
            }

    }

    public function onClose(ConnectionInterface $conn) {
        // The connection is closed, remove it, as we can no longer send it messages
        $this->clients->detach($conn);
        if(in_array($this->array[$conn->resourceId],$this->array))
        {
            echo '\n yes \n';
        echo "\n offline \n";
       echo $offto = $this->array[$conn->resourceId] ."\n";
            foreach ($this->clients as $client) {
                
                $client->send(json_encode(["offlineperson"=>$offto]));
            }
            $stmt = new \usersData();
            $stmt->changeOnlineStatus($offto,0);            
        }
        else
        {
            echo '\nno\n';
        }


    }

    public function onError(ConnectionInterface $conn, \Exception $e) {
        echo "An error has occurred: {$e->getMessage()}\n";

        $conn->close();
    }
}