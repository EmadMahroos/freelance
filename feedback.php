<?php
ob_start();
session_start();

if(isset($_POST['name']))
{
if(isset($_SESSION['photos_name']))
{
    $arr=explode(',',$_SESSION['photos_name']);
    
}
 $item= $_POST['name'];
    $index = array_search($item,$arr);
    unset($arr[$index]);
     $_SESSION['photos_name']=implode(',',$arr);
     
        
        

    
}
else
{
if(isset($_SESSION['user'])||isset($_SESSION['client']))
{

    include"init.php";
    $do = isset($_GET['do'])?$_GET['do']:'0';
    if($do== 'edit')
    {


        $job_id =isset($_GET['job_id'])&& is_numeric($_GET['job_id'])?intval($_GET['job_id']):0;
        $job_owner =isset($_GET['job_owner'])&& is_numeric($_GET['job_owner'])?intval($_GET['job_owner']):0;
        $stmt = mysqli_query($con,"select * from jobs where job_id=$job_id");
        $row2= $stmt->fetch_row();
    ?>

            <div class="container">
            <h1 class ='text-center'> send a feedback</h1>
                <form class="myform1" action="?do=update&job_id=<?php echo $job_id ;?>&job_owner=<?php echo $job_owner;?>" method="post" enctype="multipart/form-data">
                    <div class="form-groub">
                        <label>job_name</label>
                        <input type="text" class="form-control" name="job_name" value="<?php echo $row2['1'];?>">  
                    </div>
                    <div class="form-groub">
                        <label>job_description</label>
                        <input type="text" class="form-control"name="job_description" value="<?php echo $row2['2'];?>">  
                    </div>
                     <label>attached files</label>
    <?php

   if(isset($_SESSION['photos_name'])&&!empty($_SESSION['photos_name']))
   {
      if(!empty($_SESSION['photos_name']))
      {

                            echo "<div class='row'>";
    
                              $files = explode(',',$_SESSION['photos_name']);
                              foreach($files as $file)
                              {
                               $fnam1 = explode('.',$file);
                                  $extension=end($fnam1);
                                  if($extension=='txt')
                                  {
                                   
                                   
                                   echo "<div class='col-3 confirm file ' data-class='".$file."'   style='padding:56px;margin-left:30px;margin-bottom:10px;text-align:center;box-sizing:border-box;' >";
                                     echo '<i class="fas fa-window-close file-close" ></i>';
                                     echo "<b>".$file."</b>";
                                   echo "</div>";
    
                                  }
                                  else
                                  {
                                   echo "<div class='show'></div>";
                                   echo "<div class='col-3 file'  data-class='".$file."' style='padding:0px;margin-left:10px;margin-bottom:10px'>";
                                      echo '<i class="fas fa-window-close file-close"></i>';
                                   
                                      echo "<img src='admin/uploads/imgs/".$file."' style='width:100%;height:150px'/>";
                                   echo "</div>";                               
                                  }
                                  
                              }
                             echo "</div>";
      }
      else
      {
       echo "<p><b>No Files Uploaded</b></p>";
      }

                         

   }
   
      if(!isset($_SESSION['photos_name']))
     {
      $_SESSION['photos_name']=$row2['7'];
      
        if(!empty($_SESSION['photos_name']))
      {

       echo "<div class='row'>";
   
                                $files = explode(',',$row2['7']);
                                foreach($files as $file)
                                {
                                    $fnam = explode('.',$file);
                                    $extension=end($fnam);
                                    if($extension=='txt')
                                    {
                                     
                                     
                                     echo "<div class='col-3 confirm file ' data-class='".$file."'   style='padding:56px;margin-left:30px;margin-bottom:10px;text-align:center;box-sizing:border-box;' >";
                                       echo '<i class="fas fa-window-close file-close" ></i>';
                                       echo "<b>".$file."</b>";
                                     echo "</div>";
      
                                    }
                                    else
                                    {
                                     echo "<div class='show'></div>";
                                     echo "<div class='col-3 file'  data-class='".$file."' style='padding:0px;margin-left:10px;margin-bottom:10px'>";
                                        echo '<i class="fas fa-window-close file-close"></i>';
                                     
                                        echo "<img src='admin/uploads/imgs/".$file."' style='width:100%;height:150px'/>";
                                     echo "</div>";                               
                                    }
                                    
                                }
                               echo "</div>";
      }
      else
      {
       echo "<p><b>No Files Uploaded</b></p>";
       
      }

   }
     
                         
  
                              ?>
  
                      <div class="form-groub">
                          <label>photos</label>
                          <input type="file" class="form-control"name="file[]" multiple>  
                      </div>
                      <div class="form-groub">
                        <label>FeedBack</label>
                        <textarea class="form-control" name="feedback" required ></textarea>
                        <b>what's your Edit or what are you want to modify</b>
                      </div>
                        <label>Budget</label>

                    <div class="form-group row">
                        <div class="col-3 radio-div">
                        <input type="radio" name="paying"  value="1" <?php if($row2['6']==1){echo 'checked';}?>>
                        <p>hello</p>                            
                        </div>
                        <div class="col-3 radio-div">
                        <input type="radio" name="paying"  value="2" <?php if($row2['6']==2){echo 'checked';}?>>
                        <p>hello</p>                            
                        </div>

                        <div class="col-3 radio-div">
                        <input type="radio" name="paying"  value="3" <?php if($row2['6']==3){echo 'checked';}?>>
                        <p>hello</p>                            
                        </div>

                    </div>                      
                    <button type="submit" class="btn btn-success mb-2 confirm" name="confirm">Confirm data</button>
                </form>
            </div>
            
    <?php        
        
     
    }
if($do == 'update')
    {
        if($_SERVER['REQUEST_METHOD']=='POST')
        {
         ?>
            <div class="container">
               <h1 class="text-center">updating data</h1>
                
           <?php
           
            $job_id =isset($_GET['job_id'])&& is_numeric($_GET['job_id'])?intval($_GET['job_id']):0;
              $job_name = filter_var($_POST['job_name'],FILTER_SANITIZE_STRING);
              $feedback = filter_var($_POST['feedback'],FILTER_SANITIZE_STRING);
              $check=$feedback;
              $old_feedback = getTable("feedback","jobs","where job_id =$job_id");
              if(!empty(trim($old_feedback[0]['feedback'])))
              {
              $feedback = $old_feedback[0]['feedback'].','.trim($feedback);
              }
              $job_description = filter_var($_POST['job_description'],FILTER_SANITIZE_STRING);
               $job_owner =isset($_GET['job_owner'])&& is_numeric($_GET['job_owner'])?intval($_GET['job_owner']):0;
              $budget = filter_var($_POST['paying'],FILTER_SANITIZE_NUMBER_INT);
              $oldphotos=filter_var($_SESSION['photos_name'],FILTER_SANITIZE_STRING);
                $errors = array();

        if($_FILES['file']['size'][0]!=0)
         {
           $extensions =array("gif","jpeg","png",'txt',"jpg"); 
           foreach($_FILES['file']['name'] as $key =>$val)
           {

            if($_FILES['file']['size'][$key] > 4000000)
            {
               $errors[] = "<div class='alert text-center' style='color:red;font-weight:bold'> <i class='fas fa-exclamation-triangle'></i> ".$val." size is more than 4 MG </div>";
            }
            $fnam3 = explode(".",$val);
            $extension = strtolower(end($fnam3));
            
            if(!in_array($extension,$extensions))
            {
               $errors[] = "<div class='alert text-center' style='color:red;font-weight:bold'> <i class='fas fa-exclamation-triangle'></i>".$extension."  is not allowed extension </div>";
            }
           }
         }
                    if($_FILES['file']['size'][0]!=0)
                     {
                        $photos_array=array();
                                    foreach($_FILES['file']['name'] as $key =>$val)
                                    {
                                        $name=rand(0,100000)."_".$val;
                                        $tmp_name=$_FILES['file']['tmp_name'][$key];
                                        if(move_uploaded_file($tmp_name,'admin\uploads\imgs\\'.$name))
                                        {
                                            $photos_array[]=$name;
                                        }
                                        else
                                        {
                                            $errors[] = "<div class='alert text-center' style='color:red;font-weight:bold'> <i class='fas fa-exclamation-triangle'></i>".$val."  unread</div>";
                                        }
                                    }
                                    $newphotos=implode(',',$photos_array);
                                    if(!empty($oldphotos))
                                    {
                                        $allphotos=$oldphotos.','.$newphotos;
                                    }
                                    else
                                    {
                                        $allphotos=$newphotos;
                                    }
                     }
                     else
                     {
                        $allphotos=$oldphotos;
                    }
      
                    if(empty($job_name)){$errors[]= '<div class = "alert text-center" style="color:red;font-weight:bold"> <i class="fas fa-exclamation-triangle"></i> you cannot leave job\'s name empty</div>';}
                    if(empty($check)){$errors[]= '<div class = "alert text-center" style="color:red;font-weight:bold"> <i class="fas fa-exclamation-triangle"></i> you cannot leave feedback empty</div>';}
                    if(empty($job_description)){$errors[]= '<div class = "alert text-center" style="color:red;font-weight:bold"> <i class="fas fa-exclamation-triangle"></i> you cannot leave job\'s description empty</div>';}
                    if(strlen($job_name)<3){$errors[]= '<div class = "alert text-center" style="color:red;font-weight:bold"> <i class="fas fa-exclamation-triangle"></i> you cannot leave job\'s name less than 3 character</div>';}
                    if(strlen($check)<10){$errors[]= '<div class = "alert text-center" style="color:red;font-weight:bold"> <i class="fas fa-exclamation-triangle"></i> you cannot leave feedback less than 10 character</div>';}
                    if(strlen($job_description)<100){$errors[]= '<div class = "alert text-center" style="color:red;font-weight:bold"> <i class="fas fa-exclamation-triangle"></i> you cannot leave job\'s description less than 100 character</div>';}
    
                    if(empty($errors))
                    {
                     

                        $stmt2= mysqli_query($con,"update jobs set budget ='$budget',feedback='$feedback',job_name ='$job_name',job_description ='$job_description' ,photos='$allphotos',budget='$budget' where job_id =$job_id");
                        if($num=mysqli_affected_rows($con)>0){
                             echo '<div class="alert text-center" style="color:#28a745;font-weight:bold"><i class="fas fa-check"></i> one job updated , you will redirect to your profile</div>';
                              redirect('',5,"profiles.php?client_id=$job_owner");                            

                        }
                        else
                        {
                            echo '<div class="alert text-center" style="color:red;font-weight:bold"><i class="fas fa-exclamation-triangle"></i> no update</div>';
                              redirect();                            
                        }
                    }
                    else
                    {
                        
                        foreach($errors as $error)
                        {
                            echo $error;
    
                        }
    
                        redirect();
    
    
                    }
                    
                
                    
                
        }
        else
        {
        
            redirect();
        }

              ?>
              
            </div>
            <?php
            
        
    }
    if($do=='feedback')
    {
        $job_id =isset($_GET['job_id'])&& is_numeric($_GET['job_id'])?intval($_GET['job_id']):0;
        $job_owner =isset($_GET['job_owner'])&& is_numeric($_GET['job_owner'])?intval($_GET['job_owner']):0;
        
        $stmt = mysqli_query($con,"select * from finished_jobs where job_id=$job_id");
        $row2= $stmt->fetch_row();        
        ?>
            <div class="container">
                <h1 class ='text-center'> send a feedback</h1>
                <form class="myform1" action="?do=sendfeedback&job_id=<?php echo $job_id ;?>&job_owner=<?php echo $job_owner ;?>" method="post" enctype="multipart/form-data">
                      <div class="form-groub">
                        <textarea class="form-control" name="feedback"required></textarea>
                        <b>what's your feedback about your job</b>
                      </div>
                    <button type="submit" class="btn btn-success mb-2 confirm" name="confirm">Confirm data</button>
                      
                </form>
            </div>
           <?php         
    }
    if($do=='sendfeedback')
    {
         ?>
            <div class="container">
               <h1 class="text-center">sent</h1>
               <?php
                        $job_id =isset($_GET['job_id'])&& is_numeric($_GET['job_id'])?intval($_GET['job_id']):0;
                        $job_owner =isset($_GET['job_owner'])&& is_numeric($_GET['job_owner'])?intval($_GET['job_owner']):0;
                
                        if(isset($_SERVER['REQUEST_METHOD'])=='post')
                        {
                            $feedback=filter_var($_POST['feedback'],FILTER_SANITIZE_STRING);
                            $old_feedback = getTable("feedback","finished_jobs","where job_id =$job_id");
                            if(!empty(trim($old_feedback[0]['feedback'])))
                            {
                             $check = $feedback;
                            $feedback = $old_feedback[0]['feedback'].','.trim($feedback);
                            }                            
                            $errors=array();
                            if(empty($check)){$errors[]= '<div class = "alert text-center" style="color:red;font-weight:bold"> <i class="fas fa-exclamation-triangle"></i> you cannot leave feedback empty</div>';}
                            if(strlen($check)<10){$errors[]= '<div class = "alert text-center" style="color:red;font-weight:bold"> <i class="fas fa-exclamation-triangle"></i> you cannot leave feedback less than 10 character</div>';}
                            if(empty($errors))
                            {
                    
                                $stmt2= mysqli_query($con,"update finished_jobs set feedback='$feedback' where job_id =$job_id");
                                if($num=mysqli_affected_rows($con)>0){
                                     echo '<div class="alert text-center" style="color:#28a745;font-weight:bold;"><i class="fas fa-check"></i> one job updated , you will redirect  to your profile now</div>';
                                      redirect('',5,"profiles.php?client_id=$job_owner");                            
                    
                                }
                                else
                                {
                                    echo '<div class="alert text-center" style="color:red;font-weight:bold"> <i class="fas fa-exclamation-triangle"></i>  no update</div>';
                                      redirect();                            
                                }
                            }
                            else
                            {
                                
                                foreach($errors as $error)
                                {
                                    echo $error;
                    
                                }
                    
                                redirect();
                    
                    
                            }
                        }
                        else
                        {
                            redirect();
                        }
                        ?>
            </div>
               <?php
        
    }
    
    include $tpl."footer.php";
}
else
{
        header("location: login.php");
    exit();  
}
ob_end_flush();
}