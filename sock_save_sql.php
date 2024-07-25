<?php 
class usersData {
    public $dbcon;
   public function __construct(){
        include "connect.php";
        $this->dbcon = $con;
    }
    public function changeOnlineStatus($userid,$val){
         $stmt = mysqli_query($this->dbcon,"update clients set online_status=$val where client_id ='$userid'");
    }
    public function saveMsgs($msg,$sender,$reciever){
         $stmt = mysqli_query($this->dbcon,"insert into messages(msg,sender,reciever)values('$msg',$sender,$reciever)");
         $st_rec=mysqli_query($this->dbcon,"select email,client_name from clients where client_id='$reciever'");
         $recieveremail = $st_rec->fetch_all(MYSQLI_ASSOC);
         $st_sen=mysqli_query($this->dbcon,"select client_name from clients where client_id='$sender'");
         $sendername = $st_sen->fetch_all(MYSQLI_ASSOC);
         $sender_name=$sendername[0]['client_name'];
         $st_time=mysqli_query($this->dbcon,"select time from messages where sender='$sender' and reciever = '$reciever' and msg='$msg' order by msg_id desc");
         $time= $st_time->fetch_all(MYSQLI_ASSOC);
         $msg_time=$time[0]['time'];         
         $reciever_email=$recieveremail[0]["email"];
         $description="<div class=\'name\'>".$sender_name .":</div>".$msg;
         $reciever_name=$recieveremail[0]["client_name"];
         
         $stmt = mysqli_query($this->dbcon,"insert into sms_notifications(notification_description,sender,reciever,sender_name,reciever_email,time)values('$description',$sender,$reciever,'$sender_name','$reciever_email','$msg_time')");           
      $arr = array();
    $arr['msg_time']=$msg_time;
      return $arr;
    }
    public function updateNotificationSeen($userid,$table){
      $stmt=mysqli_query($this->dbcon,"update $table set seen ='1' where reciever= '$userid'");
    }
    public function addComment($comment_owner,$job_id,$comment){
        $comment=filter_var($comment,FILTER_SANITIZE_STRING);
        $job_id=filter_var($job_id,FILTER_SANITIZE_NUMBER_INT);
        $comment_owner=filter_var($comment_owner,FILTER_SANITIZE_NUMBER_INT);
        if(!empty($comment))
        {
            $stmtinsert =
            mysqli_query($this->dbcon,
                         "insert into comments(comment,adding_date,comment_owner,comment_job)
                                        values('$comment',now(),'$comment_owner','$job_id')");

            $jobowner_st = mysqli_query($this->dbcon,"select job_owner from jobs where job_id='$job_id'");
            $jobowner = $jobowner_st->fetch_all(MYSQLI_ASSOC);
            $job_owner = $jobowner[0]['job_owner'];
            $jobowneremail_st = mysqli_query($this->dbcon,"select email from clients where client_id='$job_owner'");
            $jobowneremail = $jobowneremail_st->fetch_all(MYSQLI_ASSOC);
            $job_owner_email=$jobowneremail[0]['email'];
            $comments_on_this_job_st=mysqli_query($this->dbcon,"select distinct comment_owner from comments where (comment_job ='$job_id' and comment_owner !='$comment_owner' and comment_owner != $job_owner)");
            $comments_on_this_job = $comments_on_this_job_st->fetch_all(MYSQLI_ASSOC);
            $commentid_st = mysqli_query($this->dbcon,"select comment_id,adding_date from comments where comment_owner = '$comment_owner' and comment = '$comment' order by comment_id desc");
            $commentid = $commentid_st->fetch_all(MYSQLI_ASSOC);
            $comment_id = $commentid[0]['comment_id'];
            $comment_time = $commentid[0]['adding_date'];
            $sendername_st = mysqli_query($this->dbcon,"select client_name from clients where client_id = '$comment_owner'");
            $sendername=$sendername_st->fetch_all(MYSQLI_ASSOC);
            $jobname_st = mysqli_query($this->dbcon,"select job_name from jobs where job_id = '$job_id'");
            $jobname = $jobname_st->fetch_all(MYSQLI_ASSOC);
            $job_name = $jobname[0]['job_name'];
            
            $sender_name=$sendername[0]['client_name'];                
               $arr=array();
            foreach($comments_on_this_job as $commenter)
            {
               $arr['c_owner'][]=$commenter['comment_owner'];
               $reciever=$commenter['comment_owner'];
               $email_st = mysqli_query($this->dbcon,"select email from clients where client_id = '$reciever'");
               $email = $email_st->fetch_all(MYSQLI_ASSOC);
               $reciever_email = $email[0]['email'];
               mysqli_query($this->dbcon,"insert into notificationss(comment_id,notification_description,sender,sender_name,reciever,reciever_email,job_id,time)
                                           values('$comment_id','<div class=\'name\'>$sender_name: </div> $comment  <div class=\'job_name\'>on $job_name</div> ','$comment_owner','$sender_name','$reciever','$reciever_email','$job_id','$comment_time')");

            }
            
            if($comment_owner != $job_owner )
            {
               mysqli_query($this->dbcon,"insert into notificationss(comment_id,notification_description,sender,sender_name,reciever,reciever_email,job_id,time)
                                        values('$comment_id','<div class=\'name\'>$sender_name: </div> $comment  <div class=\'job_name\'>on $job_name</div> ','$comment_owner','$sender_name','$job_owner','$job_owner_email','$job_id','$comment_time')");
               if(mysqli_affected_rows($this->dbcon) > 0)
               {
                 echo "o is done";
               }
              else
               {
                 echo "o is none";
               }
               $arr["c_owner"][]=$job_owner;
            }
            $arr["noti_info"]=array("job_name"=>$job_name,"sender_name"=>$sender_name,"comment"=>$comment,"comment_id"=>$comment_id,"comment_time"=>date("Y:m:d H:i A",strtotime($comment_time)));
          return $arr;
        }        
      
    }    
}
