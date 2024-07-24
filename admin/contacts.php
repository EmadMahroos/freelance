<?php
ob_start();
session_start();

if(isset($_SESSION['user']))
{

    include"init.php";
        
        $stmt = mysqli_query($con,"select distinct email from contacting");
        $rows=$stmt->fetch_all(MYSQLI_ASSOC);
        if(empty($rows))
        {
            echo '<div class="alert container text-center"  style="color:red;font-weight:bold">no contacts  </div>';
         
        }
         
?>
            <div class="container">

<?php
$do = isset($_GET['do'])?$_GET['do']:null;
if($do=='delete')
{
        ?>
        <div class="container">
            <h1 class="text-center">delete a contact </h1>
            <?php
           $contact =isset($_GET['email'])?$_GET['email']:null;
            $stmt = mysqli_query($con,"delete from contacting where email='$contact'");
            $count = mysqli_affected_rows($con);
            if($count>0)
            {
                echo '<div class="alert text-center" style="color:#28a745;font-weight:bold;"><i class="fas fa-check"></i> one contact deleted</div>';
                redirect("",3,"contacts.php");
            }
            else
            {
                echo '<div class="alert text-center" style="color:red;font-weight:bold"> <i class="fas fa-exclamation-triangle"></i> no contact deleted</div>';
                redirect();

            }
            ?>
        </div>
        <?php    
}
        foreach($rows as $row)
        {
            $email = $row['email'];
            $messages=getTable("*","contacting","where email='$email'")
            ?>
            

                <div class="card">
                    <div class="card-header">
                        <?php echo '<span class="owner-name">email : '.$email.'</span>'?>
                        
                        <a href="?do=delete&email=<?php echo $email;?>" class="delete btn deletcontact confirm"> delete</a>                        
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
                                $id =$sms['contact_id'];
                                if($contact_id==$id)
                                {                                
                                        echo '
                                    
                                        <tbody>
                                            <tr id="'.$id.'" style="background:#476838">
                                              <td scope="row">'.$sms['contact_id'].'</td>
                                              <td scope="row">'.$sms['name'].'</td>
                                              <td scope="row">'.$sms['email'].'</td>
                                              <td scope="row">'.$sms['sms'].'</td>
                                              <td scope="row">'.$sms['adding_date'].'</td>                                             
                                            <tr>
                                        </tbody>';
                                }
                                else
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
        
    include $tpl ."footer.php";
}
else
{
     header("location: login.php");
    exit();  
}
ob_end_flush();
?>