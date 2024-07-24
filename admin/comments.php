<?php
ob_start();
session_start();

if(isset($_SESSION['user']))
{
    include "init.php";
   $do = isset($_GET['do']) ? $_GET['do'] : 'manage';  //if we have no get to do .. make get['do'] = manage
   
    if ($do == 'manage')
    {
?>
      <h1 class="text-center">manage comments</h1>
      <div class="container">
        <div class="table-responsive">


 <?php     
              $stmt =mysqli_query($con,"
                      select comments.* ,
                      finished_jobs.job_name ,
                      clients.client_name,clients.email
                      from comments 
                      inner join finished_jobs on finished_jobs.job_id = comments.comment_job 
                      inner join clients on clients.client_id = comments.comment_owner 
                        ");
              $rows = $stmt->fetch_all(MYSQLI_ASSOC);
          if(empty($rows))
          {
?>
          <table class="table table-dark text-center">
            <tr>
              <th style="color:white">#ID</th>
              <th style="color:white">comment</th>
              <th style="color:white">item name</th>
              <th style="color:white">user name</th>
              <th style="color:white">comment Date</th>
              <th style="color:white">Control</th>
              <th style="color:white">Activation</th>
            </tr>  
          </table>
  <?php 
            echo '<div class="alert container text-center"  style="color:red;font-weight:bold">no comments</div>';
          }
          else
            {
?>
            <table class="table table-dark table-hover table-responsive-sm table-responsive-md table-responsive-xl table-responsive-lg">
              <tr>
                <td>#ID</td>
                <td>comment</td>
                <td>job_name</td>
                <td>client_name</td>
                <td>client_email</td>
                <td>comment_Date</td>
                <td>Control</td>
              </tr>              
  <?php
                foreach ($rows as  $row) 
                  {
                     $id = isset($_GET['id'])&&is_numeric($_GET['id'])?intval($_GET['id']):0;
   
                     if($row['comment_id']==$id)
                     {                   
                       echo '<tr id="'.$row['comment_id'].'" style="background:#476838">
                            <td> '. $row["comment_id"].'</td>
                            <td> <div>'. $row["comment"]. '</div></td>
                            <td>'. $row["job_name"]. '</td>
                            <td> '. $row["client_name"]. '</td>
                          <td> '. $row["email"].'</td>
                            <td>'. $row["adding_date"]. '</td>
                            <td scope="row">
                              <div class = "comment2 button_row">
                                <b>
                                    <a href="?do=delete&comment_id='.$row['comment_id'].'" class="btn btn-danger delete">Del <i class="fas fa-user-minus"></i></a>
                                </b>
                                <b>
                                    <a href="?do=edit&comment_id='.$row['comment_id'].'&comment_owner='.$row['comment_owner'].'" class="btn btn-primary">Edit <i class="fa fa-edit"></i></a>
                                </b>
                              </div>
                             </td>
                          </tr>' ;        
                     }
                     else
                     {
                       echo '<tr id="'.$row['comment_id'].'">
                            <td> '. $row["comment_id"].'</td>
                            <td> <div>'. $row["comment"]. '</div></td>
                            <td>'. $row["job_name"]. '</td>
                            <td> '. $row["client_name"]. '</td>
                          <td> '. $row["email"].'</td>
                            <td>'. $row["adding_date"]. '</td>
                            <td scope="row">
                              <div class = "comment2 button_row">
                                <b>
                                    <a href="?do=delete&comment_id='.$row['comment_id'].'" class="btn btn-danger delete">Del <i class="fas fa-user-minus"></i></a>
                                </b>
                                <b>
                                    <a href="?do=edit&comment_id='.$row['comment_id'].'&comment_owner='.$row['comment_owner'].'" class="btn btn-primary">Edit <i class="fa fa-edit"></i></a>
                                </b>
                              </div>
                             </td>
                          </tr>' ;                       
                     }
                  }
                  echo '</table>';
            }
     }
    elseif($do== 'edit')
    {
       $comment_id =  isset($_GET['comment_id'])&&is_numeric($_GET['comment_id'])?intval($_GET['comment_id']) :0;

      $stmt =mysqli_query($con,"select * from comments where comment_id ='$comment_id' ");
      $row = $stmt->fetch_row();
      if(mysqli_num_rows($stmt)> 0)
        {
  
            ?> 
                 <h1 class="text-center">Edit comments</h1>
                   <div class="container">
                     <form class="myform1" action="?do=update&comment_id= <?php echo $comment_id ;?>" method="post">
       
                       <div  class=" form-group">
                         <label>comment</label>
                           <input type='text' class="form-control" name="comment"value='<?php echo $row['1'];?>'/>
                       </div>
       
                       <div class="form-group" >
                         <input type="submit" name="submit" value="Save" class="btn btn-primary" >
                       </div>
                     </form>
                   </div>
              <?php      
        }
        else
        {
            redirect();
        }
    } 
  
   elseif($do == 'update')
    {
        echo '<h1 class="text-center">updated Profile</h1> ';
        echo "<div class = 'container'>";

        if($_SERVER['REQUEST_METHOD'] == 'POST')
        {
            
            $comment =filter_var($_POST['comment'],FILTER_SANITIZE_STRING);
            $comment_id =  isset($_GET['comment_id'])&&is_numeric($_GET['comment_id'])?intval($_GET['comment_id']) :0;
            if(empty(trim($comment)))
            {
             $error='<div class="alert text-center" style="color:red;font-weight:bold"> <i class="fas fa-exclamation-triangle"></i> your comment is empty </div>';
            }
            if(empty($error))
            {

              $stmt = mysqli_query($con,"update comments set comment = '$comment' where comment_id = $comment_id ");             
              if( mysqli_affected_rows($con)> 0)
              {
                 echo '<div class="alert text-center" style="color:#28a745;font-weight:bold;"><i class="fas fa-check"></i> one comment updated </div>';
                   redirect("",3,"comments.php#".$comment_id);
              }
              else
              {
              echo '<div class="alert text-center" style="color:red;font-weight:bold"> <i class="fas fa-exclamation-triangle"></i> no update </div>';
              redirect();
              }
            }
            else
            {
             echo $error;
             redirect();
            }
    
        }
        else
        {
              echo '<div class="alert text-center" style="color:red;font-weight:bold"> <i class="fas fa-exclamation-triangle"></i> you can\'t open this page directly</div>';
              redirect();
        }
            echo "</div>";    
    }
    elseif($do=='delete')
    {
?>
  
      <h1 class="text-center">deleted comment</h1>
      <div class="container">



<?php 
   $comment_id =  isset($_GET['comment_id'])&&is_numeric($_GET['comment_id'])?intval($_GET['comment_id']) :0;

      $stmt = $con ->query("delete from comments where comment_id= '$comment_id' ");
                  if(mysqli_affected_rows($con)> 0){
                       echo '<div class="alert text-center" style="color:#28a745;font-weight:bold;"><i class="fas fa-check"></i> one comment deleted </div>';
                   redirect("",3,"comments.php#".$comment_id);

                      
                    }
                    else{
                    
                      echo '<div class="alert text-center" style="color:red;font-weight:bold"> <i class="fas fa-exclamation-triangle"></i> no comments deleted</div>';
                      redirect();
                    }

      echo '</div>';
    }    

    include $tpl ."footer.php";

}

else{
    header('location: index.php');
    exit();
}
ob_end_flush();
?>
     