<?php
ob_start();
session_start();
include "init.php";
            if(isset($_SESSION['user']))

            {
               $email=$_SESSION['user'];
               
            }
           $client_id_for_session= getTable('client_id',"clients","where email='$email'");
           $client_ids=$client_id_for_session[0]['client_id'];   
if(isset($_POST['submit_search']))
{
 $category =isset($_POST['category'])?mysqli_real_escape_string($con,$_POST['category']):null;
 $search =isset($_POST['search'])?mysqli_real_escape_string($con,trim($_POST['search'])):null;
 if(!empty($category)&&!empty($search))
 {
    if($category =='users')
    {
        $searching = getTable("*","clients","where reg_status = 0 and(client_name like '%$search%' or email like '%$search%' or address like '%$search%' or phone_number like '%$search%' or start_date like '%$search%' )");

        if(!empty($searching))
        {
        ?>
        <div class="container">
        <table class="table table-dark table-hover table-responsive-sm table-responsive-md table-responsive-lg">
        <thead>
            <tr>
                <th>admin_name</th>
                <th>admin_email</th>
                <th>admin_address</th>
                <th>admin_number</th>
                <th>start_date</th>
                <th>operations</th>
                
            </tr>
        </thead>
        <?php
        
            foreach($searching as $user)
            {
                echo '
                    <tbody>
                    <td><div class="admin_info">'.$user["client_name"].'</div></td>
                    <td><div class="admin_info">'.$user["email"].'</div></td>
                    <td><div class="admin_info">'.$user["address"].'</div></td>
                    <td><div class="admin_info">'.$user["phone_number"].'</div></td>
                    <td><div class="admin_info">'.$user["start_date"].'</div></td>
                    <td>
                      <div class = "button_row">
                        <b>
                            <a href="clients.php?do=delete&client_id='.$user["client_id"].'" class="btn btn-secondary delete">Del <i class="fas fa-user-minus"></i>
                            </a>
                        </b>
                        <b>
                             <a href="clients.php?do=edit&client_id='.$user["client_id"].'" class="btn btn-primary">Edit <i class="fa fa-edit"></i>
                             </a>
                        </b>
                      </div>
                    </td>
                    
                    </tbody>
                ';
                
            }
        ?>
        </table>
        </div>
        <?php
        
        }
        else
        {
            echo '<div class = "alert text-center" style="color:red;font-weight:bold"> <i class="fas fa-exclamation-triangle"></i> EMPTY</div>';
        }
        
    }
    if($category =='finished_jobs')
    {
        $stmt = mysqli_query($con,"select distinct job_owner from finished_jobs where  job_id like '%$search%' or job_name like '%$search%' or job_link like '%$search%' or description like '%$search%'  or job_owner like '%$search%' or feedback like '%$search%' or owner_name like '%$search%' or owner_email like '%$search%'");
        $rows=$stmt->fetch_all(MYSQLI_NUM);

?>
            <div class="container">

<?php
      if(!empty($rows))
      {
        foreach($rows as $row)
        {
            $job_owner = $row["0"];
            $stmt1=mysqli_query($con,"select * from finished_jobs where job_owner='$job_owner' and (job_id like '%$search%' or job_name like '%$search%' or job_link like '%$search%' or description like '%$search%'  or job_owner like '%$search%' or feedback like '%$search%' or owner_name like '%$search%' or owner_email like '%$search%')");
            $rows1=$stmt1->fetch_all(MYSQLI_ASSOC);
            $stmt4=mysqli_query($con,"select client_name from clients where client_id='$job_owner'");
            $rows4=$stmt4->fetch_all(MYSQLI_ASSOC);
            ?>
            

                <div class="card">
                    <div class="card-header">
                        <?php echo '<span class="owner-name">job\'s owner</span>'.": <a href='clients.php?do=edit&client_id=".$job_owner."'>".$rows4[0]['client_name']."</a>";?>


                        <div class="jobs-details">

                        <b class="hide-data point">Hide</b> |
                        <b class="show-data select">Show</b>
                        Details
                        </div>                    

                    </div>
                    <div class="card-body">
                        <div>
                            <table class="table table-dark table-hover table-responsive-sm table-responsive-md table-responsive-lg">
                                <thead>
                                    <tr>
                                      <th scope="col">ID</th>
                                      <th scope="col">job_name</th>
                                      <th scope="col">owner_email</th>
                                      <th scope="col">Description</th>
                                      <th scope="col">Adding_date</th>
                                      <th scope="col">ending_date</th>
                                      <th scope="col">FeedBack</th>
                                      <th scope="col">operations </th>
                                      
                                      
                                    </tr>
                                </thead>
                        <?php
                         $id = isset($_GET['id'])&&is_numeric($_GET['id'])?intval($_GET['id']):0;

                            foreach($rows1 as $row1)
                            {
                                $job_id =$row1['job_id'];
                                $stmt2 = mysqli_query($con,"select jobs.*,clients.client_name,clients.client_id from jobs inner join clients on jobs.job_owner=clients.client_id where jobs.job_id=$job_id");
                                $rows2 = $stmt2->fetch_all(MYSQLI_ASSOC);
                                $client_id = $rows2[0]['client_id'];
                                echo '
                                        <tbody>
                                            <tr>
                                              <td scope="row">'.$job_id.'</td>
                                              <td scope="row">'.$row1['job_name'].'</td>
                                              <td scope="row">'.$row1['owner_email'].'</td>
                                              <td scope="row">'.$row1['description'].'</td>
                                              <td scope="row">'.$rows2[0]['adding_date'].'</td>
                                              <td scope="row">'.$row1['ending_date'].'</td>
                                              <td scope="row">'.$row1['feedback'].'</td>
                                              <td scope="row">
                                              <div class = "button_row">
                                                <b>
                                                  <a href="jobs.php?do=delete_finished_jobs&job_id='.$job_id.'" class="btn btn-danger confirm delete">Del <i class="fas fa-user-minus"></i>
                                                  </a>
                                                </b>
                                                 <b>
                                                   <a href="jobs.php?do=edit_finished_jobs&job_id='.$job_id.'&job_owner='.$client_id.'" class="btn btn-primary confirm">Edit <i class="fa fa-edit"></i>
                                                   </a>
                                                 </b>
                                            
                                                </div>
                                              </td>
                                              
                                            <tr>
                                        </tbody>';
                         
                            
                            }
                        ?>                                

                            </table>                                    
                        </div>
                    </div>
                </div>
                
            <?php  
        }
      }
      else
      {
       echo '<div class="alert text-center" style="color:red;font-weight:bold"> <i class="fas fa-exclamation-triangle"></i> there is no result </div>';
      }
            ?>
            </div>
            <?php
            
    }
    if($category =='jobs')
    {
        $stmt = mysqli_query($con,"select distinct job_owner from jobs where  finish = 0 and (job_id like '%$search%' or job_name like '%$search%' or adding_date like '%$search%' or job_description like '%$search%' or feedback like '%$search%' or budget like '%$search%' or owner_name like '%$search%' or owner_email like '%$search%')");
        $rows=$stmt->fetch_all(MYSQLI_NUM);

?>
            <div class="container">
<?php
      if(!empty($rows))
      {
        foreach($rows as $row)
        {
            $job_owner = $row["0"];
            $stmt1=mysqli_query($con,"select * from jobs where finish = 0 and job_owner ='$job_owner' and (job_id like '%$search%' or job_name like '%$search%' or owner_email like '%$search%' or adding_date like '%$search%' or job_description like '%$search%' or feedback like '%$search%' or budget like '%$search%' or owner_name like '%$search%')");
            $rows1=$stmt1->fetch_all(MYSQLI_ASSOC);
            $stmt4=mysqli_query($con,"select client_name from clients where client_id='$job_owner'");
            $rows4=$stmt4->fetch_all(MYSQLI_ASSOC);
            ?>
            

                <div class="card">
                    <div class="card-header">
                        <?php echo '<span class="owner-name">job\'s owner</span>'.": <a href='clients.php?do=edit&client_id=".$job_owner."'>".$rows4[0]['client_name']."</a>";?>


                        <div class="jobs-details">

                        <b class="hide-data point">Hide</b> |
                        <b class="show-data select">Show</b>
                        Details
                        </div>                    

                    </div>
                    <div class="card-body">
                        <div>
                            <table class="table table-dark table-hover table-responsive-sm table-responsive-md table-responsive-lg">
                                <thead>
                                    <tr>
                                      <th scope="col">ID</th>
                                      <th scope="col">job_name</th>
                                      <th scope="col">owner_email</th>
                                      <th scope="col">Description</th>
                                      <th scope="col">Adding_date</th>
                                      <th scope="col">FeedBack</th>
                                      <th scope="col">operations </th>
                                      
                                      
                                    </tr>
                                </thead>
                        <?php
                         $id = isset($_GET['id'])&&is_numeric($_GET['id'])?intval($_GET['id']):0;

                            foreach($rows1 as $row1)
                            {
                                $job_id =$row1['job_id'];
                                $stmt2 = mysqli_query($con,"select jobs.*,clients.client_name,clients.email,clients.client_id from jobs inner join clients on jobs.job_owner=clients.client_id where jobs.job_id=$job_id");
                                $rows2 = $stmt2->fetch_all(MYSQLI_ASSOC);
                                $client_id = $rows2[0]['client_id'];
                                $client_email= $rows2[0]['email'];
                                echo '
                                        <tbody>
                                            <tr>
                                              <td scope="row">'.$job_id.'</td>
                                              <td scope="row">'.$client_email.'</td>
                                              <td scope="row">'.$row1['job_name'].'</td>
                                              <td scope="row">'.$row1['job_description'].'</td>
                                              <td scope="row">'.$rows2[0]['adding_date'].'</td>
                                              <td scope="row">'.$row1['feedback'].'</td>
                                              <td scope="row">
                                              <div class = "button_row">
                                                <b>
                                                  <a href="jobs.php?do=delete&job_id='.$job_id.'" class="btn btn-danger confirm delete">Del <i class="fas fa-user-minus"></i>
                                                  </a>
                                                </b>
                                                <b>
                                                  <a href="jobs.php?do=edit&job_id='.$job_id.'&job_owner='.$client_id.'" class="btn btn-primary confirm">Edit <i class="fa fa-edit"></i>
                                                  </a>
                                                </b>
                                            
                                                </div>
                                              </td>
                                              
                                            <tr>
                                        </tbody>';
                         
                            
                            }
                        ?>                                

                            </table>                                    
                        </div>
                    </div>
                </div>
                
            <?php           
        }
      }
      else
      {
       echo '<div class="alert text-center" style="color:red;font-weight:bold"> <i class="fas fa-exclamation-triangle"></i> there is no result </div>';
      }
            ?>
            </div>
            <?php
            
    }
    if($category == 'comments')
    {
?>
    <h1 class="text-center">comments</h1>
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
                    where comments.comment like '%$search%' or comments.adding_date like '%$search%' or comments.comment_owner like '%$search%' or comments.comment_job like '%$search%' or finished_jobs.job_name like '%$search%' or clients.client_name like '%$search%'  or clients.email like '%$search%' 
                      ");
            $rows = $stmt->fetch_all(MYSQLI_ASSOC);
        if(empty($rows))
        {
          echo '<div class="alert container text-center"  style="color:red;font-weight:bold">no result </div>';
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
                                    <a href="comments.php?do=delete&comment_id='.$row['comment_id'].'" class="btn btn-danger delete">Del <i class="fas fa-user-minus"></i></a>
                                </b>
                                <b>
                                    <a href="comments.php?do=edit&comment_id='.$row['comment_id'].'&comment_owner='.$row['comment_owner'].'" class="btn btn-primary">Edit <i class="fa fa-edit"></i></a>
                                </b>
                              </div>
                             </td>
                        </tr>' ;                       
                   
                }
                echo '</table>';
          }     
    }
    if($category == 'contacts')
    {
  $stmt = mysqli_query($con,"select distinct email from contacting where sms like '%$search%' or adding_date like '%$search%' or name like '%$search%' or email like '%$search%' ");
        $rows=$stmt->fetch_all(MYSQLI_ASSOC);
        if(empty($rows))
        {
            echo '<div class="alert container text-center"  style="color:red;font-weight:bold">no contacts  </div>';
         
        }
         
?>
            <div class="container">

<?php
        foreach($rows as $row)
        {
            $email = $row['email'];
            $messages=getTable("*","contacting","where email = '$email' and (sms like '%$search%' or adding_date like '%$search%' or name like '%$search%' or email like '%$search%')")
            ?>
            

                <div class="card">
                    <div class="card-header">
                        <?php echo '<span class="owner-name">email : '.$email.'</span>'?>
                        
                        <a href="contacts?do=delete&email=<?php echo $email;?>" class="delete btn deletcontact confirm"> delete</a>                        
                        <div class="jobs-details">
                        <b class="hide-data point">Hide</b> |
                        <b class="show-data select">Show</b>
                        Details
                        </div>                    

                    </div>
                    <div class="card-body">
                        <div>
                            <table class="table table-dark table-hover table-responsive-sm table-responsive-md table-responsive-lg">
                                <thead>
                                    <tr>
                                      <th scope="col">Contact_ID</th>
                                      <th scope="col">client_name</th>
                                      <th scope="col">client_email</th>
                                      <th scope="col">message</th>
                                      <th scope="col">Adding_date</th>                                      
                                    </tr>
                                </thead>
                        <?php
                            $contact_id = isset($_GET['contact_id'])?intval($_GET['contact_id']):'0';
                            foreach($messages as $sms)
                            {
                                     echo '
                                     
                                        <tbody>
                                            <tr>
                                              <td scope="row">'.$sms['contact_id'].'</td>
                                              <td scope="row">'.$sms['name'].'</td>
                                              <td scope="row">'.$sms['email'].'</td>
                                              <td scope="row">'.$sms['sms'].'</td>
                                              <td scope="row">'.$sms['adding_date'].'</td>                                             
                                            <tr>
                                        </tbody>';
                            }
                        ?>                                

                            </table>                                    
                        </div>
                    </div>
                </div>
                
            <?php  
        }
            
            ?>
            </div>
            <?php     
    }
    if($category=='feedbacks')
    {
       $stmt = mysqli_query($con,"select distinct job_owner from jobs where  finish = 0 and feedback like '%$search%'");
        $rows=$stmt->fetch_all(MYSQLI_NUM);
       $stmtplus = mysqli_query($con,"select distinct job_owner from finished_jobs where feedback like '%$search%'");
        $rowsplus=$stmtplus->fetch_all(MYSQLI_NUM);        
        $array=array();
        foreach($rows as $row)
        {
         if(!in_array($row['0'],$array))
         {
          $array[]=$row['0'];
         }
         
        }
        foreach($rowsplus as $rowplus)
        {
         if(!in_array($rowplus['0'],$array))
         {
          $array[]=$rowplus['0'];
         }
         
        }
?>
            <div class="container">
<?php
      if(!empty($array))
      {
        foreach($array as $row)
        {
            $job_owner = $row["0"];
            $stmt1=mysqli_query($con,"select * from jobs where finish = 0 and job_owner ='$job_owner' and feedback like '%$search%'");
            $rows1=$stmt1->fetch_all(MYSQLI_ASSOC);
            $stmt1plus=mysqli_query($con,"select * from finished_jobs where job_owner ='$job_owner' and feedback like '%$search%'");
            $rows1plus=$stmt1plus->fetch_all(MYSQLI_ASSOC);            
            $stmt4=mysqli_query($con,"select client_name from clients where client_id='$job_owner'");
            $rows4=$stmt4->fetch_all(MYSQLI_ASSOC);
            ?>
            

                <div class="card">
                    <div class="card-header">
                        <?php echo '<span class="owner-name">job\'s owner</span>'.": <a href='clients.php?do=edit&client_id=".$job_owner."'>".$rows4[0]['client_name']."</a>";?>


                        <div class="jobs-details">

                        <b class="hide-data point">Hide</b> |
                        <b class="show-data select">Show</b>
                        Details
                        </div>                    

                    </div>
                    <div class="card-body">
                        <div>
                            <table class="table table-dark table-hover table-responsive-sm table-responsive-md table-responsive-lg">
                                <thead>
                                    <tr>
                                      <th scope="col">ID</th>
                                      <th scope="col">job_name</th>
                                      <th scope="col">owner_email</th>
                                      <th scope="col">Description</th>
                                      <th scope="col">Adding_date</th>
                                      <th scope="col">Ending_date</th>
                                      <th scope="col">FeedBack</th>
                                      <th scope="col">operations </th>
                                      
                                      
                                    </tr>
                                </thead>
                        <?php
                         $id = isset($_GET['id'])&&is_numeric($_GET['id'])?intval($_GET['id']):0;

                            foreach($rows1 as $row1)
                            {
                                $job_id =$row1['job_id'];
                                $stmt2 = mysqli_query($con,"select jobs.*,clients.client_name,clients.email,clients.client_id from jobs inner join clients on jobs.job_owner=clients.client_id where jobs.job_id=$job_id");
                                $rows2 = $stmt2->fetch_all(MYSQLI_ASSOC);
                                $client_id = $rows2[0]['client_id'];
                                $client_email= $rows2[0]['email'];
                                echo '
                                        <tbody>
                                            <tr>
                                              <td scope="row">'.$job_id.'</td>
                                              <td scope="row">'.$client_email.'</td>
                                              <td scope="row">'.$row1['job_name'].'</td>
                                              <td scope="row">'.$row1['job_description'].'</td>
                                              <td scope="row">'.$rows2[0]['adding_date'].'</td>
                                              <td scope="row"> still under working </td>
                                              <td scope="row">'.$row1['feedback'].'</td>
                                              <td scope="row">
                                              <div class = "button_row">
                                                <b>
                                                  <a href="jobs.php?do=delete&job_id='.$job_id.'" class="btn btn-danger confirm delete">Del <i class="fas fa-user-minus"></i>
                                                  </a>
                                                </b>
                                                <b>
                                                  <a href="jobs.php?do=edit&job_id='.$job_id.'&job_owner='.$client_id.'" class="btn btn-primary confirm">Edit <i class="fa fa-edit"></i>
                                                  </a>
                                                </b>
                                            
                                                </div>
                                              </td>
                                              
                                            <tr>
                                        </tbody>';
                         
                            
                            }
                            foreach($rows1plus as $row1plus)
                            {
                                $job_id =$row1plus['job_id'];
                                $stmt2 = mysqli_query($con,"select jobs.*,clients.client_name,clients.email,clients.client_id,finished_jobs.ending_date from jobs inner join clients on jobs.job_owner=clients.client_id inner join finished_jobs on jobs.job_id=finished_jobs.job_id where jobs.job_id=$job_id");
                                $rows2 = $stmt2->fetch_all(MYSQLI_ASSOC);
                                $client_id = $rows2[0]['client_id'];
                                $client_email= $rows2[0]['email'];
                                echo '
                                        <tbody>
                                            <tr>
                                              <td scope="row">'.$job_id.'</td>
                                              <td scope="row">'.$client_email.'</td>
                                              <td scope="row">'.$row1plus['job_name'].'</td>
                                              <td scope="row">'.$row1plus['description'].'</td>
                                              <td scope="row">'.$rows2[0]['adding_date'].'</td>
                                              <td scope="row">'.$rows2[0]['ending_date'].'</td>
                                              <td scope="row">'.$row1plus['feedback'].'</td>
                                              <td scope="row">
                                              <div class = "button_row">
                                                <b>
                                                  <a href="jobs.php?do=delete&job_id='.$job_id.'" class="btn btn-danger confirm delete">Del <i class="fas fa-user-minus"></i>
                                                  </a>
                                                </b>
                                                <b>
                                                  <a href="jobs.php?do=edit&job_id='.$job_id.'&job_owner='.$client_id.'" class="btn btn-primary confirm">Edit <i class="fa fa-edit"></i>
                                                  </a>
                                                </b>
                                            
                                                </div>
                                              </td>
                                              
                                            <tr>
                                        </tbody>';
                         
                            
                            }                            
                        ?>                                

                            </table>                                    
                        </div>
                    </div>
                </div>
                
            <?php           
        }
      }
      else
      {
       echo '<div class="alert text-center" style="color:red;font-weight:bold"> <i class="fas fa-exclamation-triangle"></i> there is no result </div>';
      }
            ?>
            </div>
            <?php     
    }
 }
 else
 {
    echo '<div class = "alert text-center" style="color:red;font-weight:bold"> <i class="fas fa-exclamation-triangle"></i> no result</div>';
 }
}
else
{
    echo '<div class = "alert text-center" style="color:red;font-weight:bold"> <i class="fas fa-exclamation-triangle"></i> type what you want to search</div>';

}
include $tpl."footer.php";
?>