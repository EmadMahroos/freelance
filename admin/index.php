<?php
ob_start();
session_start();
if(isset($_SESSION['user']))
{

    include "init.php";

?>
		<div class="container text-center home-stat">
			<h1 style="margin-bottom: 50px;">Dashboard</h1>
			<div class="row">
				<div class="col-md-3 col-sm-6 col-sm-6 inf">
					<div class="stat st-clients">
						<i class="fa fa-users"></i>
						<div class="info">
							<a href="clients.php">
								Total clients
							<span><?php echo counter('clients','where reg_status=0') ;?></span>
							</a>
						</div>
					</div>
				</div>
				<div class="col-md-3 col-sm-6 inf ">
					<div  class="stat  st-pending">
						<i class="fa fa-tag"></i>
						<div class="info">
						
							<a href="jobs.php?do=pending">
								pending jobs
							<span><?php echo counter('jobs','where status=0') ;?></span>
							</a>							
							
						</div>

					</div>
				</div>				
				<div class="col-md-3 col-sm-6 inf ">
					<div  class="stat  st-jobs">
						<i class="fa fa-tags"></i>
						<div class="info">
							<a href="jobs.php">
								Total jobs

								<span><?php echo counter('jobs') ;?></span>
							</a>							
						</div>
					</div>
				</div>
				<div class="col-md-3 col-sm-6 inf">
					<div  class="stat  st-comments" >
						<i class="fa fa-comments"></i>						
						<div class="info">
							<a href="comments.php">
								Total comments
								<span><?php echo counter('comments') ;?></span>
							</a>	
						</div>
					</div>
				</div>				
			</div>
		</div>
        <div class="container latest" >
			<div class="row">
				<div class="col-md-6">
					<?php ?>
					<div class="card">
						<div class="card-header">
							<i class="fa fa-users"></i> latest registerd clients
							<span class="togglespan"><i class="fas fa-arrow-up"></i></span>
						</div>
						<div class="card-body">
                            <div class="latest-card">
                                <?php 
                                    $rows = getTable('*','clients','where reg_status = 0 order by client_id DESC limit 5');
                                    if(empty($rows[0]))
                                    {
                                        echo '<div class="alert text-center" style="color:red;font-weight:bold">no clients</div>';                                      
                                    }                                    
                                    foreach($rows as $row)
                                    {
                                        echo "<div class='clients'><a href ='clients.php?id=".$row['client_id']."#".$row['client_id']."' >".$row['client_name']."</a></div>";
                                        
                                    }
                                
                                ?>
                            </div>
						</div>
					</div>
				</div>
				<div class="col-md-6">
					<div class="card ">
						<div class="card-header">
							<i class="fa fa-tag"></i> latest jobs
							<span class="togglespan"><i class="fas fa-arrow-up"></i></span>

						</div>
						<div class="card-body itemscard">
                            <div class="latest-card">
                                <?php 
                                    $rows = getTable('*','jobs','order by job_id DESC limit 5');
                                    if(empty($rows[0]))
                                    {
                                        echo '<div class="alert text-center" style="color:red;font-weight:bold">no jobs</div>';                                       
                                    }                                    
                                    foreach($rows as $row)
                                    {
                                        if($row['status']==1)
                                        {
                                            if($row['finish']==1)
                                            {
                                            echo "<div class='jobs' ><a href ='jobs.php?do=finished_jobs&id=".$row['job_id']."#".$row['job_id']."'>".$row['job_name']."</a></div>";
                                                
                                            }
                                            else
                                            {
                                            echo "<div class='jobs' ><a href ='jobs.php?id=".$row['job_id']."#".$row['job_id']."'>".$row['job_name']."</a></div>";
                                             }                                   
                                        }
                                        else
                                        {
                                        echo "<div class='jobs'><a href ='jobs.php?do=pending&id=".$row['job_id']."#".$row['job_id']."'>".$row['job_name']."</a></div>";
                                            
                                        }
                                    }
                                
                                ?>
                            </div>
						</div>
					</div>
				</div>				
			</div>
			<div class="row">
				<div class="col-md-6">
					<?php ?>
					<div class="card">
						<div class="card-header">
							<i class="fa fa-comments"></i> latest comments
							<span class="togglespan"><i class="fas fa-arrow-up"></i></span>
						</div>
						<div class="card-body">
                            <div class="latest-card">
                                <?php
                                    $rows = getTable('*','comments','order by comment_id DESC limit 5');
                                    if(empty($rows[0]))
                                    {
                                        echo '<div class="alert text-center" style="color:red;font-weight:bold">no comments</div>';                                      
                                    }
                                    foreach($rows as $row)
                                    {
                                        echo "<div class='comments'><a href ='comments.php?id=".$row['comment_id']."#".$row['comment_id']."'>".$row['comment']."</a></div>";
                                        
                                    }
                                
                                ?>
                            </div>
						</div>
					</div>	
				</div>
				<div class="col-md-6">
					<div class="card ">
						<div class="card-header">
							<i class="fa fa-tag"></i> feedbacks
							<span class="togglespan"><i class="fas fa-arrow-up"></i></span>

						</div>
						<div class="card-body itemscard">
                            <div class="latest-card">
                                <?php
                                    $rows = getTable('*','finished_jobs','order by job_id DESC');
                                    $feedbacks_to_finished = mysqli_query($con,"select * from finished_jobs order by job_id DESC");
                                    $feeds_finished = $feedbacks_to_finished->fetch_all(MYSQLI_ASSOC);
                                    $feedbacks_to_jobs = mysqli_query($con,"select * from jobs order by job_id DESC");
                                    $feeds_jobs = $feedbacks_to_finished->fetch_all(MYSQLI_ASSOC);                                    
                                    $rows2 = getTable('*','jobs','order by job_id DESC');
                                    if(mysqli_num_rows($feedbacks_to_finished)==0&&mysqli_num_rows($feedbacks_to_jobs)==0)
                                    {
                                       echo '<div class="alert text-center" style="color:red;font-weight:bold">no feedbacks</div>';  
                                    }
                                    
                                    if(mysqli_num_rows($feedbacks_to_finished)>0)
                                    {

                                        foreach($rows as $row)
                                        {
                                            if(!empty($row['feedback']))
                                            {

                                                echo "<div class = 'comments' ><a href='jobs.php?do=finished_jobs&id=".$row['job_id']."#".$row['job_id']."'>";
                                                $feedback = explode(',',$row['feedback']);
                                                foreach($feedback as $val)
                                                {
                                                    $index =array_search($val,$feedback);
                                                    $index+=1;
                                                    echo "<div> $val <span class='index'>$index</span></div>";
                                                }
                                                
                                                
                                                echo "</a></div>";
                                            }
                                        }
                                    }
                                    if(mysqli_num_rows($feedbacks_to_jobs)>0)
                                    {
                                            
                                        foreach($rows2 as $row)
                                        {
                                            if(!empty($row['feedback'])&&$row['status']==1&&$row['finish']==0)
                                            {
            
                                                echo "<div class = 'comments' ><a href='jobs.php?do=manage&id=".$row['job_id']."#".$row['job_id']."'>";
                                                
                                                $feedback = explode(',',$row['feedback']);
                                                foreach($feedback as $val)
                                                {
                                                    $index =array_search($val,$feedback);
                                                    $index+=1;                                                    
                                                    echo "<div> $val <span class='index'>$index</span></div>";
                                                }
                                                echo "</a></div>";
                                            }
                                            if(!empty($row['feedback'])&&$row['status']==0)
                                            {
            
                                                echo "<div class = 'comments' ><a href='jobs.php?do=pending&id=".$row['job_id']."#".$row['job_id']."'>";
                                                
                                                $feedback = explode(',',$row['feedback']);
                                                foreach($feedback as $val)
                                                {
                                                    $index =array_search($val,$feedback);
                                                    $index+=1;                                                    
                                                    echo "<div> $val <span class='index'>$index</span></div>";
                                                }
                                                echo "</a></div>";
                                            }                                        
                                        }
                                        
                                    }                            
                                ?>
                            </div>
						</div>
					</div>
				</div>
				<div class="col-md-6">
					<div class="card ">
						<div class="card-header">
							<i class="fa fa-tag"></i> contacting to EHF
							<span class="togglespan"><i class="fas fa-arrow-up"></i></span>

						</div>
						<div class="card-body itemscard">
                            <div class="latest-card">
                                <?php 
                                    $rows = getTable('*','contacting','order by contact_id DESC');
                                    if(empty($rows[0]))
                                    {
                                       echo '<div class="alert text-center" style="color:red;font-weight:bold">no contacts</div>';                                       
                                    }
                                    else
                                    {
                                            
                                        foreach($rows as $row)
                                        {
                                        echo "<div class = 'comments' ><a href='contacts.php?contact_id=".$row['contact_id']."#".$row['contact_id']."'>".$row['sms']."</a></div>";
                                        }
                                    }
                            
                                ?>
                            </div>
						</div>
					</div>
				</div>	                 
				
			</div>
		</div>

<?php
        
include $tpl . "footer.php";
}
else
{
    header("location: login.php");
    exit();
}
ob_end_flush();
?>
