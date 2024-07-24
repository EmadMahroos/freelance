<?php
ob_start();

$con = mysqli_connect("localhost","root","",'design');
if(mysqli_connect_errno()){
    die( mysqli_connect_error());
}else{
mysqli_query($con,"set names 'utf8'");
    
}
ob_end_flush();