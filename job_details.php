
<?php
ob_start();
session_start();
if(isset($_POST['name']))
{
if(isset($_SESSION['info']['photos_name']))
{
    $arr=explode(',',$_SESSION['info']['photos_name']);
    
}


    $item= $_POST['name'];
    $index = array_search($item,$arr);
    unset($arr[$index]);
     $_SESSION['info']['photos_name']=implode(',',$arr);   
        
        

    
}
else
{
 

 if(isset($_SESSION['user'])||isset($_SESSION['client']))
 {
  
     include "init.php";
     $do = isset($_GET['do'])?$_GET['do']:'title';
     if($do=='title')
     {
      if(isset($_POST['next']))
      {
        
         foreach($_POST as $key => $value)
         {
            $_SESSION['info'][$key] = $value;
         }
         if(in_array('next',$_SESSION['info']))
         {
             unset($_SESSION['info']['next']);
             header('location: ?do=description');
             exit();
         }
      }

      ?>
      <?php
       include "messages.php";
      ?>
      <div id="title" class="container">
        <form method="post" action="" class="row">
         <div class="steps col-md-4">
             <div class="selected"> <i class="fa fa-pen"></i> <span> title</span></div>
             <div> <i class="fa fa-pen-square"></i> <span>  description</span></div>
             <div> <i class="fa fa-dollar-sign"></i> <span>  budget</span></div>
             <div> <i class="fa fa-check"></i>  <span> review</span></div>
         </div>
         <div class="step-details col-md-8">
             <div class="step-header">
                 <h1>
                     <span><i class="fa fa-pen"></i> <span> title</span></span>
                     <p><progress value="30" max='100' class="title-prog"></progress></p>
                 </h1>
             </div>
             <div class="step-content" >
                     <div class="form-group job">
                         <label>Job Name</label>
                         <input class="form-control" type="text" name="job_name" id="job_name" value="<?php if(isset($_SESSION['info']['job_name'])){echo $_SESSION['info']['job_name'];}?>"/>
                         <p>hello emad hello emad hello emad hello emad hello emad hello emad hello emad hello emad</p>
                     </div>
             </div>
             <div class="step-submit">
                 <p>hello emad hello emad hello emad hello emad hello emad hello emad hello emad hello emad  hello emad hello emad hello emad  hello emad hello emad hello emad  hello emad hello emad hello emad  hello emad hello emad hello emad  hello emad hello emad hello emad  </p>
                 <div style="text-align: center">
                    <input type="submit" id="suc" class="btn btn-success" name="next" value="unavailable">
                 </div>
             </div>        
         </div>
        </form>
       </div>
<?php
     }
     if($do=='description'){      
      if(isset($_POST['next']))
      {
        
         foreach($_POST as $key => $value)
         {
            $_SESSION['info'][$key] = $value;
         }
         if($_FILES['file']['size'][0]!=0)
         {
           $names_array=array();
           $notuploads=array();
           $extensions =array("gif","jpeg","png",'txt',"jpg"); 
           foreach($_FILES['file']['name'] as $key =>$val)
           {
              $errors=array();

            if($_FILES['file']['size'][$key] > 4000000)
            {
               $errors[] = "<div class='alert alert-danger'>".$val." size is more than 4 MG </div>";
            }
            $extension = strtolower(end(explode(".",$val)));
            
            if(!in_array($extension,$extensions))
            {
               $errors[] = "<div class='alert alert-danger'>".$extension."  is not allowed extension </div>";
            }
            if(empty($errors))
            {
              $name=rand(0,100000)."_".$extension;
              $tmp_name=$_FILES['file']['tmp_name'][$key];
              if(!move_uploaded_file($tmp_name,'admin\uploads\imgs\\'.$name))
              {
                $notuploads[]="<div class='alert alert-danger'>this ".$val." not allowed photo </div>";
           
              }
              else
              {
               $names_array[]=$name;
               
              }             
            }
            else
            {
             foreach($errors as $error)
             {
              echo $error;
             }
            }
           }          
           if(empty($notuploads) && empty($errors))
           {
            $_SESSION['info']["photos_name"] = implode(',',$names_array);
            unset($_SESSION['info']['next']);
            header("location: ?do=budget");
            exit();             
            
            
           }
           else
           {
            foreach($notuploads as $msg)
            {
             echo $msg;
            }
           }
         }
         else
         {
          if(isset($_SESSION['info']["photos_name"]))
          {
           unset($_SESSION['info']['photos_name']);
          }
          unset($_SESSION['info']['next']);
          header("location: ?do=budget");
          exit();             
         }
         


         
      }      
?>

      <div id="description" class="container">
       <form method="post" action="" enctype="multipart/form-data" class="row">
        <div class="steps col-md-4">
            <div class="done"> <i class="fa fa-pen"></i> <span> title</span><i class="fa fa-check-circle"></i></div>
            <div class="selected"> <i class="fa fa-pen-square"></i> <span>  description</span></div>
            <div> <i class="fa fa-dollar-sign"></i> <span>  budget</span></div>
            <div> <i class="fa fa-check"></i>  <span> review</span></div>
            
    
        </div>
        <div class="step-details col-md-8">
            <div class="step-header">
                <h1>
                    <span><i class="fa fa-pen-square"></i> <span> description</span></span>
                    <p><progress value="60" max='100' class="desc-prog"></p>
                </h1>
            </div>
            <div class="step-content">
                    <div class="form-group job">
                        <label>description of job</label>
                        <textarea class="form-control" name="job_description" id="job_description"><?php if(isset($_SESSION['info']['job_description'])){echo $_SESSION['info']['job_description'];}?></textarea>
                        <p>hello emad hello emad hello emad hello emad hello emad hello emad hello emad hello emad</p>
                    </div>
                    <div class="form-group job" >
                        <label for="upload" style="border: 1px dashed #28a745;padding: 50px;cursor: pointer;text-align: center">
                         click to choose a file
                          <input type="file" name="file[]" id = "upload" style="display: none" multiple >

                        </label>
                        
                        <p >hello emad hello emad hello emad hello emad hello emad hello emad hello emad hello emad</p>
                    </div>
            </div>          
            <div class="step-submit">
                <p>hello emad hello emad hello emad hello emad hello emad hello emad hello emad hello emad  hello emad hello emad hello emad  hello emad hello emad hello emad  hello emad hello emad hello emad  hello emad hello emad hello emad  hello emad hello emad hello emad  </p>
                <div style="text-align: center">
                  <a href="?do=title" class="btn btn-primary">back</a>
                  <input type="submit" id="suc" class="btn btn-success" name="next" value="unavailable">
                </div>
            </div>        
        </div>
       </form>
      </div>
<?php
     }
     if($do=='budget'){
       if(isset($_SERVER['REQUEST_METHOD'])=='post'&&isset($_SESSION['info']))
       {      
      if(isset($_POST['next']))
      {
        
         foreach($_POST as $key => $value)
         {
            $_SESSION['info'][$key] = $value;
         }
         if(in_array('next',$_SESSION['info']))
         {
          unset($_SESSION['info']['next']);
          header("location: ?do=review");
          exit();          
         }
      }
?>
      <div id="budget" class="container">
       <form method="post" action=""class="row">
         <div class="steps col-md-4">
             <div class="done"> <i class="fa fa-pen"></i> <span> title</span><i class="fa fa-check-circle"></i></div>
             <div class="done"> <i class="fa fa-pen-square"></i> <span>  description</span><i class="fa fa-check-circle"></i></div>
             <div class="selected"> <i class="fa fa-dollar-sign"></i> <span>  budget</span></div>
             <div> <i class="fa fa-check"></i>  <span> review</span></div>
             
     
         </div>
         <div class="step-details col-md-8">
             <div class="step-header">
                 <h1>
                     <span><i class="fa fa-dollar-sign"></i> <span>  budget</span></span>
                     <p><progress value="90" max='100' class="budget-prog"></p>
                 </h1>
             </div>
             <div class="step-content">
                      <label>the way to pay</label>
                     <div class="form-group row ras">
                         <div class="radio-div col-md-8 offset-md-2 1">
                           <input type="radio" name="paying" id="paying" value="1" <?php if(isset($_SESSION['info']['paying'])&&$_SESSION['info']['paying']=='1'){echo 'checked="checked"';}?>>
                           <p class="rad-1">emad</p>
     
                         </div>
                         <div class="radio-div col-md-8 offset-md-2  2">
                           <input type="radio" name="paying" id="paying" value="2" <?php if(isset($_SESSION['info']['paying'])&&$_SESSION['info']['paying']=='2'){echo 'checked ="checked"';}?>>
                           <p class="rad-2">hello</p>
     
                         </div>
                         <div class="radio-div col-md-8 offset-md-2  3">
                           <input type="radio" name="paying" id="paying" value="3" <?php if(isset($_SESSION['info']['paying'])&&$_SESSION['info']['paying']=='3'){echo 'checked="checked"' ;}?>>
                           <p class="rad-3">hello emad</p>
     
                         </div>                    
                     </div>
             </div>
             <div class="step-submit">
                 <p>hello emad hello emad hello emad hello emad hello emad hello emad hello emad hello emad  hello emad hello emad hello emad  hello emad hello emad hello emad  hello emad hello emad hello emad  hello emad hello emad hello emad  hello emad hello emad hello emad  </p>
                 <div style="text-align: center">
                       <a href="?do=description" class="btn btn-primary">back</a>
                    <input type="submit" id="suc" class="btn btn-success <?php if(isset($_SESSION['info']['paying'])){echo 'confirm';}?>" name="next" value="<?php if(isset($_SESSION['info']['paying'])){echo 'next';}else{echo 'unavaliable';}?>">
                 </div>
             </div>        
         </div>
       </form>
      </div>
<?php
       }
       else
       {
         header("location: ?do=title");
         exit();
       }
     }
     if($do=='review')
     {
       if(isset($_SERVER['REQUEST_METHOD'])=='post'&&isset($_SESSION['info']))
       {
         if(isset($_POST['submit']))
         {
          if(isset($_SESSION['info']['photos_name']))
          {
           $photo_name=$_SESSION['info']['photos_name'];
          }
          else
          {
           $photo_name="";
          }
          
          if(isset($_SESSION['client']))
          {
           $email=$_SESSION['client'];
          }
          else
          {
           $email=$_SESSION['user'];
          }
          $rows =getTable('client_id','clients',"where email='$email'");
          echo $job_owner=$rows[0]['client_id'];
          $job_name=$_SESSION['info']['job_name'];
          $job_description=$_SESSION['info']['job_description'];
          $budget=$_SESSION['info']['paying'];
          
          $stmt2=mysqli_query($con,"insert into jobs(job_name,job_description,job_owner,budget,photos,adding_date)values('$job_name','$job_description',$job_owner,$budget,'$photo_name',now())");
          if(mysqli_affected_rows($con)>0)
          {
            echo '<div class="alert container text-center " style="color:#6af98b;font-weight:bold">your job is added successfully</div>';
            
            unset($_SESSION['info']);
          $rows =getTable('client_id','clients',"where email='$email'");
          echo   $job_owner=$rows[0]['client_id'];
            redirect('','5',"profiles.php?client_id=".$job_owner);
           
          }
          else
          {
            echo '<div class="alert container text-center"  style="color:red;font-weight:bold">something went wrong</div>';

          }  
         }
?>      
    <div id="review" class="container">
      <form method="post" action="" class="row">
       <div class="steps col-md-4">
           <div class="done"> <i class="fa fa-pen"></i> <span> title</span><i class="fa fa-check-circle"></i></div>
           <div class="done"> <i class="fa fa-pen-square"></i> <span>  description</span><i class="fa fa-check-circle"></i></div>
           <div class="done"> <i class="fa fa-dollar-sign"></i> <span>  budget</span><i class="fa fa-check-circle"></i></div>
           <div class="selected"> <i class="fa fa-check"></i>  <span> review</span></div>
           
   
       </div>
       <div class="step-details col-md-8">
           <div class="step-header">
               <h1>
                   <span><i class="fa fa-check"></i> <span>  review</span></span>
                   <p><progress value="100" max='100' class="review-prog"></p>
               </h1>
           </div>
           <div class="step-content">
          
                   <div class="card">
                       <label class="card-header">Job Name</label>
                       <p class="card-body" id="card-body1"><?php if(isset($_SESSION['info']['job_name'])){echo $_SESSION['info']['job_name'];}?> </p>
                   </div>

                   <div class="card">
                       <label class="card-header">description of job</label>
                       <p class="card-body" id="card-body2"><?php if(isset($_SESSION['info']['job_description'])){echo $_SESSION['info']['job_description'];}?></p>
   
                   </div>                
                   <div class="card">
                       <label class="card-header">files uploaded</label>
                       <p class="card-body" id="card-body1"><?php
                       if(isset($_SESSION['info']['photos_name'])&&!empty($_SESSION['info']['photos_name']))
                       {
                         echo "<div class='row'>";

                          $files = explode(',',$_SESSION['info']['photos_name']);
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
                               echo "<div class='col-3 file'  data-class='".$file."' style='padding:0px;margin-left:30px;margin-bottom:10px'>";
                                  echo '<i class="fas fa-window-close file-close"></i>';
                               
                                  echo "<img src='admin/uploads/imgs/".$file."' style='width:100%;height:150px'/>";
                               echo "</div>";                               
                              }
                              
                          }
                         echo "</div>";
                        
                       }


                        else
                        {
                        
                        echo "<b> No Files Uploaded</b>";
                         
                        }
                        

                       ?> </p>
                   </div>                    
   
                       <div class="card">
                        <label class="card-header">the way to pay</label>
                        <p class="card-body" id="card-body3">
                        <?php if(isset($_SESSION['info']['paying'])){echo'
                          <div class="row rad">
                            <div class="radio-div col-md-8 offset-md-2 radio-d">
                               <input type="radio" name="paying" id="paying" value="'.$_SESSION['info']['paying'].'" checked ="checked">
                               <p>
                               ';
                               if($_SESSION['info']['paying']=='1')
                               {
                                echo 'emad';
                               }
                               if($_SESSION['info']['paying']=='2')
                               {
                                echo 'hello';
                               }
                               if($_SESSION['info']['paying']=='3')
                               {
                                echo 'hello emad';
                               }
                              echo '
                               
                               
                               </p>
                            </div>
                          </div>     
                        ' ;}?>
                        </p>
     
                       </div>          
           </div>
           <div class="step-submit">
               <p>hello emad hello emad hello emad hello emad hello emad hello emad hello emad hello emad  hello emad hello emad hello emad  hello emad hello emad hello emad  hello emad hello emad hello emad  hello emad hello emad hello emad  hello emad hello emad hello emad  </p>
               <div style="text-align: center">
                <a href="?do=budget" class="btn btn-primary">back</a>
                <input type="submit" id="suc" value="submit" class="btn btn-success confirm" name="submit">
              </div>
               </div>        
       </div>
     </form>
    </div>  
<?php
       }
       else
       {
         header("location: ?do=title");
         exit();
       }

     }
 }
 else
 {
     header("location: login.php");
     exit();
 }
 include "contact_us.php";

include $tpl . "footer.php";

ob_end_flush();
}
?>
