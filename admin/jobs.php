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
if(isset($_SESSION['user']))
{

    include"init.php";
    $do = isset($_GET['do'])?$_GET['do']:'manage';
    if($do== 'manage')
    {
     if(isset($_SESSION['photos_name']))
     {
      unset($_SESSION['photos_name']);
     }     
        
        $stmt = mysqli_query($con,"select distinct job_owner from jobs where status=1 and finish=0");
        $rows=$stmt->fetch_all(MYSQLI_NUM);
        if(empty($rows))
        {
            echo '<div class="alert container text-center"  style="color:red;font-weight:bold">no jobs</div>';
         
        }
?>
            <div class="container">

<?php 
        foreach($rows as $row)
        {
            $job_owner = $row["0"];
            $stmt1=mysqli_query($con,"select job_id from jobs where job_owner='$job_owner' and status=1 ");
            $rows1=$stmt1->fetch_all(MYSQLI_ASSOC);
            $stmt4=mysqli_query($con,"select client_name from clients where client_id='$job_owner'");
            $rows4=$stmt4->fetch_all(MYSQLI_ASSOC);
            ?>
            

                <div class="card">
                    <div class="card-header">
                        <?php echo '<span class="owner-name">job\'s owner</span>'.": <a href='clients.php?do=edit&client_id=".$job_owner."'>".$rows4[0]['client_name']."</a>";?>


                        <div class="jobs-details">

                        <b class="hide-data point">Hide</b> |
                        <b class="show-data select">Show</b>
                        Details
                        </div>                    

                    </div>
                    <div class="card-body">
                        <div>
                            <table class="table table-dark table-hover table-responsive-sm table-responsive-md table-responsive-lg">
                                <thead>
                                    <tr>
                                      <th scope="col">ID</th>
                                      <th scope="col">job_name</th>
                                      <th scope="col">Description</th>
                                      <th scope="col">Adding_date</th>
                                      <th scope="col">feedback</th>
                                      <th scope="col">operations </th>
                                      
                                    </tr>
                                </thead>
                        <?php
                         $id = isset($_GET['id'])&&is_numeric($_GET['id'])?intval($_GET['id']):0;

                            foreach($rows1 as $row1)
                            {
                                $job_id =$row1['job_id'];
                                $stmt2 = mysqli_query($con,"select jobs.*,clients.client_name,clients.client_id from jobs inner join clients on jobs.job_owner=clients.client_id where jobs.job_id=$job_id");
                                $rows2 = $stmt2->fetch_all(MYSQLI_ASSOC);
                                $client_id = $rows2[0]['client_id'];
                                $stmt6 = mysqli_query($con,"select * from finished_jobs where job_id='$job_id'");
                                $row=$stmt6->fetch_all(MYSQLI_ASSOC);
                                if(empty($row))
                                {
                                if($rows2[0]['job_id']==$id)
                                {                                
                                        echo '
                                    
                                        <tbody>
                                            <tr id="'.$rows2[0]['job_id'].'" style="background:#476838">
                                              <td scope="row">'.$rows2[0]['job_id'].'</td>
                                              <td scope="row">'.$rows2[0]['job_name'].'</td>
                                              <td scope="row"><div style="min-width:300px">'.$rows2[0]['job_description'].'</div></td>
                                              <td scope="row"><div style="min-width:85px">'.$rows2[0]['adding_date'].'</div></td>
                                              <td scope="row">'.$rows2[0]['feedback'].'</td>
                                <td scope="row">
                                <div class="button_row">
                                    <b>
                                        <a href="?do=delete&job_id='.$rows2[0]["job_id"].'" class="btn btn-danger delete">Delete <i class="fas fa-user-minus"></i>
                                        </a>
                                    </b>
                                    <b>
                                        <a href="?do=edit&job_id='.$rows2[0]["job_id"].'&job_owner='.$client_id.'" class="btn btn-primary">Edit <i class="fa fa-edit"></i>
                                        </a>
                                    </b>
                                    <b>
                                        <a href="?do=activation&job_id='.$rows2[0]["job_id"].'&job_owner='.$client_id.'" class="btn activate confirm"> Add in wait<i class="fas fa-user-check"></i></a>
                                        </a>
                                    </b>
                                    <b>
                                        <a href="?do=job_finish&job_id='.$rows2[0]['job_id'].'" class=" btn btn-secondary"><span class="finish">finish</span></a>
                                        </a>
                                       <progress value="'.$rows2[0]['progress'].'" max=100></progress>

                                    </b>                                      
                                </div>
                                </td>                                              
                                            <tr>
                                        </tbody>';
                                }
                                else
                                {
                                     echo '
                                     
                                        <tbody>
                                            <tr>
                                              <td scope="row">'.$rows2[0]['job_id'].'</td>
                                              <td scope="row">'.$rows2[0]['job_name'].'</td>
                                              <td scope="row"><div style="min-width:300px">'.$rows2[0]['job_description'].'</div></td>
                                              <td scope="row"><div style="min-width:85px">'.$rows2[0]['adding_date'].'</div></td>
                                              <td scope="row">'.$rows2[0]['feedback'].'</td>
 <td scope="row">
                                <div class="button_row">
                                    <b>
                                        <a href="?do=delete&job_id='.$rows2[0]["job_id"].'" class="btn btn-danger delete">Delete <i class="fas fa-user-minus"></i>
                                        </a>
                                    </b>
                                    <b>
                                        <a href="?do=edit&job_id='.$rows2[0]["job_id"].'&job_owner='.$client_id.'" class="btn btn-primary">Edit <i class="fa fa-edit"></i>
                                        </a>
                                    </b>
                                    <b>
                                        <a href="?do=activation&job_id='.$rows2[0]["job_id"].'&job_owner='.$client_id.'" class="btn activate confirm"> Add in wait<i class="fas fa-user-check"></i></a>
                                        </a>
                                    </b>
                                    <b>
                                        <a href="?do=job_finish&job_id='.$rows2[0]['job_id'].'" class=" btn btn-secondary"><span class="finish">finish</span></a>
                                        </a>
                                       <progress value="'.$rows2[0]['progress'].'" max=100></progress>

                                    </b>                                      
                                </div>
                                </td> 
                                            <tr>
                                        </tbody>';
                                }
                                }
                            
                            }
                        ?>                                

                            </table>                                    
                        </div>
                    </div>
                </div>
                
            <?php  
        }
            
            ?>
            </div>
 
            <div class="container">
                   <a href="?do=add" class="btn btn-success confirm" style="width: 174px"> Add new job <i class="fas fa-plus"></i></a>
               </div>
            <?php
    }
    if($do=="job_finish")
    {
        $job_id = isset($_GET['job_id'])?$_GET['job_id']:0;
        $stmt2 = mysqli_query($con,"select job_owner from jobs where job_id ='$job_id'");
        $row2= $stmt2->fetch_all(MYSQLI_ASSOC);
        $job_owner=$row2[0]['job_owner'];
    ?>

            <div class="container">
            <h1 class ='text-center'> Add finished job</h1>
                <form class="myform1" action="?do=insertfinishedjob&job_id=<?php echo $job_id?>" method="post" enctype="multipart/form-data">
                    <div class="form-groub">
                        <label>job_link</label>
                        <input type="text" class="form-control"name="job_link" required="required">  
                    </div>
                    <div class="form-groub ">
                            <label>job_name</label>
                        <select name="job_name" class="form-control">
                            <?php
                            $stmt=mysqli_query($con,"select * from jobs where finish !=1 and status =1");
                            $rows = $stmt->fetch_all(MYSQLI_ASSOC);
                            foreach($rows as $row)
                            {
                                if($row['job_id']==$job_id)
                                {
                                    echo "<option  value='".$row['job_name']."' selected>".$row['job_name']."</option >";
                                }
                                else
                                {
                                        echo "<option  value='".$row['job_name']."'>".$row['job_name']."</option >";


                                }
                                
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form-groub">
                        <label>job_description</label>
                        <input type="text" class="form-control"name="job_description" required="required">  
                    </div>                    
                    <div class="form-groub">
                        <label>job_owner</label>
                        <select name="job_owner" class="form-control">
                            <?php
                            $stmt3=mysqli_query($con,"select * from clients");
                            $rows3 = $stmt3->fetch_all(MYSQLI_ASSOC);
                            foreach($rows3 as $row3)
                            {
                                if($job_owner==$row3['client_id'])
                                {
                                echo "<option  value='".$row3['client_id']."' selected>".$row3['client_name']."</option >";
                                }
                                else
                                {
                                echo "<option  value='".$row3['client_id']."'>".$row3['client_name']."</option >";
                                    
                                }
                            }
                            ?>
                        </select>                    
                    </div>                    
                    <div class="form-groub">
                        <label>photos</label>
                        <input type="file" class="form-control"name="file[]" multiple required>  
                    </div>
                    <button type="submit" class="btn btn-success mb-2 confirm" name="confirm">Confirm data</button>
                </form>
            </div>
            
    <?php        
        
    }

                
    if($do=="insertfinishedjob")
    {
        if($_SERVER['REQUEST_METHOD']=='POST')
        {
        $job_id = isset($_GET['job_id'])?$_GET['job_id']:0;

        ?>

        <div class="container">
            <h1 class="text-center">inserting data</h1>
            <?php
                $job_name = filter_var($_POST['job_name'],FILTER_SANITIZE_STRING);
                $job_link = filter_var($_POST['job_link'],FILTER_SANITIZE_STRING);
                $job_description = filter_var($_POST['job_description'],FILTER_SANITIZE_STRING);
                $job_owner= filter_var($_POST['job_owner'],FILTER_SANITIZE_NUMBER_INT);
                $jobownername = getTable('client_name,email',"clients","where client_id ='$job_owner'");
                $job_owner_name = $jobownername[0]['client_name'];
                $job_owner_email = $jobownername[0]['email'];              

                $screens=array();
                $errors = array();

        if($_FILES['file']['size'][0]!=0)
         {
           $extensions =array("gif","jpeg","png",'txt',"jpg"); 
           foreach($_FILES['file']['name'] as $key =>$val)
           {

            if($_FILES['file']['size'][$key] > 4000000)
            {
               $errors[] = "<div class='alert text-center' style='color:red;font-weight:bold'> <i class='fas fa-exclamation-triangle'></i>".$val." size is more than 4 MG </div>";
            }
            $extension = strtolower(end(explode(".",$val)));
            
            if(!in_array($extension,$extensions))
            {
               $errors[] = "<div class='alert text-center' style='color:red;font-weight:bold'> <i class='fas fa-exclamation-triangle'></i>".$extension."  is not allowed extension </div>";
            }
           }
         }
                
                foreach($_FILES['file']['name'] as $key => $val)
                {
                    $tmp_name= $_FILES['file']['tmp_name'][$key];
                     $name=rand(0,100000)."_".$val;
                     $screens[]=$name;
                    move_uploaded_file($tmp_name,'uploads\imgs\\'.$name);
                }
                $screenshoots=filter_var(implode(',',$screens),FILTER_SANITIZE_STRING);

                if(isset($_POST['confirm']))
                {
                    if(empty($job_name)){$errors[]= '<div class="alert text-center" style="color:red;font-weight:bold"> <i class="fas fa-exclamation-triangle"></i>you cannot leave job\'s name empty</div>';}
                    if(empty($screenshoots)){$errors[]= '<div class="alert text-center" style="color:red;font-weight:bold"> <i class="fas fa-exclamation-triangle"></i>you must choose a photos for the website </div>';}                    
                    if(empty($job_link)){$errors[]= '<div class="alert text-center" style="color:red;font-weight:bold"> <i class="fas fa-exclamation-triangle"></i>you cannot leave job\'s link empty</div>';}
                    if(strlen($job_name)<3){$errors[]= '<div class="alert text-center" style="color:red;font-weight:bold"> <i class="fas fa-exclamation-triangle"></i>you cannot leave job\'s name less than 3 character</div>';}
    
                    if(empty($errors))
                    {

                        $stmt = mysqli_query($con,"insert into finished_jobs (job_id,job_name,job_link,ending_date,jobs_screenshoots,job_owner,owner_name,owner_email,description) values('$job_id','$job_name','$job_link',now(),'$screenshoots','$job_owner','$job_owner_name','$job_owner_email','$job_description')");
                        if($stmt)
                        {
                        $stmt1=mysqli_query($con,"update jobs set finish=1 where job_id='$job_id'");
                          if($stmt1)
                          {
                            echo '<div class="alert text-center" style="color:#28a745;font-weight:bold;"><i class="fas fa-check"></i>one job inserted</div>';
                              redirect('index.php',5);                           
                          }
                        }
                        else
                        {
                            echo '<div class="alert text-center" style="color:red;font-weight:bold"> <i class="fas fa-exclamation-triangle"></i>no insertrd</div>';
                        }
                    }
                    else
                    {
                        
                        foreach($errors as $error)
                        {
                            echo $error;
    
                        }
    
                        redirect('',5);
    
    
                    }
                    
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
    if($do=="finished_jobs")
    {
     if(isset($_SESSION['photos_name']))
     {
      unset($_SESSION['photos_name']);
     }

        $stmt = mysqli_query($con,"select distinct job_owner from finished_jobs");
        $rows=$stmt->fetch_all(MYSQLI_NUM);
        if(empty($rows))
        {
            echo '<div class="alert container text-center"  style="color:red;font-weight:bold">no jobs</div>';
         
        }
?>
            <div class="container">

<?php 
        foreach($rows as $row)
        {
            $job_owner = $row["0"];
            $stmt1=mysqli_query($con,"select * from finished_jobs where job_owner='$job_owner'");
            $rows1=$stmt1->fetch_all(MYSQLI_ASSOC);
            $stmt4=mysqli_query($con,"select client_name from clients where client_id='$job_owner'");
            $rows4=$stmt4->fetch_all(MYSQLI_ASSOC);
            ?>
            

                <div class="card">
                    <div class="card-header">
                        <?php echo '<span class="owner-name">job\'s owner</span>'.": <a href='clients.php?do=edit&client_id=".$job_owner."'>".$rows4[0]['client_name']."</a>";?>


                        <div class="jobs-details">

                        <b class="hide-data point">Hide</b> |
                        <b class="show-data select">Show</b>
                        Details
                        </div>                    

                    </div>
                    <div class="card-body">
                        <div>
                            <table class="table table-dark table-hover table-responsive-sm table-responsive-md table-responsive-lg">
                                <thead>
                                    <tr>
                                      <th scope="col">ID</th>
                                      <th scope="col">job_name</th>
                                      <th scope="col">Description</th>
                                      <th scope="col">Adding_date</th>
                                      <th scope="col">ending_date</th>
                                      <th scope="col">FeedBack</th>
                                      <th scope="col">operations </th>
                                      
                                      
                                    </tr>
                                </thead>
                        <?php
                         $id = isset($_GET['id'])&&is_numeric($_GET['id'])?intval($_GET['id']):0;

                            foreach($rows1 as $row1)
                            {
                                $job_id =$row1['job_id'];
                                $stmt2 = mysqli_query($con,"select jobs.*,clients.client_name,clients.client_id from jobs inner join clients on jobs.job_owner=clients.client_id where jobs.job_id=$job_id");
                                $rows2 = $stmt2->fetch_all(MYSQLI_ASSOC);
                                $client_id = $rows2[0]['client_id'];
                            
                                if($job_id==$id)
                                {
                                        echo '
                                    
                                        <tbody>
                                            <tr id="'.$job_id.'" style="background:#476838">
                                              <td scope="row">'.$job_id.'</td>
                                              <td scope="row">'.$row1['job_name'].'</td>
                                              <td scope="row"><div style="min-width:300px">'.$row1['description'].'</div></td>
                                              <td scope="row"><div style="min-width:85px">'.$rows2[0]['adding_date'].'</div></td>
                                              <td scope="row"><div style="min-width:85px">'.$row1['ending_date'].'</div></td>
                                              <td scope="row">'.$row1['feedback'].'</td>
                                              <td scope="row">
                                               <div class = "button_row">
                                                <b>
                                                    <a href="?do=delete&job_id='.$job_id.'" class="btn btn-danger delete">Delete <i class="fas fa-user-minus"></i>
                                                    </a>
                                                </b>
                                                <b>
                                                    <a href="?do=edit&job_id='.$job_id.'&job_owner='.$client_id.'" class="btn btn-primary">Edit <i class="fa fa-edit"></i>
                                                    </a>
                                                </b>
                                               </div>                                               
                                               </td>

                                            <tr>
                                        </tbody>';
                                }
                                else
                                {
                                     echo '
                                     
                                        <tbody>
                                            <tr>
                                              <td scope="row">'.$job_id.'</td>
                                              <td scope="row">'.$row1['job_name'].'</td>
                                              <td scope="row"><div style="min-width:300px">'.$row1['description'].'</div></td>
                                              <td scope="row"><div style="min-width:85px">'.$rows2[0]['adding_date'].' </div> </td>
                                              <td scope="row"><div style="min-width:85px">'.$row1['ending_date'].'</div></td>
                                              <td scope="row">'.$row1['feedback'].'</td>
                                              <td scope="row">
                                               <div class = "button_row">
                                                <b>
                                                    <a href="?do=delete&job_id='.$job_id.'" class="btn btn-danger delete">Delete <i class="fas fa-user-minus"></i>
                                                    </a>
                                                </b>
                                                <b>
                                                    <a href="?do=edit&job_id='.$job_id.'&job_owner='.$client_id.'" class="btn btn-primary">Edit <i class="fa fa-edit"></i>
                                                    </a>
                                                </b>
                                               </div>   
                                              </td>
                                              
                                            <tr>
                                        </tbody>';
                                }
                                
                            
                            }
                        ?>                                

                            </table>                                    
                        </div>
                    </div>
                </div>
                
            <?php  
        }
            
            ?>
            </div>
 
            <div class="container">
                   <a href="?do=add" class="btn btn-success confirm" style="width: 174px"> Add new job <i class="fas fa-plus"></i></a>
               </div>
            <?php        
    }
    if($do == 'delete')
    {
        ?>
        <div class="container">
            <h1 class="text-center">delete a job </h1>
            <?php
            $job_id =isset($_GET['job_id'])&& is_numeric($_GET['job_id'])?intval($_GET['job_id']):0;
            $stmt = mysqli_query($con,"delete from jobs where job_id='$job_id'");
            $count = mysqli_affected_rows($con);
            if($count>0)
            {
                echo '<div class="alert text-center" style="color:#28a745;font-weight:bold;"><i class="fas fa-check"></i>one job deleted</div>';
                redirect();
            }
            else
            {
                echo '<div class="alert text-center" style="color:red;font-weight:bold"> <i class="fas fa-exclamation-triangle"></i>no job deleted</div>';
                redirect();

            }
            ?>
        </div>
        <?php
    }
    if($do == 'delete_finished_jobs')
    {
        ?>
        <div class="container">
            <h1 class="text-center">delete a job </h1>
            <?php
            $job_id =isset($_GET['job_id'])&& is_numeric($_GET['job_id'])?intval($_GET['job_id']):0;
            $stmt = mysqli_query($con,"delete from finished_jobs where job_id='$job_id'");
            $stmt2 = mysqli_query($con,"delete from jobs where job_id='$job_id'");

            $count = mysqli_affected_rows($con);
            if($count>0&&$stmt2)
            {
                echo '<div class="alert text-center" style="color:#28a745;font-weight:bold;"><i class="fas fa-check"></i>one job deleted</div>';
                
                redirect();
            }
            else
            {
                echo '<div class="alert text-center" style="color:red;font-weight:bold"> <i class="fas fa-exclamation-triangle"></i>no job deleted</div>';
                redirect();

            }
            ?>
        </div>
        <?php
    }     
    if($do == 'add')
    {
    ?>

            <div class="container">
            <h1 class ='text-center'> Add a job</h1>
                <form class="myform1" action="?do=insert" method="post" enctype="multipart/form-data">
                    <div class="form-groub">
                        <label>job_name</label>
                        <input type="text" class="form-control" name="job_name" required="required">  
                    </div>
                    <div class="form-groub">
                        <label>job_description</label>
                        <input type="text" class="form-control"name="job_description" required="required">  
                    </div>
                    <div class="form-groub ">
                            <label>job_owner</label>
                        <select name="job_owner" class="form-control">
                            <?php
                            $stmt=mysqli_query($con,"select * from clients");
                            $rows = $stmt->fetch_all(MYSQLI_ASSOC);
                            foreach($rows as $row)
                            {
                                echo "<option  value='".$row['client_id']."'>".$row['client_name']."</option >";
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form-groub">
                        <label>photos</label>
                        <input type="file" class="form-control"name="file[]" multiple>  
                    </div>
                        <label>Budget</label>

                    <div class="form-group row">
                        <div class="col-3 radio-div">
                        <input type="radio" name="paying"  value="1">
                        <p>hello</p>                            
                        </div>
                        <div class="col-3 radio-div">
                        <input type="radio" name="paying"  value="2">
                        <p>hello</p>                            
                        </div>

                        <div class="col-3 radio-div">
                        <input type="radio" name="paying"  value="3">
                        <p>hello</p>                            
                        </div>

                    </div>
                    <button type="submit" class="btn btn-success mb-2 confirm" name="confirm">Confirm data</button>
                </form>
            </div>
            
    <?php
    }
    if($do=='insert')
    {
        if($_SERVER['REQUEST_METHOD']=='POST')
        {
        ?>

        <div class="container">
            <h1 class="text-center">inserting data</h1>
            <?php

                
                $job_name = filter_var($_POST['job_name'],FILTER_SANITIZE_STRING);
                $job_description = filter_var($_POST['job_description'],FILTER_SANITIZE_STRING);
                $job_owner = filter_var($_POST['job_owner'],FILTER_SANITIZE_NUMBER_INT);
                $jobownername = getTable('client_name,email',"clients","where client_id ='$job_owner'");
                $job_owner_name = $jobownername[0]['client_name'];
                $job_owner_email = $jobownername[0]['email'];                              
                $budget = filter_var($_POST['paying'],FILTER_SANITIZE_NUMBER_INT);
                $errors = array();
                $screens=array();

        if($_FILES['file']['size'][0]!=0)
         {
           $extensions =array("gif","jpeg","png",'txt',"jpg"); 
           foreach($_FILES['file']['name'] as $key =>$val)
           {

            if($_FILES['file']['size'][$key] > 4000000)
            {
               $errors[] = "<div class='alert text-center' style='color:red;font-weight:bold'> <i class='fas fa-exclamation-triangle'></i>".$val." size is more than 4 MG </div>";
            }
            $extension = strtolower(end(explode(".",$val)));
            
            if(!in_array($extension,$extensions))
            {
               $errors[] = "<div class='alert text-center' style='color:red;font-weight:bold'> <i class='fas fa-exclamation-triangle'></i>".$extension."  is not allowed extension </div>";
            }
           }
                foreach($_FILES['file']['name'] as $key => $val)
                {
                   $name=rand(0,100000)."_".$extension;
                   $tmp_name=$_FILES['file']['tmp_name'][$key];
                   if(move_uploaded_file($tmp_name,'uploads\imgs\\'.$name))
                   {
                       $screens[]=$name;
                   }
                   else
                   {
                       $errors[] = "<div class='alert text-center' style='color:red;font-weight:bold'> <i class='fas fa-exclamation-triangle'></i>".$val."  unread</div>";
                   }
                }
                $photo_name=filter_var(implode(',',$screens),FILTER_SANITIZE_STRING);
         }
                if(isset($_POST['confirm']))
                {
               
                    if(empty($job_name)){$errors[]= '<div class="alert text-center" style="color:red;font-weight:bold"> <i class="fas fa-exclamation-triangle"></i>you cannot leave job\'s name empty</div>';}
                    if(empty($job_description)){$errors[]= '<div class="alert text-center" style="color:red;font-weight:bold"> <i class="fas fa-exclamation-triangle"></i>you cannot leave job\'s description empty</div>';}
                    if(empty($job_owner)){$errors[]= '<div class="alert text-center" style="color:red;font-weight:bold"> <i class="fas fa-exclamation-triangle"></i>you cannot leave job\' owner empty</div>';}
                    if(strlen($job_name)<3){$errors[]= '<div class="alert text-center" style="color:red;font-weight:bold"> <i class="fas fa-exclamation-triangle"></i>you cannot leave job\'s name less than 3 character</div>';}
                    if(strlen($job_description)<100){$errors[]= '<div class="alert text-center" style="color:red;font-weight:bold"> <i class="fas fa-exclamation-triangle"></i>you cannot leave job\'s description less than 100 character</div>';}
    
                    if(empty($errors))
                    {
                        $stmt = mysqli_query($con,"insert into jobs (job_name,job_description,job_owner,owner_name,owner_email,adding_date,status,budget,photos) values('$job_name','$job_description','$job_owner','$job_owner_name','$job_owner_email',now(),1,'$budget','$photo_name')");
                        if($stmt)
                        {
                            echo '<div class="alert text-center" style="color:#28a745;font-weight:bold;"><i class="fas fa-check"></i>one job inserted</div>';
                              redirect('index.php',5);
    
                        }
                    }
                    else
                    {
                        
                        foreach($errors as $error)
                        {
                            echo $error;
    
                        }
    
                        redirect('',5);
    
    
                    }
                    
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
    if($do == 'edit')
    {

        $job_id =isset($_GET['job_id'])&& is_numeric($_GET['job_id'])?intval($_GET['job_id']):0;
        $job_owner =isset($_GET['job_owner'])&& is_numeric($_GET['job_owner'])?intval($_GET['job_owner']):0;
        $stmt = mysqli_query($con,"select * from jobs where job_id=$job_id");
        $row2= $stmt->fetch_row();
    ?>

            <div class="container">
            <h1 class ='text-center'> edit a job</h1>
                <form class="myform1" action="?do=update&job_id=<?php echo $job_id ;?>" method="post" enctype="multipart/form-data">
                    <div class="form-groub">
                        <label>job_name</label>
                        <input type="text" class="form-control" name="job_name" value="<?php echo $row2['1'];?>">  
                    </div>
                    <div class="form-groub">
                        <label>job_description</label>
                        <input type="text" class="form-control"name="job_description" value="<?php echo $row2['2'];?>">  
                    </div>
                    <div class="form-groub">
                        <label>job_owner</label>
                        <select name="job_owner" class="form-control">
                            <?php
                            $stmt=mysqli_query($con,"select * from clients");
                            $rows = $stmt->fetch_all(MYSQLI_ASSOC);
                            foreach($rows as $row)
                            {
                                if($job_owner==$row['client_id'])
                                {
                                echo "<option  value='".$row['client_id']."' selected>".$row['client_name']."</option >";
                                }
                                else
                                {
                                echo "<option  value='".$row['client_id']."'>".$row['client_name']."</option >";
                                    
                                }
                            }
                            ?>
                        </select>                    
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
                                  $extension=end(explode('.',$file));
                                  if($extension=='txt')
                                  {
                                   
                                   
                                   echo "<div class='col-md-3 confirm file ' data-class='".$file."'   style='padding:56px;margin-left:30px;margin-bottom:10px;text-align:center;box-sizing:border-box;' >";
                                     echo '<i class="fas fa-window-close file-close" ></i>';
                                     echo "<b>".$file."</b>";
                                   echo "</div>";
    
                                  }
                                  else
                                  {
                                   echo "<div class='show'></div>";
                                   echo "<div class='col-md-3 file'  data-class='".$file."' style='padding:0px;margin-left:10px;margin-bottom:10px'>";
                                      echo '<i class="fas fa-window-close file-close"></i>';
                                   
                                      echo "<img src='uploads/imgs/".$file."' style='width:100%;height:150px'/>";
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
                                    $extension=end(explode('.',$file));
                                    if($extension=='txt')
                                    {
                                     
                                     
                                     echo "<div class=' col-md-3  confirm file ' data-class='".$file."'   style='padding:56px;margin-left:30px;margin-bottom:10px;text-align:center;box-sizing:border-box;' >";
                                       echo '<i class="fas fa-window-close file-close" ></i>';
                                       echo "<b>".$file."</b>";
                                     echo "</div>";
      
                                    }
                                    else
                                    {
                                     echo "<div class='show'></div>";
                                     echo "<div class='col-md-3 file'  data-class='".$file."' style='padding:0px;margin-left:10px;margin-bottom:10px'>";
                                        echo '<i class="fas fa-window-close file-close"></i>';
                                     
                                        echo "<img src='uploads/imgs/".$file."' style='width:100%;height:150px'/>";
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
                          <label>progress</label>
                          <?php
                          $rows=getTable("progress","jobs","where job_id='$job_id'");
                          ?>
                          <input type="number" name='progress' class="form-control" max=100 min=0 placeholder='progress of the project from 100 percentage (100%)' value="<?php echo $rows[0]["progress"]?>">  
                      </div>                      
                    <button type="submit" class="btn btn-success mb-2 confirm" name="confirm">Confirm data</button>
                </form>
            </div>
            
    <?php        
        
    }
if($do == 'edit_finished_jobs')
    {
        $job_id =isset($_GET['job_id'])&& is_numeric($_GET['job_id'])?intval($_GET['job_id']):0;
        $job_owner =isset($_GET['job_owner'])&& is_numeric($_GET['job_owner'])?intval($_GET['job_owner']):0;
        $stmt = mysqli_query($con,"select * from finished_jobs where job_id=$job_id");
        $row= $stmt->fetch_row();
    ?>

            <div class="container">
            <h1 class ='text-center'> edit a finished job</h1>
                <form class="myform1" action="?do=update_finished_jobs&job_id=<?php echo $job_id ;?>" method="post"  enctype="multipart/form-data">
                    <div class="form-groub">
                        <label>job_name</label>
                        <input type="text" class="form-control" name="job_name" value="<?php echo $row['1'];?>">  
                    </div>
                    <div class="form-groub">
                        <label>job_description</label>
                        <input type="text" class="form-control"name="job_description" value="<?php echo $row[6]?>" required="required">  
                    </div>                      
                    <div class="form-groub">
                        <label>job_link</label>
                        <input type="text" class="form-control"name="job_link" value="<?php echo $row['2'];?>">  
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
                                  $extension=end(explode('.',$file));
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
                                   
                                      echo "<img src='uploads/imgs/".$file."' style='width:100%;height:150px'/>";
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
      $_SESSION['photos_name']=$row['3'];
      
        if(!empty($_SESSION['photos_name']))
      {

       echo "<div class='row'>";
   
                                $files = explode(',',$row['3']);
                                foreach($files as $file)
                                {
                                    $extension=end(explode('.',$file));
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
                                     
                                        echo "<img src='uploads/imgs/".$file."' style='width:100%;height:150px'/>";
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
                    
                      
                      <button type="submit" class="btn btn-success mb-2 confirm" name="confirm">Confirm data</button>
                  </form>
              </div>
              
      <?php        
          
    }
    if($do == 'update_finished_jobs')
    {
        if($_SERVER['REQUEST_METHOD']=='POST')
        {
         ?>
            <div class="container">
               <h1 class="text-center">updating data</h1>
                
           <?php
            if(isset($_POST['confirm']))
            {
            $job_id =isset($_GET['job_id'])&& is_numeric($_GET['job_id'])?intval($_GET['job_id']):0;
              $job_name = filter_var($_POST['job_name'],FILTER_SANITIZE_STRING);
              $job_description = filter_var($_POST['job_description'],FILTER_SANITIZE_STRING);
              $job_link = filter_var($_POST['job_link'],FILTER_SANITIZE_STRING);
              $oldphotos=filter_var($_SESSION['photos_name'],FILTER_SANITIZE_STRING);
                $errors = array();

        if($_FILES['file']['size'][0]!=0)
         {
           $extensions =array("gif","jpeg","png",'txt',"jpg"); 
           foreach($_FILES['file']['name'] as $key =>$val)
           {

            if($_FILES['file']['size'][$key] > 4000000)
            {
               $errors[] = "<div class='alert text-center' style='color:red;font-weight:bold'> <i class='fas fa-exclamation-triangle'></i>".$val." size is more than 4 MG </div>";
            }
            $extension = strtolower(end(explode(".",$val)));
            
            if(!in_array($extension,$extensions))
            {
               $errors[] = "<div class='alert text-center' style='color:red;font-weight:bold'> <i class='fas fa-exclamation-triangle'></i>".$extension."  is not allowed extension </div>";
            }
           }
         }

                    if(empty($job_name)){$errors[]= '<div class="alert text-center" style="color:red;font-weight:bold"> <i class="fas fa-exclamation-triangle"></i>you cannot leave job\'s name empty</div>';}
                    if(empty($job_link)){$errors[]= '<div class="alert text-center" style="color:red;font-weight:bold"> <i class="fas fa-exclamation-triangle"></i>you cannot leave job\'s link empty</div>';}
                    if(strlen($job_name)<3){$errors[]= '<div class="alert text-center" style="color:red;font-weight:bold"> <i class="fas fa-exclamation-triangle"></i>you cannot leave job\'s name less than 3 character</div>';}
                    if($_FILES['file']['size'][0]!=0)
                     {
                        $photos_array=array();
                                    foreach($_FILES['file']['name'] as $key =>$val)
                                    {
                                        $name=rand(0,100000)."_".$val;
                                        $tmp_name=$_FILES['file']['tmp_name'][$key];
                                        if(move_uploaded_file($tmp_name,'uploads\imgs\\'.$name))
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
                    if(empty($allphotos))
                    {
                      $errors[] = "<div class='alert text-center' style='color:red;font-weight:bold'> <i class='fas fa-exclamation-triangle'></i>you must uplaod at least one photo</div>";
                    }
                    if(empty($errors))
                    {


                        $stmt2= mysqli_query($con,"update finished_jobs set job_name ='$job_name',job_link ='$job_link' ,jobs_screenshoots='$allphotos',description='$job_description' where job_id =$job_id");
                        if($num=mysqli_affected_rows($con)>0){
                             echo '<div class="alert text-center" style="color:#28a745;font-weight:bold;"><i class="fas fa-check"></i>one job updated , you will redirect to All jobs</div>';
                                                      unset($_SESSION['photos_name']);

                              redirect('',5,'?do=manage');
                              
                        }
                        else
                        {
                         unset($_SESSION['photos_name']);
                            echo '<div class="alert text-center" style="color:red;font-weight:bold"> <i class="fas fa-exclamation-triangle"></i>no update</div>';
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
        }
        else
        {
        
            redirect();
        }

              ?>
              
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
              $job_description = filter_var($_POST['job_description'],FILTER_SANITIZE_STRING);
              $job_owner = filter_var($_POST['job_owner'],FILTER_SANITIZE_NUMBER_INT);
              $jobownername = getTable('client_name,email',"clients","where client_id ='$job_owner'");
              $job_owner_name = $jobownername[0]['client_name'];              
              $job_owner_email = $jobownername[0]['email'];              
              $job_progress= filter_var($_POST['progress'],FILTER_SANITIZE_NUMBER_INT);
              $oldphotos=filter_var($_SESSION['photos_name'],FILTER_SANITIZE_STRING);
                $errors = array();

        if($_FILES['file']['size'][0]!=0)
         {
           $extensions =array("gif","jpeg","png",'txt',"jpg"); 
           foreach($_FILES['file']['name'] as $key =>$val)
           {

            if($_FILES['file']['size'][$key] > 4000000)
            {
               $errors[] = "<div class='alert text-center' style='color:red;font-weight:bold'> <i class='fas fa-exclamation-triangle'></i>".$val." size is more than 4 MG </div>";
            }
            $extension = strtolower(end(explode(".",$val)));
            
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
                                        if(move_uploaded_file($tmp_name,'uploads\imgs\\'.$name))
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
      
                    if(empty($job_name)){$errors[]= '<div class="alert text-center" style="color:red;font-weight:bold"> <i class="fas fa-exclamation-triangle"></i>you cannot leave job\'s name empty</div>';}
                    if(empty($job_description)){$errors[]= '<div class="alert text-center" style="color:red;font-weight:bold"> <i class="fas fa-exclamation-triangle"></i>you cannot leave job\'s description empty</div>';}
                    if(empty($job_owner)){$errors[]= '<div class="alert text-center" style="color:red;font-weight:bold"> <i class="fas fa-exclamation-triangle"></i>you cannot leave job\' owner empty</div>';}
                    if(strlen($job_name)<3){$errors[]= '<div class="alert text-center" style="color:red;font-weight:bold"> <i class="fas fa-exclamation-triangle"></i>you cannot leave job\'s name less than 3 character</div>';}
                    if(strlen($job_description)<100){$errors[]= '<div class="alert text-center" style="color:red;font-weight:bold"> <i class="fas fa-exclamation-triangle"></i>you cannot leave job\'s description less than 100 character</div>';}
    
                    if(empty($errors))
                    {

                        $stmt2= mysqli_query($con,"update jobs set job_name ='$job_name',job_description ='$job_description' ,job_owner='$job_owner',owner_name ='$job_owner_name',owner_email='$job_owner_email',photos='$allphotos',progress='$job_progress' where job_id =$job_id");
                        if($num=mysqli_affected_rows($con)>0){
                             echo '<div class="alert text-center" style="color:#28a745;font-weight:bold;"><i class="fas fa-check"></i>one job updated , you will redirect to All jobs</div>';
                            
                              redirect('',5,'?do=manage');                            

                        }
                        else
                        {
                            echo '<div class="alert text-center" style="color:red;font-weight:bold"> <i class="fas fa-exclamation-triangle"></i>no update</div>';
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
 if($do== 'pending')
    {
        $stmt = mysqli_query($con,"select distinct job_owner from jobs where status=0 ");
        $rows=$stmt->fetch_all(MYSQLI_NUM);
        if(empty($rows))
        {
            echo '<div class="alert container text-center"  style="color:red;font-weight:bold">no jobs</div>';
         
        }
        foreach($rows as $row)
        {
            $job_owner = $row["0"];
            $stmt1=mysqli_query($con,"select job_id from jobs where job_owner='$job_owner' and status=0");
            $rows1=$stmt1->fetch_all(MYSQLI_ASSOC);
            $stmt4=mysqli_query($con,"select client_name from clients where client_id='$job_owner'");
            $rows4=$stmt4->fetch_all(MYSQLI_ASSOC);            
            ?>
            <div class="container">

                <div class ="card">
                    <div class="card-header">
                        <span class="jobs-owner">job's owner</span>: <a href='clients.php?do=edit&client_id=<?php echo $job_owner;?>'><?php echo $rows4[0]['client_name'];?></a>
                        <div class="jobs-details">
                        <b class="hide-data point">Hide</b> |
                        <b class="show-data select">Show</b>
                        Details
                        </div>
                    </div>
                    <div class="card-body ">
                        <div>
                            <table class="table table-dark table-hover table-responsive-sm table-responsive-md table-responsive-lg">
                                <thead>
                                    <tr>
                                      <th scope="col">ID</th>
                                      <th scope="col">job_name</th>
                                      <th scope="col">Description</th>
                                      <th scope="col">Adding_date</th>
                                      <th scope="col">feedback</th>
                                      <th scope="col">operations</th>
                                      
                                    </tr>
                                </thead>
                        <?php
                         $id = isset($_GET['id'])&&is_numeric($_GET['id'])?intval($_GET['id']):0;

                            foreach($rows1 as $row1)
                            {
                                $job_id =$row1['job_id'];
                                $stmt2 = mysqli_query($con,"select jobs.*,clients.client_name,clients.client_id from jobs inner join clients on jobs.job_owner=clients.client_id where jobs.job_id=$job_id");
                                $rows2 = $stmt2->fetch_all(MYSQLI_ASSOC);
                                $client_id = $rows2[0]['client_id'];

                                if($rows2[0]['job_id']==$id)
                                {                                
                                        echo '
                                    
                                        <tbody>
                                            <tr id="'.$rows2[0]['job_id'].'" style="background:#476838">
                                              <td scope="row">'.$rows2[0]['job_id'].'</td>
                                              <td scope="row">'.$rows2[0]['job_name'].'</td>
                                              <td scope="row"><div style="min-width:300px">'.$rows2[0]['job_description'].'</div></td>
                                              <td scope="row"><div style="min-width:85px">'.$rows2[0]['adding_date'].'</div></td>
                                              <td scope="row">'.$rows2[0]['feedback'].'</td>
                                              <td scope="row">
                                               <div class = "button_row">
                                                <b>
                                                    <a href="?do=delete&job_id='.$rows2[0]["job_id"].'" class="btn btn-danger delete">Delete <i class="fas fa-user-minus"></i>
                                                    </a>
                                                </b>
                                                <b>
                                                    <a href="?do=edit&job_id='.$rows2[0]["job_id"].'&job_owner='.$client_id.'" class="btn btn-primary">Edit <i class="fa fa-edit"></i>
                                                    </a>
                                                </b>
                                                <b>
                                                    <a href="?do=activation&job_id='.$rows2[0]["job_id"].'&job_owner='.$client_id.'" class="btn btn-secondary activate confirm">activate</a>
                                                    </a>
                                                </b>
                                               </div>
                                              </td>
                                            <tr>
                                        </tbody>';
                                }
                                else
                                {
                                     echo '
                                     
                                        <tbody>
                                            <tr>
                                              <td scope="row">'.$rows2[0]['job_id'].'</td>
                                              <td scope="row">'.$rows2[0]['job_name'].'</td>
                                              <td scope="row"><div style="min-width:300px"><div style="min-width:300px">'.$rows2[0]['job_description'].'</div></td>
                                              <td scope="row"><div style="min-width:85px">'.$rows2[0]['adding_date'].'</div></td>
                                              <td scope="row">'.$rows2[0]['feedback'].'</td>
                                              <td scope="row">
                                               <div class = "button_row">
                                                <b>
                                                    <a href="?do=delete&job_id='.$rows2[0]["job_id"].'" class="btn btn-danger delete">Delete <i class="fas fa-user-minus"></i>
                                                    </a>
                                                </b>
                                                <b>
                                                    <a href="?do=edit&job_id='.$rows2[0]["job_id"].'&job_owner='.$client_id.'" class="btn btn-primary">Edit <i class="fa fa-edit"></i>
                                                    </a>
                                                </b>
                                                <b>
                                                    <a href="?do=activation&job_id='.$rows2[0]["job_id"].'&job_owner='.$client_id.'" class="btn btn-secondary activate confirm">activate</a>
                                                    </a>
                                                </b>
                                               </div>
                                              </td>
                                            <tr>
                                        </tbody>';
                                }
                            
                            }
                        ?>                                

                            </table>                                    
                        </div>
                    </div>
                </div>
                
            </div>
            <?php  
        }
            
            ?>
            <div class="container">
                   <a href="?do=add" class="btn btn-success confirm" style="width: 174px"> Add new job <i class="fas fa-plus"></i></a>
               </div>
            <?php
    }
    if($do=='activation')
    {
        $job_id =isset($_GET['job_id'])&& is_numeric($_GET['job_id'])?intval($_GET['job_id']):0;
        $rows = getTable('status','jobs',"where job_id='$job_id'");
        if($rows[0]['status']=='0')
        {
            $stmt = mysqli_query($con,"update jobs set status=1 where job_id='$job_id'");
            echo "<div class='alert text-center' style='color:#28a745;font-weight:bold;'><i class='fas fa-check'></i> Activated </div>";
            redirect('',2,'?do=manage');

        }
        else
        {
           $stmt1 = mysqli_query($con,"update jobs set status=0 where job_id='$job_id'");
            echo "<div class='alert text-center' style='color:red;font-weight:bold'> <i class='fas fa-exclamation-triangle'></i> Not Activated </div>";
            redirect('',2,'?do=pending');          
        }

    }
    include $tpl ."footer.php";
}
else
{
     header("location: login.php");
    exit();  
}
ob_end_flush();
}
?>