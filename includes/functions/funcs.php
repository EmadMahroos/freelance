<?php
include "connect.php";
function redirect($page='index.php',$time=5,$default=NULL)
{
   if($default==NULL)
   {
       if(isset($_SERVER['HTTP_REFERER']))
       {
           $page= $_SERVER['HTTP_REFERER'];
       }
   }
   else
   {
      $page=$default;
   }
   header("refresh:$time;url=$page");
   exit();
}

function searchingInDb($col , $table , $key)
{
    global $con;
    $stmt = mysqli_query($con,"select $col from $table where $col = '$key'");
    $column = $stmt->fetch_all(MYSQLI_ASSOC);
    $count = mysqli_num_rows($stmt);
    return $count;
}
function getTable($col,$table,$countinous=""){
   global $con;
   $stmt = mysqli_query($con,"select $col from $table $countinous");
   $rows = $stmt->fetch_all(MYSQLI_ASSOC);
   return $rows;

}
function counter($table,$continues=""){
    global $con;
   $stmt = mysqli_query($con,"select * from $table $continues");
    return mysqli_num_rows($stmt);
}