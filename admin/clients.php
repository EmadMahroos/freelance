<?php
ob_start();
session_start();

    include"init.php";

if(isset($_SESSION['user']))
{
    $email_for_mngr = $_SESSION['user'];
    $regstatusformngr = getTable("reg_status","clients","where email = '$email_for_mngr'");
    $regstatus_for_mngr = $regstatusformngr[0]['reg_status'];
    $do = isset($_GET['do']) ? $_GET['do'] : 'manage';
    if($do=='manage')
    {
    
        $stmt = mysqli_query($con,'select * from clients where reg_status=0 ');
        $rows = $stmt->fetch_all(MYSQLI_ASSOC);      
        if($regstatus_for_mngr==2)
        {
            $stmtadmins = mysqli_query($con,'select * from clients where reg_status=1');
            $rowsadmins = $stmtadmins->fetch_all(MYSQLI_ASSOC);      
        }
                
        ?>
            <div class="container">

                <h1 class ='text-center'> our clients</h1>                
                <table class="table table-dark table-hover table-responsive-sm table-responsive-md table-responsive-lg">
                        <thead>
                          <tr>
                            <th scope="col">ID</th>
                            <th scope="col">client_name</th>
                            <th scope="col">Address</th>
                            <th scope="col">email</th>
                            <th scope="col">start-date</th>
                            <th scope="col">phone-number</th>
                            <th scope="col">operations</th>
                            
                          </tr>
                        </thead>
                  <?php
                  foreach($rowsadmins as $admin)
                  {
                        $admin_id = isset($_GET['id'])&&is_numeric($_GET['id'])?intval($_GET['id']):0;

                        if($admin['client_id']==$admin_id)
                        {
                            echo '
                            <tbody>
                            
                              <tr id = "'.$admin['client_id'].'" style="background:#476838">
                                <td scope="row">'.$admin['client_id'].'</td>
                                <td scope="row">'.$admin['client_name'].' <i class="fas fa-unlock" style="color:#28a745"></i> </td>
                                <td scope="row">'.$admin['address'].'</td>
                                <td scope="row">'.$admin['email'].'</td>
                                <td scope="row"><div style="min-width:85px">'.$admin['start_date'].'</div></td>
                                <td scope="row">'.$admin['phone_number'].'</td>
                                <td scope="row">
                                <div class="button_row">
                                    <b>
                                        <a href="?do=delete&client_id='.$admin["client_id"].'" class="btn btn-secondary delete" title ="delete">delete <i class="fas fa-user-minus"></i>
                                        </a>
                                    </b>
                                    <b>
                                        <a href="?do=edit&client_id='.$admin["client_id"].'" class="btn btn-primary" title ="edit"> edit <i class="fa fa-edit"></i>
                                        </a>
                                    </b>                                    
                                </div>
                                </td>
                              </tr>
                            </tbody>
                            ';                            
                        }
                            else
                            {
                            echo '
                            <tbody>
                            
                              <tr id = "'.$admin['client_id'].'">
                                <td scope="row">'.$admin['client_id'].'</td>
                                <td scope="row">'.$admin['client_name'].' <i class="fas fa-unlock" style="color:#28a745"></i> </td>
                                <td scope="row">'.$admin['address'].'</td>
                                <td scope="row">'.$admin['email'].'</td>
                                <td scope="row"><div style="min-width:85px">'.$admin['start_date'].'</div></td>
                                <td scope="row">'.$admin['phone_number'].'</td>
                                <td scope="row">
                                <div class="button_row">
                                    <b>
                                        <a href="?do=delete&client_id='.$admin["client_id"].'" class="btn btn-secondary delete" title="delete">delete <i class="fas fa-user-minus"></i>
                                        </a>
                                    </b>
                                    <b>
                                        <a href="?do=edit&client_id='.$admin["client_id"].'" class="btn btn-primary" title ="edit"> Edit <i class="fa fa-edit"></i>
                                        </a>
                                    </b>                                    
                                </div>
                                </td>
                              </tr>
                            </tbody>
                            ';
                        }                    
                  }
                    foreach($rows as $row)
                    {
                        $id = isset($_GET['id'])&&is_numeric($_GET['id'])?intval($_GET['id']):0;

                        if($row['client_id']==$id)
                        {
                            echo '
                            <tbody>
                            
                              <tr id = "'.$row['client_id'].'" style="background:#476838">
                                <th scope="row">'.$row['client_id'].'</th>
                                <td scope="row">'.$row['client_name'].'</td>
                                <td scope="row">'.$row['address'].'</td>
                                <td scope="row">'.$row['email'].'</td>
                                <td scope="row"><div style="min-width:85px">'.$row['start_date'].'</div></td>
                                <td scope="row">'.$row['phone_number'].'</td>
                                <td scope="row">
                                <div class="button_row">
                                    <b>
                                        <a href="?do=delete&client_id='.$row["client_id"].'" class="btn btn-secondary delete" title="delete">delete <i class="fas fa-user-minus"></i>
                                        </a>
                                    </b>
                                    <b>
                                        <a href="?do=edit&client_id='.$row["client_id"].'" class="btn btn-primary" title="edit"> Edit <i class="fa fa-edit"></i>
                                        </a>
                                    </b>                                    
                                ';
                                if($regstatus_for_mngr==2)
                                {
                                    echo '
                                    <b>
                                        <a href="?do=set_admin&client_id='.$row["client_id"].'" class="btn btn-success" title="set admin"> Set Admin <i class="fa fa-user-plus"></i>
                                        </a>
                                    </b>';
                                }
                                
                             echo ' </div>
                                </td></tr>
                            </tbody>
                            ';                            
                        }
                            else
                            {
                            echo '
                            <tbody>
                            
                              <tr id = "'.$row['client_id'].'">
                                <th scope="row">'.$row['client_id'].'</th>
                                <td scope="row">'.$row['client_name'].'</td>
                                <td scope="row">'.$row['address'].'</td>
                                <td scope="row">'.$row['email'].'</td>
                                <td scope="row"><div style="min-width:85px">'.$row['start_date'].'</div></td>
                                <td scope="row">'.$row['phone_number'].'</td>
                                <td scope="row">
                                <div class="button_row">
                                    <b>
                                        <a href="?do=delete&client_id='.$row["client_id"].'" class="btn btn-secondary delete" title="delete">delete <i class="fas fa-user-minus"></i>
                                        </a>
                                    </b>
                                    <b>
                                        <a href="?do=edit&client_id='.$row["client_id"].'" class="btn btn-primary" title="edit"> Edit <i class="fa fa-edit"></i>
                                        </a>
                                    </b>                                    
                                ';
                                if($regstatus_for_mngr==2)
                                {
                                    echo '
                                    <b>
                                        <a href="?do=set_admin&client_id='.$row["client_id"].'" class="btn btn-success" title="set admin"> Set Admin <i class="fa fa-user-plus"></i>
                                        </a>
                                    </b>';
                                }
                                
                             echo ' </div>
                                </td>
                                </tr>
                            </tbody>
                            ';
                        }
                    }                      
                  ?>
                </table>
        <?php if(empty($rows))
        {
            echo '<div class="alert container text-center"  style="color:red;font-weight:bold">no clients</div>';
         
        }
        ?>
                <a href="?do=add" class="btn btn-success confirm" style="width: 190px"> Add new client <i class="fas fa-user-plus"></i></a>
            </div>        
        <?php
        
    }
    if($do=="set_admin")
    {
        if($regstatus_for_mngr ==2)
        {
            $client_id =isset($_GET['client_id'])&& is_numeric($_GET['client_id'])?intval($_GET['client_id']):0;
            $stmt = mysqli_query($con,"update clients set reg_status = 1 where client_id = '$client_id'");
            if(mysqli_affected_rows($con)>0)
            {
                echo '<div class="alert text-center" style="color:#28a745;font-weight:bold;"><i class="fas fa-check"></i> setting done </div>';            
            }
            else
            {
                echo '<div class="alert text-center" style="color:red;font-weight:bold"> <i class="fas fa-exclamation-triangle"></i>  setting failed </div>';            
            }
        }
        
    }
    if($do == 'add')
    {
    ?>

            <div class="container">
            <h1 class ='text-center'> Add a client</h1>
                <form class="myform1" action="?do=insert" method="post" enctype="multipart/form-data">
                    <div class="form-groub">
                        <label>client_name</label>
                        <input type="text" class="form-control" name="client_name" required="required">  
                    </div>
                    <div class="form-groub">
                        <label>client_address</label>
                        <input type="text" class="form-control"name="client_address" required="required">  
                    </div>
                    <div class="form-groub">
                        <label>phone_number</label>
                        <input type="text" class="form-control" name="client_number" required="required">  
                    </div>
                    <div class="form-groub">
                        <label>email</label>
                        <input type="email" class="form-control" name="client_email" required="required">  
                    </div>
                    <div class="form-groub">
                        <label>password</label>
                        <input type="password" class="form-control" name="client_pass" required="required">  
                    </div>
                    <div class="form-groub">
                        <label>logo or photo</label>
                        <input type="file" class="form-control" name="client_logo">  
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

                
                $client_name = filter_var($_POST['client_name'],FILTER_SANITIZE_STRING);
                $client_address = filter_var($_POST['client_address'],FILTER_SANITIZE_STRING);
                $client_number = filter_var($_POST['client_number'],FILTER_SANITIZE_NUMBER_INT);
                $client_email = filter_var($_POST['client_email'],FILTER_SANITIZE_EMAIL);
                $client_pass= filter_var($_POST['client_pass'],FILTER_SANITIZE_STRING);
                $client_shapass = sha1($client_pass);
                    $errors = array();         
                if(isset($_POST['confirm']))
                {

                    if($_FILES['client_logo']['size']!=0)
                     {
                       $extensions =array("gif","jpeg","png",'txt',"jpg");
                        if($_FILES['client_logo']['size']> 4000000)
                        {
                           $errors[] = "<div class='alert text-center' style='color:red;font-weight:bold'> <i class='fas fa-exclamation-triangle'></i>".$_FILES['client_logo']['name']." size is more than 4 MG </div>";
                        }           
                        $extension = strtolower(end(explode(".",$_FILES['client_logo']['name'])));
                        if(!in_array($extension,$extensions))
                        {
                           $errors[] = "<div class='alert text-center' style='color:red;font-weight:bold'> <i class='fas fa-exclamation-triangle'></i>".$extension."  is not allowed extension </div>";
                        }
                        $name=rand(0,100000)."_".$_FILES['client_logo']['name'];
                          $name=filter_var($name,FILTER_SANITIZE_STRING);
                        
                        $tmp_name=$_FILES['client_logo']['tmp_name'];
                        if(!move_uploaded_file($tmp_name,'uploads\imgs\\'.$name))
                        {
                            $errors[] = "<div class='alert text-center' style='color:red;font-weight:bold'> <i class='fas fa-exclamation-triangle'></i>".$name."  unread</div>";                
                        }     
                     }
                     else
                     {
                        $name="img.jpg";
                     }
                    if(empty($client_name)){$errors[]= '<div class="alert text-center" style="color:red;font-weight:bold"> <i class="fas fa-exclamation-triangle"></i>you cannot leave client name empty</div>';}
                    if(empty($client_pass)){$errors[]= '<div class="alert text-center" style="color:red;font-weight:bold"> <i class="fas fa-exclamation-triangle"></i>you cannot leave client password empty</div>';}
                    if(empty($client_email)){$errors[]= '<div class="alert text-center" style="color:red;font-weight:bold"> <i class="fas fa-exclamation-triangle"></i>you cannot leave client email empty</div>';}
                    if(empty($client_address)){$errors[]= '<div class="alert text-center" style="color:red;font-weight:bold"> <i class="fas fa-exclamation-triangle"></i>you cannot leave client address empty</div>';}
                    if(empty($client_number)){$errors[]= '<div class="alert text-center" style="color:red;font-weight:bold"> <i class="fas fa-exclamation-triangle"></i>you cannot leave client phone empty</div>';}
    
                    if(strlen($client_name)<3){$errors[]= '<div class="alert text-center" style="color:red;font-weight:bold"> <i class="fas fa-exclamation-triangle"></i>you cannot leave client name less than 3 character</div>';}
                    if(strlen($client_pass)<9){$errors[]= '<div class="alert text-center" style="color:red;font-weight:bold"> <i class="fas fa-exclamation-triangle"></i>you cannot leave client password less than 9 character</div>';}
                    if(searchingInDb('email','clients',$client_email)>0)
                    {
                        $errors[] = '<div class="alert text-center" style="color:red;font-weight:bold"> <i class="fas fa-exclamation-triangle"></i> this email is already exist </div>';
                        
                    }
    
                    if(empty($errors))
                    {
                        $stmt = mysqli_query($con,"insert into clients (client_name,address,phone_number,email,password,start_date,logo) values('$client_name','$client_address','$client_number','$client_email','$client_shapass',now(),'$name')");
                        if($stmt)
                        {
                            echo '<div class="alert text-center" style="color:#28a745;font-weight:bold;"><i class="fas fa-check"></i>one client inserted</div>';
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
        $client_id =isset($_GET['client_id'])&& is_numeric($_GET['client_id'])?intval($_GET['client_id']):0;
        if(isset($_SESSION['user']))

        {
           $email=$_SESSION['user'];
           
        }
        $reg_statuss = getTable('reg_status',"clients","where client_id='$client_id'");
        $reg_statuss=$reg_statuss[0]['reg_status'];
        if($reg_statuss==1||$reg_statuss==2)
        {
           $client_id_for_session= getTable('client_id,reg_status',"clients","where email='$email'");
           $client_ids=$client_id_for_session[0]['client_id'];
           $regstatuss=$client_id_for_session[0]['reg_status'];
           if($client_ids == $client_id || $regstatuss == 2)
            { 
                    $stmt = mysqli_query($con,"select * from clients where client_id=$client_id");
                    $row= $stmt->fetch_row();
                ?>
            
                        <div class="container">
                        <h1 class ='text-center'> edit my profile</h1>
                            <form class="myform1" action="?do=update&client_id=<?php echo $client_id ;?>" method="post" enctype="multipart/form-data">
                                <div class="form-groub">
                                    <label>client_name</label>
                                    <input type="text" class="form-control" name="client_name" value="<?php echo $row['1'];?>">  
                                </div>
                                <div class="form-groub">
                                    <label>client_address</label>
                                    <input type="text" class="form-control"name="client_address" value="<?php echo $row['2'];?>">  
                                </div>
                                <div class="form-groub">
                                    <label>phone_number</label>
                                    <input type="text" class="form-control" name="client_number" value="<?php echo $row['4'];?>">  
                                </div>
                                <div class="form-groub">
                                    <label>email</label>
                                    <input type="email" class="form-control" name="client_email" value="<?php echo $row['3'];?>">  
                                </div>
                                <div class="form-groub">
                                    <label>password</label>
                                    <input type="password" class="form-control" name="client_pass">  
                                    <input type="hidden" class="form-control" name="client_oldpass" value="<?php echo $row['5'];?>">  
                                </div>
                                <div class="form-groub">
                                    <label>update_your_photo</label>
                                    <input type="file" class="form-control" name="client_logo">  
                                </div>                                
                                <button type="submit" class="btn btn-success mb-2 confirm" name="confirm">Confirm data</button>
                            </form>
                        </div>
                        
                <?php        
            }
            else
            {
                     echo " <div class='alert text-center'  style='color : red; font-weight:bold'> you have no permission to visit this page</div>";
                
            }
        }
        else
        {
            $stmt = mysqli_query($con,"select * from clients where client_id=$client_id");
                            $row= $stmt->fetch_row();
                        ?>
                    
                                <div class="container">
                                <h1 class ='text-center'> edit a client</h1>
                                    <form class="myform1" action="?do=update&client_id=<?php echo $client_id ;?>" method="post" enctype="multipart/form-data">
                                        <div class="form-groub">
                                            <label>client_name</label>
                                            <input type="text" class="form-control" name="client_name" value="<?php echo $row['1'];?>">  
                                        </div>
                                        <div class="form-groub">
                                            <label>client_address</label>
                                            <input type="text" class="form-control"name="client_address" value="<?php echo $row['2'];?>">  
                                        </div>
                                        <div class="form-groub">
                                            <label>phone_number</label>
                                            <input type="text" class="form-control" name="client_number" value="<?php echo $row['4'];?>">  
                                        </div>
                                        <div class="form-groub">
                                            <label>email</label>
                                            <input type="email" class="form-control" name="client_email" value="<?php echo $row['3'];?>">  
                                        </div>
                                        <div class="form-groub">
                                            <label>password</label>
                                            <input type="password" class="form-control" name="client_pass">  
                                            <input type="hidden" class="form-control" name="client_oldpass" value="<?php echo $row['5'];?>">  
                                        </div>
                                        <div class="form-groub">
                                            <label>update_avatar</label>
                                            <input type="file" class="form-control" name="client_logo">  
                                        </div>                                            
                                        <button type="submit" class="btn btn-success mb-2 confirm" name="confirm">Confirm data</button>
                                    </form>
                                </div>
                                
                        <?php               
            
        }
    }
    if($do == 'update')
    {
        if($_SERVER['REQUEST_METHOD']=='POST')
        {
         ?>
            <div class="container">
               <h1 class="text-center">updating data</h1>
                
           <?php
            $client_id =isset($_GET['client_id'])&& is_numeric($_GET['client_id'])?intval($_GET['client_id']):0;
              
              $client_name = filter_var($_POST['client_name'],FILTER_SANITIZE_STRING);
              $client_address = filter_var($_POST['client_address'],FILTER_SANITIZE_STRING);
              $client_number = filter_var($_POST['client_number'],FILTER_SANITIZE_NUMBER_INT);
              $client_email = filter_var($_POST['client_email'],FILTER_SANITIZE_EMAIL);
              $client_pass= filter_var($_POST['client_pass'],FILTER_SANITIZE_STRING);
              $client_oldpass= filter_var($_POST['client_oldpass'],FILTER_SANITIZE_STRING);
              $stmt = mysqli_query($con,"select email from clients where email ='$client_email'and client_id!='$client_id'");
              $count =mysqli_num_rows($stmt);
              $errors = array();
            if($_FILES['client_logo']['size']!=0)
             {

               $extensions =array("gif","jpeg","png",'txt',"jpg");
                if($_FILES['client_logo']['size']> 4000000)
                {
                   $errors[] = "<div class='alert text-center' style='color:red;font-weight:bold'> <i class='fas fa-exclamation-triangle'></i>".$_FILES['client_logo']['name']." size is more than 4 MG </div>";
                }           
                $extension = strtolower(end(explode(".",$_FILES['client_logo']['name'])));
                if(!in_array($extension,$extensions))
                {
                   $errors[] = "<div class='alert text-center' style='color:red;font-weight:bold'> <i class='fas fa-exclamation-triangle'></i>".$extension."  is not allowed extension </div>";
                }
                $name=rand(0,100000)."_".$_FILES['client_logo']['name'];
              $name=filter_var($name,FILTER_SANITIZE_STRING);
                
                $tmp_name=$_FILES['client_logo']['tmp_name'];
                if(!move_uploaded_file($tmp_name,'uploads\imgs\\'.$name))
                {
                    $errors[] = "<div class='alert text-center' style='color:red;font-weight:bold'> <i class='fas fa-exclamation-triangle'></i>".$name."  unread</div>";                
                }     
             }
             else
             {
                $namee = getTable("logo","clients","where client_id = '$client_id'");
               $name=$namee[0]['logo'];
             }
             if(empty($name)){
                $name='img.jpg';
             }
                    if(empty($client_name)){$errors[]= '<div class="alert text-center" style="color:red;font-weight:bold"> <i class="fas fa-exclamation-triangle"></i>you cannot leave client name empty</div>';}
                    if(empty($client_pass)||sha1($client_pass)==$client_oldpass)
                    {
                         $client_pass=$client_oldpass;
                    }
                    else
                    {
                        if(strlen($client_pass)<9){$errors[]= '<div class="alert text-center" style="color:red;font-weight:bold"> <i class="fas fa-exclamation-triangle"></i>you cannot leave client password less than 9 character</div>';}
                        
                            $client_pass = sha1($client_pass);
                    }
                    if(empty($client_email)){$errors[]= '<div class="alert text-center" style="color:red;font-weight:bold"> <i class="fas fa-exclamation-triangle"></i>you cannot leave client email empty</div>';}
                    if(empty($client_address)){$errors[]= '<div class="alert text-center" style="color:red;font-weight:bold"> <i class="fas fa-exclamation-triangle"></i>you cannot leave client address empty</div>';}
                    if(empty($client_number)){$errors[]= '<div class="alert text-center" style="color:red;font-weight:bold"> <i class="fas fa-exclamation-triangle"></i>you cannot leave client phone empty</div>';}
    
                    if(strlen($client_name)<3){$errors[]= '<div class="alert text-center" style="color:red;font-weight:bold"> <i class="fas fa-exclamation-triangle"></i>you cannot leave client name less than 3 character</div>';}
                    if($count>0)
                    {
                        $errors[] = '<div class="alert text-center" style="color:red;font-weight:bold"> <i class="fas fa-exclamation-triangle"></i> this email is already exist </div>';
                        

                    }
                    if(empty($errors))
                    {

                        $stmt2= mysqli_query($con,"update clients set client_name ='$client_name',address ='$client_address' ,phone_number='$client_number',email= '$client_email',password='$client_pass',logo ='$name' where client_id =$client_id");
                        if($num=mysqli_affected_rows($con)>0){
                             echo '<div class="alert text-center" style="color:#28a745;font-weight:bold;"><i class="fas fa-check"></i>one client updated</div>';
                             echo '<div class = "alert text-center" style="color:#28a745;font-weight:bold;"><i class="fas fa-check"></i>you will redirect to All clients</div>';
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
    if($do == 'delete')
    {
        ?>
        <div class="container">
            <h1 class="text-center">delete a client </h1>
            <?php
             $client_id =isset($_GET['client_id'])&& is_numeric($_GET['client_id'])?intval($_GET['client_id']):0;
            $reg_statuss = getTable('reg_status',"clients","where client_id='$client_id'");
            $reg_statuss=$reg_statuss[0]['reg_status'];
            if(isset($_SESSION['user']))
    
            {
               $email=$_SESSION['user'];
               
            }
           $client_id_for_session= getTable('client_id,reg_status',"clients","where email='$email'");
           $client_ids=$client_id_for_session[0]['client_id'];
           $regstatuss=$client_id_for_session[0]['reg_status'];            
            if($reg_statuss!=0)
            {
                if($regstatuss==2)
                {
                    $stmt = mysqli_query($con,"delete from clients where client_id='$client_id'");
                    $count = mysqli_affected_rows($con);
                    if($count>0)
                    {
                        echo '<div class="alert text-center" style="color:#28a745;font-weight:bold;"><i class="fas fa-check"></i>one client deleted</div>';
                        redirect();
                    }
                    else
                    {
                        echo '<div class="alert text-center" style="color:red;font-weight:bold"> <i class="fas fa-exclamation-triangle"></i>no client deleted</div>';
                        redirect();
        
                    }                    
                }
                else
                {
                echo '<div class="alert text-center" style="color:red;font-weight:bold"> <i class="fas fa-exclamation-triangle"></i> you have no permission to delete this account</div>';
                }               
            }
            else
            {
                $stmt = mysqli_query($con,"delete from clients where client_id='$client_id'");
                $count = mysqli_affected_rows($con);
                if($count>0)
                {
                    echo '<div class="alert text-center" style="color:#28a745;font-weight:bold;"><i class="fas fa-check"></i>one client deleted</div>';
                    redirect();
                }
                else
                {
                    echo '<div class="alert text-center" style="color:red;font-weight:bold"> <i class="fas fa-exclamation-triangle"></i>no client deleted</div>';
                    redirect();
    
                }
                
            }
    ?>
            </div>
            <?php
    }
    include $tpl . 'footer.php';
}
else
{
        header('location: login.php');
       exit(); 
    
}
ob_end_flush();