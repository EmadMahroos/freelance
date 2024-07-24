<?php
session_start();

if(isset($_SESSION['user']))
{

           header('location: index.php');
           exit();
}
   $nonavbar='';
  include 'init.php';

?>
<div class="container admin-login">
    <form action="<?php $_SERVER['PHP_SELF'];?>" method="post" class="myform">
        <div class="form-group">
            <label for="exampleInputEmail1">Email address</label>
            <input type="email"  name="mail" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" value='<?php if(isset($_COOKIE["email"])){echo $_COOKIE["email"];}?>'>
            <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
        </div>
        <div class="form-group required">
              <label for="exampleInputPassword1">Password</label>
         <i class="fa fa-eye show-password"></i>

              <input type="password" name="pass" class="form-control password" id="exampleInputPassword1" value='<?php if(isset($_COOKIE["password"])){echo $_COOKIE["password"];}?>'>
        </div>
        <div class="form-group form-check">
            <input type="checkbox" class="form-check-input" id="exampleCheck1" name='rememberme'<?php if(isset($_COOKIE["email"])){?> checked <?php } ?>>
            <label class="form-check-label" for="exampleCheck1">remembr me </label>
        </div>
        <button type="submit" class="btn btn-primary" name="login">Submit</button>
        <?php
if(isset($_SERVER['REQUEST_METHOD'])=="post"){
    if(isset($_POST['login'])){
      $email = filter_var($_POST['mail'],FILTER_SANITIZE_EMAIL);
      $password = filter_var($_POST['pass'],FILTER_SANITIZE_STRING);
      $shapass=sha1($password);
      
      $stmt = mysqli_query($con,"select * from clients where email = '$email'and password = '$shapass'and reg_status=1 or reg_status = 2");
      $row = $stmt->fetch_row();
      if(!empty($row))
      {
         $_SESSION['user']=$email;

         if(isset($_POST['rememberme'])){
          setcookie("email",$email,time()+4444444440);
          setcookie("password",$password,time()+44444444440);
         }
         else
         {

           setcookie("email","",time()-4444444440);
           setcookie("password","",time()-444444444440);      
         }
         header("location:index.php");
         exit();

      }else
      {
         echo '<div class="alert text-center" style="color:red;font-weight:bold"> <i class="fas fa-exclamation-triangle"></i>the password or email is wrong</div>';
      }

    
   }
   ?>
    </form>
</div>


    <?php
}
include $tpl . "footer.php";
?>