<?php
session_start();
include"connect.php";
if(isset($_POST['image'])){
    $data = $_POST['image'];
    $array1 = explode(';',$data);
    $array2 = explode(',',$array1[1]);
    $data = base64_decode($array2[1]);
    $image_name = 'admin/uploads/imgs/' . time() . '.png';
    file_put_contents($image_name,$data);    
    if(isset($_SESSION['user'])||isset($_SESSION['client']))
    {
        $email = isset($_SESSION['user'])?$_SESSION['user']:$_SESSION['client'];
        $image = end(explode("/",$image_name));
        $stmt = mysqli_query($con,"update clients set logo = '$image' where email = '$email'");
            echo $image_name;
        
    }
    else
    {
            echo $image_name;

    }
}

?>
