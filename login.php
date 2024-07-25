<?php
session_start();
	$title='Log In | Sign Up';
 $nonavbar='';

?>

<Style>

	body{
		background: url('layout/images/effiel.jpg')  no-repeat !important;
		background-size: 100% 200% !important;
		background-position:center top !important;
		background-attachment: fixed !important;

	}
</Style>
<?php include 'init.php';
	if(isset($_SESSION['user'])||isset($_SESSION['client']))
	{
	header('location: index.php');
	exit();
	}	
	if($_SERVER['REQUEST_METHOD']=='POST')
	{
		if(isset($_POST['login']))
		{
     $email     = filter_var($_POST['email'],FILTER_SANITIZE_EMAIL);
     $pass     = filter_var($_POST['password'],FILTER_SANITIZE_STRING);
     $hashpass = sha1($pass);
     $stmt = mysqli_query($con,"select email ,password ,client_id from clients where email = '$email' and password = '$hashpass'");
     $row= $stmt->fetch_row();
     if(mysqli_num_rows($stmt)> 0)
     {
       $_SESSION['client'] = $email;
       $_SESSION['pass'] = $pass ;
       $_SESSION['uid'] = $row['2'];

       if(isset($_POST['remember_me']))
       {
         setcookie("client_email",$email,time()+(3333340));
         setcookie("client_password",$pass,time()+(3333340));
        
       }
       else
       {
         setcookie("client_email",'');
         setcookie("client_password",'');
       }
      
       header('location: index.php');
       exit();
     }
     else
     {
      echo '<div class = "alert alert-danger"> there are no such account</div>';
     }
		}
		else
		{
     $client_name = filter_var($_POST['client_name'],FILTER_SANITIZE_STRING);
     $url = filter_var($_POST['url'],FILTER_SANITIZE_STRING);
     $client_number = filter_var($_POST['client_number'],FILTER_SANITIZE_STRING);
     $address = filter_var($_POST['address'],FILTER_SANITIZE_STRING);
     $email = filter_var($_POST['email'],FILTER_SANITIZE_EMAIL);

     $password =filter_var($_POST['password'],FILTER_SANITIZE_STRING);
     $hashpass = sha1($password);
     
  
     $errors = array();
					
            if(!empty($url))
             {
               $extensions =array("gif","jpeg","png","jpg");
															#image size of bytes [i have split every sting in the img content]
                if( $e =count(str_split(file_get_contents("admin/uploads/imgs/".$url))) > 4000000)
                {
                   $errors[] = "<div class='alert alert-danger'>".$url." size is more than 4 MG </div>";
                }
                $extension = strtolower(end(explode(".",$url)));
                if(!in_array($extension,$extensions))
                {
                   $errors[] = "<div class='alert alert-danger'>".$extension."  is not allowed extension </div>";
                }
              $url=filter_var($url,FILTER_SANITIZE_STRING);
                
                if(!file_get_contents('admin\uploads\imgs\\'.$url))
                {
                    $errors[] = "<div class='alert alert-danger'>".$url."  unread</div>";                
                }     
             }
													else
													{
														$url='img.jpg';
													}
      if(strlen($client_name) < 4 || strlen($client_name) > 20)
      {
       $errors [] = '<div class ="alert alert-danger"> the user name must be<strong> between 4 and 20 characters</strong></div>';
  
      } 				
    
     if(empty($_POST['password'])){
      $errors [] = '<div class ="alert alert-danger">password must not be  <strong>empty</strong></div>';
     }
     if(isset($_POST['password'])&&isset($_POST['password2']))
     {
      if (sha1($_POST['password'])!==sha1($_POST['password2'])) 
       {
        $errors [] = '<div class ="alert alert-danger">no identical  <strong>password</strong></div>';
       
       }
     }
      if(searchingInDb('email','clients',"$email")>0)
      {
       $errors [] = '<div class ="alert alert-danger"> use another <strong> email</strong></div>';					
  
      }
      if(empty($errors))
      {
       $_SESSION['client'] = $email;
       $newrow = mysqli_query($con,"insert into clients (client_name,address,phone_number,password,email,start_date,logo)values('$client_name','$address','$client_number','$hashpass','$email',now(),'$url')");
							if(mysqli_affected_rows($con)>0)
							{
								
							header("location: index.php");
       exit();
						}
      }
  
     echo '</div>';			
		}
	}


?>
	<div class="container">
    <div class="login-box"> 
       <h1 > <span data-class="login" class="selected">Log In</span> | <span data-class="signup"> Sign Up</span></h1>
       <form action="<?php $_SERVER['PHP_SELF']?>" method="POST" class="login">
          <div class='lb'>
             <i class="fas fa-user-circle"></i>
             <input  pattern=".{4,40}" title="email must between 4and 20 chars"type="email" name="email" placeholder="Username" required="required"value=" <?php if(isset($_COOKIE['client_email']))echo $_COOKIE['client_email'] ?>">
          </div>	
          <div class="required lb">
             <i class="fas fa-unlock"></i>
             <i class="fa fa-eye show-password"></i>
             <input type="password" name="password" placeholder="password" required="required" value="<?php if(isset($_COOKIE['client_password']))echo $_COOKIE['client_password'] ?>" >
          </div>
          <div class="form-group form-check lb">
              <input type="checkbox" class="form-check-input" id="exampleCheck1" name='remember_me'<?php if(isset($_COOKIE["client_email"])){echo 'checked';}?>>
              <label class="form-check-label" for="exampleCheck1">remembr me </label>
          </div>          
            <div class="submit1 lb">
             <input type="submit" name="login" class="btn btn-primary" value="Log In">
          </div>
         </form>

<form action="<?php $_SERVER['PHP_SELF']?>" method="POST"  class="signup" enctype="multipart/form-data">
<input type="text" id='crpimg' name="url" style="display: none"/>
		<div class="row pic_div">
			<div class="col-md-12 ">
				<div class="image_area">
						<label for="upload_image" style="position: relative">
							<img src="admin/uploads/imgs/img.jpg" id="uploaded_image" class="pic img-thumbnail"/>
							<div class="overlay">
								<div class="text1">
									 profile image

								</div>
										<input type="file" class="image" id="upload_image"  style="display: none"/>

							</div>
						</label>

				</div>
			</div>
		</div>
		<div class="modal" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header" style="color: #28a745 ;">
        <h5 class="modal-title" id="exampleModalLongTitle">crop image before upload</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color: #28a745 ;" id = "clos">
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
        <button type="button" class="btn btn-primary" id="crop">crop</button>
      </div>
    </div>
  </div>
</div>
      
          <div class='lb'>
             <i class="fas fa-user-circle"></i>
             <input pattern=".{4,20}" title="username must between 4and 20 chars" type="text" name="client_name" placeholder="Username" required="required">
          </div>
										<div class='lb'>
             <i class="fas fa-phone"></i>
             <input type="text" name="client_number" placeholder="phone NUmber" required="required">
          </div>
          <div class='lb'>
             <i class="fas fa-user-circle"></i>
             <input  pattern=".{4,20}" title="address must between 4and 20 chars"type="text" name="address" placeholder="Address" >
          </div>				
          <div class="required lb">
             <i class="fas fa-unlock"></i>
													<i class="fa fa-eye show-password"></i>

             <input  minlength="8"type="password" name="password" placeholder="password" required="required">
          </div>
          <div class="required lb">
             <i class="fas fa-unlock"></i>
													<i class="fa fa-eye show-password"></i>
             <input type="password" name="password2" placeholder="re-type password" required="required">
          </div>				
          <div class='lb'>
           
            <input type="email" name="email" placeholder="E-mail" required="required">
          </div>				
          <div class="submit1 lb">
            <input type="submit" name="signup" class="btn btn-primary" value="sign up">
          </div>
       </form>			
    
    </div>
	</div>

	<?php
			echo '<div class = "container errors">';
			if(!empty($errors)){
				foreach ($errors as $error)
				{
				  echo $error . '<br>';   
				}   			
			}
			echo '</div>';
	?>


<?php include $tpl . 'footer.php';?>
