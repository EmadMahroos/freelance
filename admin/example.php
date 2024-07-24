<?php
ob_start();
session_start();

include"init.php";
$do=isset($_GET['do'])?$_GET['do']:'title';
if($do=="title")
{
   if(isset($_POST['submit']))
   {
      if(isset($_FILES['file']))
      {
         foreach($_FILES['file']['error'] as $num =>$value)
         {
            echo $value;
         }
         echo "<pre>";
         print_r($_FILES['file']);
         echo "<pre>";
         
      }
    
      
   }
?>
   <form enctype="multipart/form-data" method="POST">
      <input type="file" name="file[]" multiple>
      <input type="submit" name="submit" >
      
   </form>
<?php
   
}



include$tpl . "footer.php";
ob_end_flush();
?>
  
  
