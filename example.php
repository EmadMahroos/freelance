<?php
ob_start();
session_start();

include"init.php";
if(isset($_GET['name'])){
        echo $_GET['name']; 
}

?>
  
  
<?php
include $tpl . "footer.php";

ob_end_flush();
?>