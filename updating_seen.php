<?php
session_start();
include"includes/functions/funcs.php";
include"connect.php";
              if(isset($_SESSION['user']))
              {
                $email = $_SESSION['user'];
                

              }
              if(isset($_SESSION['client']))
              {
                $email = $_SESSION['client'];
              }
 $sms_seen=isset($_POST['smsseen'])?intval($_POST['smsseen']):0;
 $notifications_seen=isset($_POST['notificationsseen'])?intval($_POST['notificationsseen']):0;
if($sms_seen==1)
{
    $stmt=mysqli_query($con,"update sms_notifications set seen ='$sms_seen' where reciever_email = '$email'");
}
if($notifications_seen==1)
{
$stmt2=mysqli_query($con,"update notificationss set seen ='$notifications_seen' where reciever_email = '$email'");
}
?>