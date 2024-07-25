<?php
include"includes/functions/funcs.php";
include"connect.php";

$result=array();
$msg=isset($_POST['msg'])?$_POST['msg']:null;
 $sender=isset($_POST['sender_id'])?$_POST['sender_id']:null;
 $reciever=isset($_POST['reciever_id'])?$_POST['reciever_id']:null;

if(!empty($msg))
{
    $stmt = mysqli_query($con,"insert into messages(msg,sender,reciever)values('$msg',$sender,$reciever)");
    $result['status']=$stmt;
}

//print messages

$start=isset($_GET['start'])?$_GET['start']:0;
$result['items']=getTable("*","messages","where msg_id > '$start'" );

//$result['lastid']=getTable("msg_id","messages","order by msg_id desc limit 1" );

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
echo json_encode($result);


?>