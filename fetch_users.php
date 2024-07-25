<?php
session_start();
include"includes/functions/funcs.php";
include"connect.php";
              if(isset($_SESSION['user']))
              {
                $email = $_SESSION['user'];
                $reg_status="where reg_status= 0 or reg_status = 1 or reg_status = 2 and email !='$email'";

              }
              if(isset($_SESSION['client']))
              {
                $email = $_SESSION['client'];
                $reg_status=getTable("reg_status",'clients',"where email='$email'");
                if($reg_status[0]['reg_status']==1 || $reg_status[0]['reg_status']==2)
                {
                    $reg_status="where (reg_status= 0 or reg_status = 1 or reg_status= 2 )and email !='$email'";

                }
                else
                {
                    $reg_status="where reg_status=1 or reg_status=2";

                }
              }
              
            $rows=getTable("*",'clients',"$reg_status");
            $result = array();
            $result['sender']=getTable("client_id",'clients',"where email='$email'");
             $result['msgs']= getTable('*',"messages");                   
             $result['notifications_unread']= getTable('*',"notificationss","where reciever_email='$email' and seen=0 order by notification_id desc");                   
             $result['notifications_read']= getTable('*',"notificationss","where reciever_email='$email'and seen=1 order by notification_id desc");                    
             $result['smss_unread']= getTable('*',"sms_notifications","where reciever_email='$email' and seen=0 order by notification_id desc");      
             $result['smss_read']= getTable('*',"sms_notifications","where reciever_email='$email' and seen=1 order by notification_id desc");                   
           foreach($rows as $row)
           {
             $result["users"][]=$row;
           }

#update last activity
if(isset($_SESSION['user']))
{
    
 $client_email = $_SESSION['user'];
$stmt = mysqli_query($con,"update clients set last_activity =now() where email='$client_email'");
}
else
{
$client_email = $_SESSION['client'];
$stmt = mysqli_query($con,"update clients set last_activity =now() where email='$client_email'");    
}



header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
echo json_encode($result);




?>

                