<?php
ob_start();
session_start();
    include"init.php";
    $do = isset($_GET['do'])?$_GET['do']:'manage';
    $jobid = isset($_GET['job_id'])?$_GET['job_id']:'0';
     if($do== 'manage')
    {
        if(isset($_SESSION['user'])||isset($_SESSION['client']))
        {
        include "messages.php";
        }
            ?>
            <div class="container">

<div class="some-activities container">
            <?php
                $stmt_jobs = mysqli_query($con,"select finished_jobs.*,
                                     jobs.adding_date from finished_jobs
                                     inner join jobs on jobs.job_id = finished_jobs.job_id");
                $finished_jobs = $stmt_jobs->fetch_all(MYSQLI_ASSOC);
                if(mysqli_num_rows($stmt_jobs) <1)
                {
                    echo "<div class = 'alert text-center' style='color : red;font-weight:bold'> there is no finished jobs</div>";
                }
                foreach($finished_jobs as $finished_job)
                {
                    
                
                ?>    
                    <div class="finished_job row <?php echo 'job'.$finished_job['job_id']?>"  id="job<?php echo $finished_job['job_id']?>">
                        <div class="photo">
                            <i class="fas fa-arrow-circle-left next"></i>
                        <i class="fas fa-arrow-circle-right prev"></i>
                                <div class="all-photos">
                                    <?php
                                    $photos = $finished_job['jobs_screenshoots'];
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
                        <div class="info col-md-6"data-class="<?php echo $counter; ?>">
                            <h1><?php echo $finished_job['job_name'];?> </h1>
                            
                            <a href="<?php echo $finished_job['job_link'];?> " class="btn confirm"> vist this website</a>
                            <div class="desc"> <?php echo $finished_job['description']?></div>                
                        </div>
                            <div class="job_date">
                                <span> from <span><?php echo $finished_job['adding_date']?></span></span>
                                <span> to <span><?php echo $finished_job['ending_date'];?> </span></span>
                            </div>                           
        
                       <div class="col-12">
                            <div class="row">
                                <?php
                                if(isset($_SESSION['user'])||isset($_SESSION['client']))
                                {
                                ?>
                                <label class="add_comment col-12">
                                    add comment
                                </label>
                                
                                
                                
                                <?php
                                }
                                else
                                {
                                    ?>
                                    
                                    <a href="login.php" class="btn confirm col-12"> add comment</a>
                                    <?php
                                }
                                    if(isset($_SESSION['client']))
                                    {
                                                $email=$_SESSION['client'];
                                   $client=  getTable("*","clients","where email = '$email'");
                                   $client_idc=$client[0]['client_id'];        
                                    }
                                    
                                    if(isset($_SESSION['user']))
                                    {
                                                $email=$_SESSION['user'];
                                   $client=  getTable("*","clients","where email = '$email'");
                                   $client_idc=$client[0]['client_id'];        
                                    }
                        
                                ?>
                                <label class="show-comments col-12 " data-class="<?php if(isset($client_idc)){echo $client_idc;}?>">
                                    comments
                                </label>
                                
                                <textarea class="form-control hiddentextarea col-10" placeholder="Add comment" data-class="<?php echo $finished_job['job_id'];?>"></textarea>
                                <button  class="btn btn-primary  comm_btn col-2" >Add</button>
                                <div class="comments col-12">
                                    <?php
                                    $job_id=$finished_job['job_id'];
                                    $job_owner=$finished_job['job_owner'];                            
                                    $commentsrows =  getTable("*",'comments',"where comment_job='$job_id' order by comment_id desc");
                                    $c_id=isset($_GET['comment_id'])?intval($_GET['comment_id']):0;
                                    foreach($commentsrows as $commentrow)
                                    {
                                        if($commentrow['comment_id']==$c_id)
                                        {
                                        echo "<div class='comment' id='".$commentrow['comment_id']."' style='background:#94d478'> ".$commentrow['comment']."<div style='font-size:12px;text-align:center'>".date("y:m:d H:i A" , strtotime($commentrow['adding_date']))."</div></div>";
                                            
                                        }
                                        else
                                        {
                                        echo "<div class='comment' id='".$commentrow['comment_id']."'> ".$commentrow['comment']."<div style='font-size:12px;text-align:center'>".date("y:m:d H:i A" , strtotime($commentrow['adding_date']))."</div></div>";
                                            
                                        }
                                        
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
                
            </div>

            <?php
    }
    include "contact_us.php";

    include $tpl ."footer.php";
ob_end_flush();
?>