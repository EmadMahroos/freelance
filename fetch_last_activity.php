<?php
session_start();
$nonavbar='';
include"init.php";
              if(isset($_SESSION['user']))
              {
                $email = $_SESSION['user'];
                $reg_status="where reg_status= 0 or 1 and email !='$email'";

              }
              if(isset($_SESSION['client']))
              {
                $email = $_SESSION['client'];
                $reg_status=getTable("reg_status",'clients',"where email='$email'");
                if($reg_status[0]['reg_status']==1)
                {
                    $reg_status="where reg_status= 0 or 1 and email !='$email'";

                }
                else
                {
                    $reg_status="where reg_status=1";

                }
              }
                   $rows=getTable("*",'clients',"$reg_status  ");
                   $senderid=getTable("client_id",'clients',"where email='$email'");
                  foreach($rows as $row)
                  {
                 
                                ?><div class="admin"><?php                         
                              $current_time = date("Y-m-d H:i:s",time()-5);
                              $ddate=date($row['last_activity']);
                      if( $ddate >= $current_time)
                      {
                        $clientname = $row['client_name'];
                        ?>
          
                          <div class="admin-info" style="display: none">
                            <span class="client_id" data-class="<?php echo $row['client_id'];?>"></span>
                            <span class="sender_id" data-class="<?php echo $senderid[0]['client_id'];?>"></span>
                            <span class="client_name" data-class="<?php echo $clientname;?>"></span>
                          </div>
                          <img src="admin/uploads/imgs/8896_20180903_090911.jpg">
                          <?php
                            echo $row['client_name'];
                            echo'<div class="online-sign"></div>';
                          ?>
                    
                      <?php

                      }
                                  ?></div><?php
                  
                  }
                  foreach($rows as $row)
                  {
                 
                                ?><div class="admin"><?php                         
                              $current_time = date("Y-m-d H:i:s",time()-5);
                              $ddate=date($row['last_activity']);                 
                      if( $ddate < $current_time)
                      {
                        $clientname = $row['client_name'];
      
                        ?>

                          <div class="admin-info" style="display: none">
                            <span class="client_id" data-class="<?php echo $row['client_id'];?>"></span>
                            <span class="sender_id" data-class="<?php echo $senderid[0]['client_id'];?>"></span>
                            <span class="client_name" data-class="<?php echo $clientname;?>"></span>
                          </div>
                          <img src="admin/uploads/imgs/8896_20180903_090911.jpg">
                          <?php
                            echo $row['client_name'];
                          ?>

                      <?php
    
                      }
                     ?></div><?php
                      
                  
                  }
                  ?>
