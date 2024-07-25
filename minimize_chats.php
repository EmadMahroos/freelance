<?php
session_start();
$nonavbar='';
include"init.php";
if(isset($_POST['client_name'])&&isset($_POST['client_id'])&&isset($_POST['sender']))
{
     $client_id=$_POST['client_id'];
    $client_name=$_POST['client_name'];
    $senderid=$_POST['sender'];
        ?>
    <div class="admin <?php echo $client_id?>" data-class="<?php echo $client_id;?>">
      <div class="admin-info" style="display: none">
        <span class="client_id" data-class="<?php echo $client_id?>"></span>
        <span class="sender_id" data-class="<?php echo $senderid?>"></span>
        <span class="client_name" data-class="<?php echo $client_name?>"></span>
      </div>
      <img src="admin/uploads/imgs/8896_20180903_090911.jpg" title="<?php echo $client_name?>">

  </div>

    <script>
    $(".minimizing-chats .admin").click(function(){
      
      var varclient_id =$(this).find('.client_id').data('class');
        $(".chats").find("."+varclient_id).css("display","block");
        $(this).remove();

    });

     
    </script>
  <?php

}
?>