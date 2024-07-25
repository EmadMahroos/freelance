<?php
ob_start();
session_start();

    if(isset($_SESSION['user'])||isset($_SESSION['client']))
    {
    include "init.php";

            include "messages.php";

                ?>
                <div class="get-started container ">
                    <div class="start-button-div ">
                        <a href="job_details.php?do=title" class="btn btn-success start-button"> make your job</a>
                    </div>
                    
                    
                </div>
         
        <div class="some-activities container">

            <?php
                $stmt = mysqli_query($con,"select finished_jobs.*,
                                     jobs.adding_date from finished_jobs
                                     inner join jobs on jobs.job_id = finished_jobs.job_id limit 5");
                $rows = $stmt->fetch_all(MYSQLI_ASSOC);
                if(mysqli_num_rows($stmt) <1)
                {
                    echo "<div class = 'alert text-center' style='color : red; font-weight:bold'> there is no finished jobs</div>";
                }                
                foreach($rows as $row)
                {
                    
                
                ?>    
                    <div class="finished_job row <?php echo 'job'.$row['job_id']?>" >
                        <div class="photo">
                        <i class="fas fa-arrow-circle-left next"></i>
                        <i class="fas fa-arrow-circle-right prev"></i>
                                <div class="all-photos">
                                    <?php
                                    $photos = $row['jobs_screenshoots'];
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
                        </div>

                        <div class="info col-md-6" data-class="<?php echo $counter; ?>">                      
                            <h1><?php echo $row['job_name'];?> </h1>
                            
                            <a href="<?php echo $row['job_link'];?> " class="btn confirm"> vist this website</a>
                            <div class="desc"> <?php echo $row['description']?></div>
                        </div>
                            <div class="job_date">
                                <span> from <span><?php echo $row['adding_date']?></span></span>
                                <span> to <span><?php echo $row['ending_date'];?> </span></span>
                            </div>             
                       <div class="col-12 com-d">
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
                ?>
        
        </div>
        <?php
        
                
        include $tpl . "footer.php";
        ob_end_flush();
    }
    else
    {
        include "init.php";
                ?>
                <div class="get-started container ">
                    <div class="start-button-div ">
                        <a href="login.php" class="btn btn-success start-button"> get started</a>
                    </div>
                    
                    
                </div>
        <div class="some-activities container">
            <?php
                $stmt = mysqli_query($con,"select finished_jobs.*,
                                     jobs.adding_date from finished_jobs
                                     inner join jobs on jobs.job_id = finished_jobs.job_id limit 5");
                $rows = $stmt->fetch_all(MYSQLI_ASSOC);
                if(mysqli_num_rows($stmt) <1)
                {
                    echo "<div class = 'alert text-center' style='color : red; font-weight:bold'> there is no finished jobs</div>";
                }  
                foreach($rows as $row)
                {
                    
                
                ?>    
                    <div class="finished_job row">
                        <div class="photo">
                        <i class="fas fa-arrow-circle-left next"></i>
                        <i class="fas fa-arrow-circle-right prev"></i>
                                <div class="all-photos">
                                    <?php
                                    $photos = $row['jobs_screenshoots'];
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
                        </div>                       
                        <div class="info col-md-6 "data-class="<?php echo $counter; ?>">
                            <h1><?php echo $row['job_name'];?> </h1>
                            
                            <a href="<?php echo $row['job_link'];?> " class="btn confirm"> vist this website</a>
 
                            <div class="desc"> <?php echo $row['description']?></div>
                       
                        </div>
                       <div class="job_date">
                                <span> from <span><?php echo $row['adding_date']?></span></span>
                                <span> to <span><?php echo $row['ending_date'];?> </span></span>
                        </div>                        
        
                       <div class="col-12">
                            <div class="row">
                                <a href="login.php"class=" col-12 confirm btn">
                                    add comment
                                </a>
                                <label class="show-comments col-12 " data-class="<?php echo $row['job_owner'];?>">
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
                ?>
        
        </div>
        
        <?php
                
        include $tpl . "footer.php";
        ob_end_flush();
        }
                include "contact_us.php";     
 ?>
 


