<?php
session_start();
include "init.php";
if(isset($_SESSION['user']))
{
    
 $client_email = $_SESSION['user'];
$stmt = mysqli_query($con,"update clients set last_activity =now() where email='$client_email'");
}
else
{
$client_email = $_SESSION['client'];
$stmt = mysqli_query($con,"update clients set last_activity =now() where email='$client_email'");    
}
include $tpl."footer.php";
?>