<?php
   if(isset($_GET['comment'])&&isset($_GET['job_owner'])&&isset($_GET['job_id']))
   {
      $nonavbar="";
       include "init.php";
       if(isset($_SESSION['user'])||isset($_SESSION['client']))
       {
   
        $comment=filter_var($_GET["comment"],FILTER_SANITIZE_STRING);
        $job_id=filter_var($_GET["job_id"],FILTER_SANITIZE_NUMBER_INT);
        $comment_owner=filter_var($_GET["job_owner"],FILTER_SANITIZE_NUMBER_INT);
        if(!empty($comment))
        {
            $stmtinsert =
            mysqli_query($con,
                         "insert into comments(comment,adding_date,comment_owner,comment_job)
                                        values('$comment',now(),'$comment_owner','$job_id')");
            $jobowner = getTable("job_owner","jobs","where job_id='$job_id'");
            $job_owner = $jobowner[0]['job_owner'];
            $jobowneremail = getTable("email",'clients',"where client_id='$job_owner'");
            $job_owner_email=$jobowneremail[0]['email'];
            $comments_on_this_job=getTable("distinct comment_owner",'comments',"where (comment_job ='$job_id' and comment_owner !='$comment_owner')");
                $commentid = getTable("comment_id","comments","where comment_owner = '$comment_owner' and comment = '$comment' order by comment_id desc");
                $comment_id = $commentid[0]['comment_id'];
                $sendername = getTable("client_name","clients","where client_id = '$comment_owner'");
                $jobname = getTable("job_name","jobs","where job_id = '$job_id'");
               $job_name = $jobname[0]['job_name'];
                           $sender_name=$sendername[0]['client_name'];                

            foreach($comments_on_this_job as $commenter)
            {
                
               $reciever=$commenter['comment_owner'];
                $email = getTable("email","clients","where client_id = '$reciever'");
                 $reciever_email = $email[0]['email'];

            
            mysqli_query($con,"insert into notificationss(comment_id,notification_description,sender,sender_name,reciever,reciever_email,job_id)
                                        values('$comment_id','$sender_name : $comment on $job_name ','$comment_owner','$sender_name','$reciever','$reciever_email','$job_id')");
            }
            if($comment_owner != $job_owner )
            {
                mysqli_query($con,"insert into notificationss(comment_id,notification_description,sender,sender_name,reciever,reciever_email,job_id)
                                      values('$comment_id','$sender_name : $comment on $job_name ','$comment_owner','$sender_name','$job_owner','$job_owner_email','$job_id')");
            }
            echo "<div class='comment' style='background:#94d478'>".$comment."</div>";
            echo "<div style='display:none'>";
            exit($_GET['comment']);
            exit($_GET['job_id']);
            exit($_GET['job_owner']);
            echo "</div>";        
          
        }
       
       }      
   }
   else
   {
         if(isset($_GET['information'])&&$_GET['column']&&$_GET['id'])
         {
               session_start();
               $nonavbar="";
                     include 'init.php';
               
                $client_idd=$_GET['id'];
               $info=  $_GET['information'];
               $col=filter_var($_GET['column'],FILTER_SANITIZE_STRING);
               $errors=array();
               $informations = getTable('*','clients',"where client_id = '$client_idd'");               
                if($info==$informations[0][$col]){$errors[]="no update";}
                if($col=="client_name")
                {
                     $info=filter_var($info,FILTER_SANITIZE_STRING);
                    if(strlen($info)<4)
                    {
                        $errors[]="your name must be more than 4 character";
                    }
            
                }
               if($col=="address")
                {
                     $info=filter_var($info,FILTER_SANITIZE_STRING);
                    if(strlen($info)<10)
                    {
                        $errors[]="your address must be more than 10 character";
                    }
            
                }
               if($col=="phone_number")
                {
                     $info=filter_var($info,FILTER_SANITIZE_STRING);
                    if(strlen($info)!=11)
                    {
                        $errors[]="your phone number must be 11 character";
                    }
            
                }     
                if($col=="email")
                {
                    $info=filter_var($info,FILTER_SANITIZE_EMAIL);
                    if(strpos($info,'@')!=true)
                    {
                        $errors[]="this not form of email";
                    }
                    else
                    {
                     echo '<div style="display:none">';
                     if(isset($_SESSION['client']))
                     {
                        echo $_SESSION['client']=$info;
                     }
                     if(isset($_SESSION['user']))
                     {
                        echo $_SESSION['user']=$info;
                        
                     }
                        echo '</div>';
                    }
                }
                if(empty($errors))
                {
                  $stmt = mysqli_query($con,"update clients set $col = '$info' where client_id='$client_idd'" );
                  if(mysqli_affected_rows($con)>0)
                  {
                     echo "<div class='alert text-center' style='color:#28a745;font-weight:bold;'><i class='fas fa-check'></i> updated</div>";
            
            
                  }
            
                }
                else
                {
                  foreach($errors as $error)
                  {
                     echo "<div class='alert text-center' style='color:red;font-weight:bold'> <i class='fas fa-exclamation-triangle'></i> ".$error."</div>";
            
            
                  }
                }
            
               echo '<div style="display:none">';
               exit($_GET['id']);
               exit($_GET['column']);
               exit($_GET['information']);
               echo '</div>';
            include $tpl."footer.php";
         
         }
         else
         {
         
         
               ob_start();
               session_start();
               if(isset($_SESSION['client'])||isset($_SESSION['user']))
               {
                  
                  include "messages.php";
                   include "init.php";

                   $client_id=isset($_GET['client_id'])?intval($_GET["client_id"]):0;
                   $reg_statuss = getTable('reg_status,logo',"clients","where client_id='$client_id'");
                   $logo=$reg_statuss[0]['logo'];
                   $reg_statuss=$reg_statuss[0]['reg_status']; 
                   ?>
                   <h1 class="text-center">My Profile</h1>
                   <div class="container">
<input type="text" id='crpimg' name="url" style="display: none"/>
		<div class="row pic_div pic-div-profile" style="margin: auto !important">
			<div class="col-md-12 ">
				<div class="image_area">
						<label for="upload_image" style="position: relative">
							<img src="admin/uploads/imgs/<?php echo $logo ?>" id="uploaded_image" class="pic img-thumbnail pic-profile"/>
							<div class="overlay overlay-profile">
								<div class="text1 text1-profile">
									 profile image

								</div>
										<input type="file" class="image" id="upload_image"  style="display: none"/>

							</div>
						</label>

				</div>
			</div>
		</div>
		<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header" style="color: #28a745 ;">
        <h5 class="modal-title" id="exampleModalLongTitle">crop image before upload</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color: #28a745 ;" id="clos">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
								<div class="row">
									<div class="col-md-8" style="min-height:400px">
											<img src="admin/uploads/imgs/30237_IMG_20200812_223553.jpg" id="sample_image" style="width: 100%;"/>
									</div>
									<div class="col-md-4 ">
										<div class="preview"></div>
									</div>
							</div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal" id="clo">Close</button>
        <button type="button" class="btn btn-primary" id="crop">crop and save</button>
      </div>
    </div>
  </div>
</div>
                     <?php
                     if(isset($_SESSION['client']))
                     {
                        $email=$_SESSION['client'];
                     }
                     if(isset($_SESSION['user']))

                     {
                        $email=$_SESSION['user'];
                        
                     }
                   $client_id_for_session= getTable('client_id,reg_status',"clients","where email='$email'");
                   $client_ids=$client_id_for_session[0]['client_id'];
                   $regstatuss=$client_id_for_session[0]['reg_status'];
                   if($client_ids == $client_id || $regstatuss == 2)
                   {
                     ?>
                   <div class="show"></div>
               
                       <div class="information block">
                           <div class="card">
                             <div class="card-header">
                               <b>my information</b>
                             </div>
                             <div class="card-body">
                              <i class="id" data-class="<?php echo $client_id;?>"></i>
                               <?php
                           $informations = getTable('*','clients',"where client_id = '$client_id'");               
                               echo "<div><span><i class = 'fas fa-unlock'></i>username</span> <span >:<i class='data' contenteditable='true' data-class='client_name'>" . $informations[0]['client_name'] . '</i></span></div>';
                               echo "<div><span><i class='far fa-envelope'></i>email</span> <span>:<i class='data' contenteditable='true' data-class='email'>" . $informations[0]['email'] . '</i></span></div>';
                               echo "<div><span><i class = 'fas fa-user'></i>Address </span><span>:<i class='data' contenteditable='true' data-class='address'>" . $informations[0]['address'] . '</i></span></div>';
                               echo "<div><span><i class = 'fa fa-calendar-alt'></i>Sign up Date </span><span>:<i>" . $informations[0]['start_date'] . '</i></span></div>';
                               echo "<div><span><i class = 'fas fa-tags'></i>phone number</span><span>:<i class='data' contenteditable='true' data-class='phone_number'>" .$informations[0]['phone_number'].'</i></span></div>';
               
                               ?>
                               
                             </div>
                           </div>
                       </div>
               <div class="some-activities container">
                  
               
                                       <div class="profile-logo-div row" >
                                          <div class="col-12">
                                         <ul class="profile-logo plo" style="padding: 0px; ">
                                           <li>
                                            <h1 class="last-projects"> my jobs</h1>
                                             
                                             <ul class="profile-logo-options">
                                               <li><a class="finished_jobs">finished jobs</a></li>
                                               <li><a class="under_working_jobs"> under working jobs</a></li>
                                               <li><a class="waiting_jobs"> waiting jobs</a></li>
                                             </ul>                            
                                           </li>
                                         </ul>                              
                                          </div>
                                      </div>
               
                                   
               
                   <?php
                   if(isset($_SESSION['photos_name']))
                   {
                     unset($_SESSION['photos_name']);
                   }
               $rows=getTable("*","jobs","where job_owner='$client_id'");
               $i=0;
               $v=0;
               $c=0;
                       foreach($rows as $row)
                       {
                         $job_id=$row['job_id'];
                         $job_owner = $row['job_owner'];
                        if($row['status']==1&&$row['finish']==0)
                        {
               $i++;
                           
                        
                       
                       ?>    
                           <div class="finished_job1  finished_job row ">
                              <?php
                              if(!empty($row['photos']))
                              {
                              ?>
                               <div class="photo">
                        <i class="fas fa-arrow-circle-left next"></i>
                        <i class="fas fa-arrow-circle-right prev"></i>
                                       <div class="all-photos">
                                           <?php
                                           $photos = $row['photos'];
                                           $photos_array=explode(',',$photos);
                                               $counter =0;
               
                                           foreach($photos_array as $photo)
                                           {
                                           
                                           ?>
                                           <img src="admin/uploads/imgs/<?php echo $photo; ?>">
                                           <?php
                                           $counter+=1;
                                           }
                                           ?>
                                       </div>
                                      <div style="width: 165px;margin: auto;text-align:center ">
                                        <b style="color: #28a745">
                                          under_working_job<br>
                                          <progress value="<?php echo $row['progress']?>" max=100 style="width: 150px"></progress><br>
                                          <a href="feedback.php?do=edit&job_id=<?php echo $row['job_id'];?>&job_owner=<?php echo $row['job_owner'];?>" class="btn btn-success feedback"> send feedback</a>
                                        </b>
                                      </div>                                                                             
                               </div>
                               <?php
                              }
                              else
                              {
                                 echo '<div class="alert alert-danger"style="width:300px; height:300px;text-align: center;background: #a5a5a5; margin:auto">
                                 <b>no files</b>';
                                 ?>
                                <div style="width: 165px;margin: auto;text-align:center ">
                                  <b style="color: #28a745">
                                    under_working_job<br>
                                    <progress value="<?php echo $row['progress']?>" max= "100"style="width: 150px"></progress><br>
                                    <a href="feedback.php?do=edit&job_id=<?php echo $row['job_id'];?>&job_owner=<?php echo $row['job_owner'];?>" class="btn btn-success feedback"> send feedback</a>
                                  </b>
                                </div>
                                <?php                                 
                                 echo '<br>
                                 </div>';

                              }
                        
                               ?>
                               <div class="info col-md-6"data-class="<?php echo $counter; ?>">
                                   <h1><?php echo $row['job_name'];?> </h1>
                                  <div class="desc"> <?php echo $row['job_description']?></div>                
                               </div>
                              <div class="job_date">
                                       <span> from <span><?php echo $row['adding_date']?></span></span>
                              </div>
                           </div>
                       <?php

                        }
                        if($row['status']==0)
                        {
                        $v++;       
                        
                       
                       ?>    
                           <div class="finished_job2 finished_job row">
                              <?php
                              if(!empty($row['photos']))
                              {
                              ?>
                               <div class="photo">
                        <i class="fas fa-arrow-circle-left next"></i>
                        <i class="fas fa-arrow-circle-right prev"></i>
                                       <div class="all-photos">
                                           <?php
                                           $photos = $row['photos'];
                                           $photos_array=explode(',',$photos);
                                               $counter =0;
               
                                           foreach($photos_array as $photo)
                                           {
                                           
                                           ?>
                                           <img src="admin/uploads/imgs/<?php echo $photo; ?>">
                                           <?php
                                           $counter+=1;
                                           }
                                           ?>
                                       </div>
                                      <div style="width: 165px;margin: auto;text-align:center ">
                                        <b style="color: red">
                                          waiting_job<br>
                                          <progress style="width: 150px"></progress><br>
                                          <a href="feedback.php?do=edit&job_id=<?php echo $row['job_id'];?>&job_owner=<?php echo $row['job_owner'];?>" class="btn btn-success feedback"> send feedback</a>
                                        </b>
                                      </div>                                         
                               </div>
                               <?php
                              }
                              else
                              {
                                 echo '<div class="alert alert-danger"style="width:300px; height:300px;text-align: center;background: #a5a5a5; margin:auto"> <b>no files</b>';
                                 ?>
                                <div style="width: 165px;margin: auto;text-align:center ">
                                  <b style="color: red">
                                    waiting_job<br>
                                    <progress style="width: 150px"></progress><br>
                                    <a href="feedback.php?do=edit&job_id=<?php echo $row['job_id'];?>&job_owner=<?php echo $row['job_owner'];?>" class="btn btn-success feedback"> send feedback</a>
                                  </b>
                                </div>
                                <?php                                    
                                 echo '</div>';
                              
                              }
                        
                               ?>
                               <div class="info col-md-6"data-class="<?php echo $counter; ?>">
                               
                                   <h1><?php echo $row['job_name'];?> </h1>
                                  <div class="desc"> <?php echo $row['job_description']?></div>                
                                                       
                               </div>
                              <div class="job_date">
                                 <span> from <span><?php echo $row['adding_date']?></span></span>
                              </div>                                    
                           </div>
                       <?php          
                        }
                        
                        if($row['finish']==1)
                        {
                          
                         $c++;
                           $stmt6 = mysqli_query($con,"select * from finished_jobs where job_id= $job_id");
                           $rows6 = $stmt6->fetch_all(MYSQLI_ASSOC);
                               ?>
                     <div class="finished_job finished_job3 row <?php echo 'job'.$rows6[0]['job_id']?>">
                                            <div class="photo">                                          
                                                <i class="fas fa-arrow-circle-left next"></i>
                                                <i class="fas fa-arrow-circle-right prev"></i>
                                                    <div class="all-photos">
                                                        <?php
                                                        $photos = $rows6[0]['jobs_screenshoots'];
                                                        $photos_array=explode(',',$photos);
                                                            $counter =0;
                            
                                                        foreach($photos_array as $photo)
                                                        {
                                                      
                                                        ?>
                                                        <img src="admin/uploads/imgs/<?php echo $photo; ?>">
                                                        <?php
                                                        $counter+=1;
                                                        }
                                                        ?>
                                                    </div>
                                                    <div style="width: 165px;margin: auto;text-align:center ">
                                                      <b style="color: #28a745">
                                                        finished<br>
                                                        <progress value=100 max=100 style="width: 150px"></progress><br>
                                                        <a href="feedback.php?do=feedback&job_id=<?php echo $row['job_id'];?>&job_owner=<?php echo $row['job_owner'];?>" class="btn btn-success feedback"> send feedback</a>
                                                      </b>
                                                    </div>                 
                                            </div>
                                            <div class="info col-md-6"data-class="<?php echo $counter; ?>">
                                                <h1><?php echo $rows6[0]['job_name'];?> </h1>
                                                
                                                <a href="<?php echo $rows6[0]['job_link'];?> " class="btn confirm"> vist this website</a>
                                                <div class="desc"> <?php echo $rows6[0]['description']?></div>                
                                            </div>
                                                <div class="job_date">
                                                    <span> from <span><?php echo $row['adding_date']?></span></span>
                                                    <span> to <span><?php echo $rows6[0]['ending_date'];?> </span></span>
                                                </div>                                               
                           <div class="col-12">
                            <div class="row">
                                <label class="add_comment col-12">
                                    add comment
                                </label>
                                <?php
                                    if(isset($_SESSION['client']))
                                    {
                                                $email=$_SESSION['client'];

                                    }
                                    
                                    if(isset($_SESSION['user']))
                                    {
                                                $email=$_SESSION['user'];

                                    }
                                   $rows=  getTable("*","clients","where email = '$email'");
                                   $client_idc=$rows[0]['client_id'];                                
                                ?>
                                <label class="show-comments col-12 " data-class="<?php echo $client_idc;?>">
                                    comments
                                </label>
                                
                                <textarea class="form-control hiddentextarea col-10" placeholder="Add comment" data-class="<?php echo $row['job_id'];?>"></textarea>
                                <button  class="btn btn-primary  comm_btn col-2" >Add</button>
                                <div class="comments col-12">
                                    <?php
                                    $job_id=$row['job_id'];
                                    $job_owner=$row['job_owner'];                            
                                    $commentsrows =  getTable("*",'comments',"where comment_job='$job_id' order by comment_id desc");
                                    foreach($commentsrows as $commentrow)
                                    {
                                        echo "<div class='comment'> ".$commentrow['comment']."<div style='font-size:12px;text-align:center'>".date("y:m:d H:i A" , strtotime($commentrow['adding_date']))."</div></div>";
                                    }
                                    ?>                            
                                </div>
                                
                                
                            </div>
        
                        </div>
                           
                     </div>
                                 <?php
                        }
                                 
               
                       }
                       
                       
                       ?>
                       <div class="i" data-class="<?php echo $i;?>"></div>
                       <div class="c" data-class="<?php echo $c;?>"></div>
                       <div class="v" data-class="<?php echo $v;?>"></div>

               </div>        
               <?php
                   }
                   else
                   {
                     echo " <div class='alert text-center' style='color:red;font-weight:bold'> <i class='fas fa-exclamation-triangle'></i> you have no permission to visit this page</div>";
                   }
               

               ?>

                   </div>    
               <?php

                       include "contact_us.php";
               
                   include $tpl."footer.php";
               }
               else
               {
                   header("location: login.php");
                   exit();    
               }

               ob_end_flush();
               
         }
   }
?>