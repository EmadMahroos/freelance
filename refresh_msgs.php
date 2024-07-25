<?php
if(isset($_POST['client_name'])&&isset($_POST['client_id'])&&isset($_POST['sender_id']))
{
include"includes/functions/funcs.php";
include"connect.php";
$clientname =  $_POST['client_name'];
$clientid =  $_POST['client_id'];
$senderid =  $_POST['sender_id'];
$last_msg =  $_POST['lastmsg'];
$rows = getTable('*',"messages","where msg_id >'$last_msg' and sender ='$senderid' and reciever ='$clientid' or  msg_id >'$last_msg' and sender ='$clientid' and reciever ='$senderid'");
                    foreach($rows as $row)
                    {
                      if($row['sender']==$senderid)
                      {
                        echo "<div class='sender msg' data-class='".$row['msg_id']."'>".$row['msg']."</div>";
                        echo "<div style='clear:both' ></div>";
                      }
                      else
                      {
                        echo "<div class='reciever msg' data-class='".$row['msg_id']."'>".$row['msg']."</div>";
                        echo "<div style='clear:both' ></div>";
                      
                      }
                    }
                  
}

    ?>
    