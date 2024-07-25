<?php
session_start();
include"includes/functions/funcs.php";
include"connect.php";
 $msg=isset($_POST['msg'])?$_POST['msg']:null;
  $sender=isset($_POST['sender_id'])?$_POST['sender_id']:null;
  $reciever=isset($_POST['reciever_id'])?$_POST['reciever_id']:null;
if(!empty($msg))
{
     $stmt = mysqli_query($con,"insert into messages(msg,sender,reciever)values('$msg',$sender,$reciever)");
    
}

#insert into notifications
if(!empty($msg))
{
$recieveremail=getTable("email,client_name","clients","where client_id='$reciever'");
$sendername=getTable("client_name","clients","where client_id='$sender'");
$sender_name=$sendername[0]['client_name'];
$reciever_email=$recieveremail[0]["email"];
$description="<div class=\'name\'>".$sender_name .":</div>".$msg;
$reciever_name=$recieveremail[0]["client_name"];

     $stmt = mysqli_query($con,"insert into sms_notifications(notification_description,sender,reciever,sender_name,reciever_email)values('$description',$sender,$reciever,'$sender_name','$reciever_email')");
}
     
#insert into contacting
 $sms=isset($_POST['sms'])?$_POST['sms']:null;
  $client_name=isset($_POST['client_name'])?$_POST['client_name']:null;
  $client_email=isset($_POST['client_email'])?$_POST['client_email']:null;
  if(!empty($sms))
  {
  $inserting=mysqli_query($con,"insert into contacting(sms,name,email)values('$sms','$client_name','$client_email')");
  if($inserting)
  {
   echo "<div class='alert text-center' style='color:#28a745;font-weight:bold'> <i class='fas fa-check'></i>sent</div>";
  }
  else
  {
   echo "<div class='alert text-center' style='color:red;font-weight:bold'> <i class='fas fa-exclamation-triangle'></i> please type correct information</div>";
   
  }

     
  }
?>