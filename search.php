<?php
ob_start();
session_start();
include "init.php";

if(isset($_SESSION['user'])||isset($_SESSION['client']))
{
    include "messages.php";
}
            if(isset($_SESSION['client']))
            {
               $email=$_SESSION['client'];
            }
            if(isset($_SESSION['user']))

            {
               $email=$_SESSION['user'];
               
            }
           $client_id_for_session= getTable('client_id',"clients","where email='$email'");
           $client_ids=$client_id_for_session[0]['client_id'];   
if(isset($_POST['submit_search']))
{
 $category =isset($_POST['category'])?mysqli_real_escape_string($con,$_POST['category']):null;
 $search =isset($_POST['search'])?mysqli_real_escape_string($con,$_POST['search']):null;
 if(!empty($category)&&!empty($search))
 {
    if($category =='admins')
    {
        $searching = getTable("*","clients","where reg_status = 1 and(client_name like '%$search%' or email like '%$search%' or address like '%$search%' or phone_number like '%$search%' )and client_id != $client_ids");

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
                <th>talk_to_him</th>
            </tr>
        </thead>
        <?php
        
            foreach($searching as $admin)
            {
                echo '
                    <tbody>
                    <td><div class="admin_info">'.$admin["client_name"].'</div></td>
                    <td><div class="admin_info">'.$admin["email"].'</div></td>
                    <td><div class="admin_info">'.$admin["address"].'</div></td>
                    <td><div class="admin_info">'.$admin["phone_number"].'</div></td>
                    <td><div class="admin '.$admin['client_id'].'" data-reciever="'.$admin['client_id'].'" data-sender="'.$client_id.'" data-reciever_name="'.$admin['client_name'].'">start chat</div></td>
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
            echo '<div class = "alert text-center" style="color:red;font-weight:bold"> <i class="fas fa-exclamation-triangle"></i> no result</div>';
        }
        
    }
    if($category =='users_s')
    {
        $searching = getTable("*","clients","where reg_status = 0 and(client_name like '%$search%' or email like '%$search%' or address like '%$search%' or phone_number like '%$search%' )");

        if(!empty($searching))
        {
        ?>
        <div class="container">
        <table class="table table-dark table-hover table-responsive-sm table-responsive-md table-responsive-lg">
        <thead>
            <tr>
                <th>client_name</th>
                <th>client_email</th>
                <th>client_address</th>
                <th>client_number</th>
                <th>talk_to_him</th>
            </tr>
        </thead>
        <?php
        
            foreach($searching as $client)
            {
                echo '
                    <tbody>
                    <td><div class="admin_info">'.$client["client_name"].'</div></td>
                    <td><div class="admin_info">'.$client["email"].'</div></td>
                    <td><div class="admin_info">'.$client["address"].'</div></td>
                    <td><div class="admin_info">'.$client["phone_number"].'</div></td>
                    <td><div class="admin '.$client['client_id'].'" data-reciever="'.$client['client_id'].'" data-sender="'.$client_id.'" data-reciever_name="'.$client['client_name'].'">start chat</div></td>
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
            echo '<div class = "alert text-center" style="color:red;font-weight:bold"> <i class="fas fa-exclamation-triangle"></i> no result</div>';
        }
        
    }    
    if($category =='websites')
    {
        $searching = getTable("*","finished_jobs","where job_name like '%$search%' or job_link like '%$search%' or description like '%$search%'");

        if(!empty($searching))
        {
?>
    <div class="container">            
  <?php
            foreach($searching as $job)
            {
                echo'
                    <a href="https://'.$job['job_link'].'" class="visit_link">'.$job['job_link'].'</a><span class="visiting_links"> visit this website</span>
                    <div class="job_in_search">
                        <a href="jobs.php?job_id='.$job['job_id'].'#job'.$job['job_id'].'" class="EHF_link">'.$job["job_name"].'</a><span class="links_EHF"> website show in EHF</span>
                        <div class="search_description">'.$job["description"].'</div>
                    </div>
                ';
            }
            ?>
                </div>
                <?php
        }
       else
        {
            echo '<div class = "alert text-center" style="color:red;font-weight:bold"> <i class="fas fa-exclamation-triangle"></i> no result</div>';
        }
        
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
include "contact_us.php";
include $tpl."footer.php";
?>