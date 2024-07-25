<?php

ob_start();
?>

<?php
$rows=array();
if(isset($_POST['client_name'])&&isset($_POST['client_id'])&&isset($_POST['sender_id']))
{
include"includes/functions/funcs.php";
include"connect.php";
$clientname =  $_POST['client_name'];
$clientid =  $_POST['client_id'];
$senderid =  $_POST['sender_id'];
$st= getTable("client_name","clients","where client_id = '$senderid'");
$sender_name = $st[0]['client_name'];
$rows['msgs']= getTable('*',"messages","where sender ='$senderid' and reciever ='$clientid' or sender ='$clientid' and reciever ='$senderid'");



    ?>
            <div class="chat <?php echo $clientid?> <?php echo $senderid ."to". $clientid?>" data-class="<?php echo $clientid?>">
              <div class="admin-info" style="display: none">
                  <span class="client_id" data-class="<?php echo $clientid?>"></span>
                  <span class="sender_id" data-class="<?php echo $senderid?>"></span>
                  <span class="client_name" data-class="<?php echo $clientname?>"></span>
                  <span class="sender_name" data-class="<?php echo $sender_name?>"></span>
              </div>
                <div class="chat-header">
                    <?php echo $clientname?>
                    <i class="fas fa-window-close chat-close"></i>
                    <i class="fas fa-window-minimize chat-minimize"></i>
                    
                </div>
                
                <div class="chat-body-con">
                  
                  <div class="chat-body" data-reciever_name="<?php echo $clientname?>" data-sender="<?php echo $senderid?>" data-reciever="<?php echo $clientid?>">
  
                      <?php
                        echo "<div class='msg' data-class='0'>chat with ".$clientname."</div>";
                        if(!empty($rows["msgs"]))
                        {
                            $today =  date("Y/m/d");
                            $first_date = date("Y/m/d",strtotime($rows['msgs'][0]['time']));
                            if($today ==$first_date )
                            {
                                echo "<div class='date'> Today</div>";
                                
                            }
                            else
                            {
                                echo "<div class='date'>".$first_date."</div>";
                            }
                        }
                        
                      foreach($rows['msgs'] as $row)
                      {
                        $second_date = date("Y/m/d",strtotime($row['time']));
                        if($second_date!=$first_date)
                        {
                            if($today==$second_date)
                            {
                                $first_date = $second_date;
                                echo "<div class='date'>Today</div>";                                   
                            }
                            else
                            {
                                $first_date = $second_date;
                                echo "<div class='date'>".$first_date."</div>";                                 
                            }
   
                        }                      
                        if($row['sender']==$senderid)
                        {
                          echo "<div class='sender msg' data-class='".$row['msg_id']."'>".$row['msg']." \t<div style='color:#ccc'>".date('H:i A',strtotime($row['time']))."</div></div>";
                          echo "<div style='clear:both' ></div>";
                        }
                        else
                        {
                          echo "<div class='reciever msg' data-class='".$row['msg_id']."'>".$row['msg']." \t<div style='color:#ccc'>".date('H:i A',strtotime($row['time']))."</div></div>";
                          echo "<div style='clear:both' ></div>";
                        
                        }
                      }
                      ?>
                  </div>
                
                </div>
                <div class="chat-footer">
                    
                    <textarea class="text" placeholder="Aa" maxlength="150"></textarea>
                    <button class="btn confirm send" > Send</button>
               
                </div>
            </div>


    <?php
    ob_end_flush();
}