

let x = document.querySelector(".profile-logo > li");
let y =document.querySelector(".profile-logo-options");

// document.onmouseup  = ()=>{
//    if(y.style.display=="block")
//        y.style.display="none";
// };
(function(){
   if(x)
      {
         x.addEventListener("click",() =>{


            if(y.style.display!="block")
               y.style.display="block";
            else
               y.style.display="none";
         
         });

      }
})();


  $(document).ready(function(){
   "use strict";
     
      
   $(function(){
      if($('#job_name').val())
         {
            if(($('#job_name').val().length)>10)
               {
                  $('#job_name').parent().parent().next('.step-submit').find('#suc').addClass('confirm');
                  $('#job_name').parent().parent().next('.step-submit').find('#suc').val('next');
         
               }
               else
               {
                  $('#job_name').parent().parent().next('.step-submit').find('#suc').removeClass('confirm');
                  $('#job_name').parent().parent().next('.step-submit').find('#suc').val('unavailable');
         
            
               }
         }

      
   });
$(function(){
   if($('#job_description').val())
      {
         if(($('#job_description').val().length)>10)
            {
               $('#job_description').parent().parent().next('.step-submit').find('#suc').addClass('confirm');
               $('#job_description').parent().parent().next('.step-submit').find('#suc').val('next');
         
            }
            else
            {
               $('#job_description').parent().parent().next('.step-submit').find('#suc').removeClass('confirm');
               $('#job_description').parent().parent().next('.step-submit').find('#suc').val('unavailable');
         
         
            }       
      }
      

});

   $('#job_name').keyup(function(){
      if($(this).val().length>10)
      {
         $(this).parent().parent().next('.step-submit').find('#suc').addClass('confirm');
         $(this).parent().parent().next('.step-submit').find('#suc').val('next');
         
      }
      else{
               $(this).parent().parent().next('.step-submit').find('#suc').removeClass('confirm');
               $(this).parent().parent().next('.step-submit').find('#suc').val('unavailable');

   
      }

});

$('#job_description').keyup(function(){
   if($(this).val().length>100)
   {
      $(this).parent().parent().next('.step-submit').find('#suc').addClass('confirm');
      $(this).parent().parent().next('.step-submit').find('#suc').val('next');
      
   }
   else{
            $(this).parent().parent().next('.step-submit').find('#suc').removeClass('confirm');
            $(this).parent().parent().next('.step-submit').find('#suc').val('unavailable');


   }

});  

   $('.login-box h1 span').click(function(){
         $(this).addClass('selected').siblings('span').removeClass('selected');
         $('.login-box form').hide();
         $('.'+$(this).data('class')).fadeIn();
      });

   $(".admins-online").click(function(){
                                        $('.admins').slideToggle();
                                        
                                        });
   $(".some-activities .add_comment").click(function(){
                                        $(this).parent().find('.hiddentextarea').fadeToggle();
                                       $(this).parent().find('.comm_btn').fadeToggle();
                                        });
      $(".some-activities .show-comments").click(function(){
                                        $(this).parent().find('.comments').fadeToggle();
                                        });

   $(".some-activities .profile-logo > li").click(function(){
                                        $('.some-activities .profile-logo li ul').slideToggle();
                                        
                                        });
    $('.required').each(function(){
                                       $('.show-password').hover(
                                                                 function(){$(this).next('input').attr('type','');
                                                                 },function(){$(this).next('input').attr('type','password');}
                                                                 );
                                   });
   $('.delete').click(function(){
   
               return confirm('are you sure ? you wanna delete that client');
         });
   $('.activate').click(function(){

            	return confirm('Are you wanna change the activation mark');
         });
   $(".hide-data").click(function()
            {
               $(this).parent().parent().parent().find('.card-body').slideUp();
               $(this).addClass("select").siblings(".show-data").removeClass('select');
            });
   $(".show-data").click(function()
            {
               $(this).parent().parent().parent().find('.card-body').slideDown();
               $(this).addClass("select").siblings(".hide-data").removeClass('select');
               
               

            });
		$('.togglespan').click(function(){
				$(this).toggleClass('selected').parent().next('.card-body').slideToggle(500);
				if($(this).hasClass('selected')){
					$(this).html('<i class="fas fa-arrow-down"></i>');
				}else{
					$(this).html('<i class="fas fa-arrow-up"></i>');

				}
		});
   

   $('.radio-div').click(function(){
      $(this).parent().find('input').removeAttr('checked');
      $(this).find('input').attr('checked','checked');
      $('.radio-div input').parent().parent().parent().next('.step-submit').find('#suc').addClass('confirm');
      $('.radio-div input').parent().parent().parent().next('.step-submit').find('#suc').val('next');
   });
   
   $(".file-close").click(function(){
      
      $(this).parent().remove();
      
        
      });
   $(".file").hover(function(){
      
      $(this).find(".file-close").css({"display":"block","cursor":"pointer"});
      
      
      },function(){
      $(".file-close").css("display","none");
         
      }
      );
   
});

$(function(){
      /*---------------------------------------------- start connection sockets -----------------------------------------------------------*/
   var conn = new WebSocket('ws://localhost:8080');
   /*-------------------------------- end connection sockets------------------------------------------*/
   var today = new Date();
   
   var date = today.getFullYear()+'-'+(today.getMonth()+1)+'-'+today.getDate();
   var time=  today.toLocaleString('en-US', { hour: 'numeric',minute:'numeric', hour12: false });
   var ampm = today.getHours()>=12?'PM':'AM';
   var dateTime = date+' '+time + ' '+ampm;
   
   $(".file-close").on("click",function(){
      var item = $(this).parent().data("class");
      $.post("job_details.php",{name:item});
      
      
      });

   var distance=0;
   //var width = $(window).width();
   var media =matchMedia("(max-width:750px)");
   function init(){

         distance=0;
$(".all-photos").each(function(){
   $(this).css("transform" ,"translateX("+distance+"px)");
   
   });         
   }
   media.addEventListener("change",e=>init());
   $(".prev").click(function(){
   var imgwidth=$(".photo").width();
   var photonum =$(this).parent().next('.info').data("class");
      if(distance != 0)
      {
      distance+=imgwidth;
   
      $(this).parent().find(".all-photos").css("transform" ,"translateX("+distance+"px)");
      }
      else
      {
         distance=-(photonum*imgwidth-imgwidth);
      $(this).parent().find(".all-photos").css("transform" ,"translateX("+distance+"px)");
         
      }
      });
   $(".next").click(function(){
   var imgwidth=$(".photo").width();
      
   var photonum =$(this).parent().next('.info').data("class");
      if(distance>-(photonum*imgwidth-imgwidth))
      {
      distance-=imgwidth;
   
      $(this).parent().find(".all-photos").css("transform" ,"translateX("+distance+"px)");
      }
      else
      {
         distance=0;
      $(this).parent().find(".all-photos").css("transform" ,"translateX("+distance+"px)");
         
      }
      });
   var info="";
   var col ="";
   var id ="";

   $(".data").blur(function(){
      info=this.innerText;
      col = $(this).data("class");
      id=$(".id").data("class");
      $.get("profiles.php?information="+info+"&column="+col+"&id="+id,function(a){
         $(".show").html(a);
         });
      });



   $(".finished_jobs").click(function(){
      $(".finished_job1 , .finished_job2").css("display","none");
      $(".i, .v").css("display","none");
      $(".c").css("display","block");
      $(".finished_job3").css("display","-webkit-box");
      
      });
   $(".under_working_jobs").click(function(){
      $(".finished_job3 , .finished_job2").css("display","none");
      $(".finished_job1").css("display","-webkit-box");
      $(".v, .c").css("display","none");
      $(".i").css("display","block");
      });
   $(".waiting_jobs").click(function(){
      $(".finished_job3 , .finished_job1").css("display","none");
      $(".finished_job2").css("display","-webkit-box");
      $(".c, .i").css("display","none");
      $(".v").css("display","block");
      });
      $(".file-close").on("click",function(){
      var item = $(this).parent().data("class");
      $.post("feedback.php",{name:item});
      
      
      });
                /* ---------------------- comments real time----------------------------------------*/
                                                
      $(".comm_btn").on("click",function(){
    
         var comment_parent=$(this).parent();
      var comment = comment_parent.find('.hiddentextarea').val();
      var comment_owner= comment_parent.find('.show-comments').data("class");
      var job_id= comment_parent.find(".hiddentextarea").data("class");
      if(comment.trim().length>0)
      {
       comment_parent.find('.comments').fadeIn();
       var data = {
         dateTime:dateTime,
         comment:comment,
         comment_owner:comment_owner,
         job_id:job_id
         };
         conn.send(JSON.stringify(data));
         comment_form = "<div class='comment' style='background:#94d478'>"+comment+"<div style='font-size:12px;text-align:center'>"+dateTime+"</div></div>";
         comment_parent.find(".comments").prepend(comment_form);
         $('.hiddentextarea').val("");
      }
      });
            /* ---------------------- comments real time----------------------------------------*/
   $(function(){
      
      var i = $('.i').data('class');
      var v = $('.v').data('class');
      var c = $('.c').data('class');
      if(i==0)
      {
         $('.i').html('you have no jobs under working');
         
      }
      if(v==0)
      {
         $('.v').html(' you have no waiting jobs');
      }
      if( c==0)
      {
         $('.c').html('you have no finished jobs');         
         
      }      
      
      });
      /*------------------------------------------------------------------------------------------------------------------------- */


              var c ,g;
      fetch_users();
      function fetch_users()
      {

         /*--------------------------------- start fetch users ajax ----------------------------- */               
         $.ajax({
            url:"fetch_users.php",
            method:"POST",
            async:false,
            cache:false,
            success:function(data)
            {


                  /*---------------------------------------------- start fetch all users -----------------------------------------------------------*/

                  if(data.users&&data.sender)
                  {
                     sender=data.sender[0].client_id;
                     data.users.forEach(admin=>
                        {
                           reciever = admin.client_id;
                           reciever_name = admin.client_name;
                           var sign = "<div class='online-sign'></div>";
                           var admin_div ="<div class='admin' id = '"+admin.client_id+"' data-reciever='"+reciever+"' data-sender='"+sender+"' data-reciever_name='"+reciever_name+"'><img src='admin/uploads/imgs/"+admin.logo+"'/>"+admin.client_name;
                           if(admin.online_status ==1)
                           {
                              admin_div+=sign+"</div>";
                              $(".admins").append(admin_div);
                           } 
                        });
                        data.users.forEach(admin=>
                           {
                              reciever = admin.client_id;
                              reciever_name = admin.client_name;
                              var admin_div ="<div class='admin' id = '"+admin.client_id+"' data-reciever='"+reciever+"' data-sender='"+sender+"' data-reciever_name='"+reciever_name+"'><img src='admin/uploads/imgs/"+admin.logo+"'/>"+admin.client_name;
                              if(admin.online_status ==0)
                              {
                                 admin_div+="</div>";
                                 $(".admins").append(admin_div);
                              } 
                           });                     
                  }
                  
/*---------------------------------------------- end fetch all users --------------------------------------*/
                  /*---------------------------------------------- start fetch all notifications ------------------------------------------------*/
                     if(data.notifications_unread.length>0)
                     {
                        $(".notifications_num").html(data.notifications_unread.length);
                        data.notifications_unread.forEach(notification=>{
                             var t = new Date(notification.time);
                              var newtime = t.getFullYear()+'-'+(t.getMonth()+1)+'-'+t.getDate();
                              var newhours = t.toLocaleString('en-US', { hour: 'numeric',minute:'numeric', hour12: false });
                                 var pmam = t.getHours()>=12?'PM':'AM';

                           if(($(".notifications_shower").find("."+notification.notification_id)).length==0)
                           {
                           $(".notifications_shower").prepend('<a href="jobs.php?do=manage&comment_id='+notification.comment_id+'#'+notification.comment_id+'" class=" unread '+notification.notification_id+' confirm notification">'+notification.notification_description+'<span class="timer">'+newtime +' '+newhours+ ' '+pmam +'</span></a>');
                           }
                           });
                     }
                     else
                     {
                        if(data.notifications_read.length>0 || data.notifications_unread.length>0)
                        {
                           $(".no_n").remove();
                        }
                        else
                        {
                           $(".notifications_shower").html("<div class='notification confirm no_n' >no notifications</div>");
                        }
                     
                        $(".notifications_num").html('');
                     }
                     if(data.notifications_read.length>0)
                        {
                           
                           data.notifications_read.forEach(notification=>{
                             var t = new Date(notification.time);
                              var newtime = t.getFullYear()+'-'+(t.getMonth()+1)+'-'+t.getDate();
                              var newhours = t.toLocaleString('en-US', { hour: 'numeric',minute:'numeric', hour12: false });
                              var pmam = t.getHours()>=12?'PM':'AM';
                           if(($(".notifications_shower").find("."+notification.notification_id)).length==0)
                           {
                           $(".notifications_shower").append('<a href="jobs.php?do=manage&comment_id='+notification.comment_id+'#'+notification.comment_id+'" class=" read '+notification.notification_id+' confirm notification">'+notification.notification_description+'<span class="timer">'+newtime +' '+newhours+ ' '+pmam +'</span></a>');
                           }
                           });                   
                        }               
                     
                     if(data.smss_unread.length>0)
                     {
                        
                        $(".sms_num").html(data.smss_unread.length);
                           //$(".sms_shower").html('');
                        data.smss_unread.forEach(sms=>{
                             var t = new Date(sms.time);
                              var newtime = t.getFullYear()+'-'+(t.getMonth()+1)+'-'+t.getDate();
                              var newhours = t.toLocaleString('en-US', { hour: 'numeric',minute:'numeric', hour12: false });
                               var pmam = t.getHours()>=12?'PM':'AM';
                           if(($(".sms_shower").find("."+sms.sms_id)).length==0)
                           {
                           $(".sms_shower").prepend('<div class="admin '+sms.notification_id+' confirm notification  unread" data-reciever="'+sms.sender+'" data-sender="'+sms.reciever+'" data-reciever_name="'+sms.sender_name+'">'+sms.notification_description+'<span class="timer">'+newtime +' '+newhours+ ' '+pmam +'</div>');
                           }
                           });
                     
                     }
                     else
                     {
                     if(data.smss_read.length>0 ||  data.smss_unread.length>0)
                     {
                        $(".no").remove();
                     }
                     else
                     {
                           $(".sms_shower").html("<div class='notification confirm no' >no messages recieved</div>");
                     }
                        $(".sms_num").html('');
                        
                        
                     }
                     if(data.smss_read.length>0){
                        data.smss_read.forEach(sms=>{
                           var t = new Date(sms.time);
                           var newtime = t.getFullYear()+'-'+(t.getMonth()+1)+'-'+t.getDate();
                           var newhours = t.toLocaleString('en-US', { hour: 'numeric',minute:'numeric', hour12: false });
                            var pmam = t.getHours()>=12?'PM':'AM';
                           if(($(".sms_shower").find("."+sms.notification_id)).length==0)
                           {
                           $(".sms_shower").append('<div class="admin '+sms.notification_id+' confirm notification read" data-reciever="'+sms.sender+'" data-sender="'+sms.reciever+'" data-reciever_name="'+sms.sender_name+'">'+sms.notification_description+'<span class="timer">'+newtime +' '+newhours+ ' '+pmam +'</div>');
                           }
                           });   
                        }
   /*---------------------------------- end fetch all notification-------------------------------------*/
   /*-------------------- start open function for socket---------------------------*/

                  conn.onopen = function() {
                      var userid = $(".fa-home").data("sender");
                      var data ={
                         onlineperson : userid
                      };
                      if(userid !=null)
                      {
                      conn.send(JSON.stringify(data));  
                      }
               };
             /*-------------------- end open function for socket---------------------------*/
                                          
         /*-------------------- start onmessage function for socket---------------------------*/
               conn.onmessage = function(e) {
                  var json = JSON.parse(e.data),
                      comment_form = "<div class='comment'>"+json.comment+"<div style='font-size:12px;text-align:center'> "+json.dateTime+"</div></div>",
                       pid="";

                      if(json.offlineperson)
                      {
                         pid = json.offlineperson;
                          $(".admins").find("#"+pid+" .online-sign").remove();
                      }
                      if(json.onlineperson)
                      {
                         pid = json.onlineperson;
                         var sign = '<div class="online-sign" ></div>';
                         $(".admins").find("#"+pid).append(sign);
                      }
                      if(json.msg)
                      {
                        $(".chat-body").each(function(){
                        var   reciverid = $(this).data("reciever"),
                              senderid =  $(this).data("sender"),
                              thiss= $(this),
                              th = this;
                              if(json.sender==reciverid && json.reciever==senderid)
                               {
                                 //<div style='color:#ccc'>"+time+' '+ampm+"</div>
                                 msg = "<div class='reciever msg'>"+json.msg+"<div style='color:#ccc;'>"+time+' '+ampm+"</div></div><div style='clear:both' ></div>";
                                 $(this).append(msg);
                               }
                              var scroll_height= th.parentNode.scrollHeight;
                              var scrolling= thiss.parent().scrollTop()+313;
                              console.log(scrolling,scroll_height);
                              if(scrolling > scroll_height)
                              {
                                 thiss.parent().scrollTop(thiss.height());
                              }
                              else
                              {
                                 //thiss.parent().scrollTop(thiss.height());
                              }
                           });
                        var myid = $(".fa-home").data("sender");
                        if(myid == json.reciever)
                        {
                           c = $(".sms_num").text();
                           if(c.length ==0)
                           {
                              c="1";
                           }
                           else
                           {
                              c=parseInt(c)+1;
                           }
                           $(".sms_shower").prepend("<div class='admin  confirm notification  unread' data-sender='"+json.reciever+"' data-reciever='"+json.sender+"' data-reciever_name='"+json.sender_name+"'><div class='name'>"+json.sender_name+":</div>"+json.msg+"<span class='timer'> "+dateTime+"</span></div>");
                           open_chat();
                           $(".no").remove();
                            $(".sms_num").text(c);
                            c=parseInt(c)+1;
                        }
                     }
                  if(json.comment)
                  {
                     $(".job"+json.job_id).find(".comments").prepend(comment_form);
                  }
                  if(json.notification_owner)
                  {
                     pid=$(".fa-home").data("sender");
                     json.notification_owner.c_owner.forEach(person=>{
                        if(pid==person)
                        {
                           $(".no_n").remove();
                          noti_form = "<a href='jobs.php?do=manage&comment_id="+json.notification_owner.noti_info.comment_id+"#"+json.notification_owner.noti_info.comment_id+"' class=' unread confirm notification'><div class='name'>"+json.notification_owner.noti_info.sender_name+":</div>"+json.notification_owner.noti_info.comment+"<div class='job_name'>"+json.notification_owner.noti_info.job_name+"</div><span class='timer'>"+json.notification_owner.noti_info.comment_time+"</span></a>";
                           $(".notifications_shower").prepend(noti_form);
                           g = $(".notifications_num").text();
                           if(g.length ==0)
                           {
                              g="1";
                           }
                           else
                           {
                              g=parseInt(g)+1;
                           }
                            $(".notifications_num").text(g);
                            g=parseInt(g)+1;                             
                        }
                      
                     });
                  }
               };
               
                        /*-------------------- end onmessage function for socket---------------------------*/
                        

                        
               
                 

                  /*---------------------------------------------- open chat -----------------------------------------------------------*/
                  open_chat();
                  function open_chat()
                  {
                     $(".admin").click(function()
                     {
                        let query =matchMedia("(max-width:750px)");
                        var chatlength = document.getElementById("chats").children.length;
                        var firstchat = $("#chats").find(":first");
                        var reciever = $(this).data("reciever");
                        var sender = $(this).data("sender");
                        var reciever_name = $(this).data("reciever_name");
                        var varchat = $(".chats ."+reciever).data("class");                           
                        if(varchat==reciever)
                        {
                           $(".chats").find("."+reciever).css("display","block");
                     
                           $('.minimizing-chats').find("."+reciever).remove();
                           $("."+reciever).find(".chat-body-con").scrollTop($("."+reciever).find(".chat-body-con").scrollTop());                  
                        }
                        else
                        {
                           
                           if(query.matches)
                           {
                              $(".admins-div").css("display","none");
                              if(chatlength==0)
                              {
                                 $.ajax({
                                    url:"chats.php",
                                    type:'POST',
                                    async:false,
                                    cache:false,
                                    data:{client_name:reciever_name,client_id:reciever,sender_id:sender},
                                    success:function(chat){
                                    $(".chats").append(chat);
                                       
                                    }
                                 });                           
                              }
                              else
                              {
                                 $(".chats").find(".chat").remove();
                                 $.ajax({
                                    url:"chats.php",
                                    type:'POST',
                                    async:false,
                                    cache:false,
                                    data:{client_name:reciever_name,client_id:reciever,sender_id:sender},
                                    success:function(chat){
                                    $(".chats").append(chat);
                                       
                                    }
                                 });                             
                              }
                           }
                           else
                           {
                               if(chatlength <=2)
                               {
                                 $.ajax({
                                   url:"chats.php",
                                   type:'POST',
                                   async:false,
                                   cache:false,
                                   data:{client_name:reciever_name,client_id:reciever,sender_id:sender},
                                   success:function(chat){
                                    $(".chats").append(chat);
                                       
                                   }
                                 });                           
                               }
                               else
                               {
                                 firstchat.remove();
                                 $.ajax({
                                   url:"chats.php",
                                   type:'POST',
                                   async:false,
                                   cache:false,
                                   data:{client_name:reciever_name,client_id:reciever,sender_id:sender},
                                   success:function(chat){
                                    $(".chats").append(chat);
                                       
                                   }
                                 });                             
                               }
                           }
                            $("."+reciever).find(".chat-body-con").scrollTop($("."+reciever).find(".chat-body").height());
                           
                        }
                        /*----------------- start chat minimize function ------------------------------------*/
                        $(".chat-minimize").click(function(){
                
                           var chat= $(this).parent().parent();
                           var varclient_name = chat.find('.client_name').data("class");
                           var varclient_id= chat.find('.client_id').data("class");       
                           var varsender_id= chat.find('.sender_id').data("class");
                           chat.css("display",'none');
                           var minimizin_chats=$(".minimizing-chats").html();
                           $.post("minimize_chats.php",{client_name:varclient_name,client_id:varclient_id,sender:varsender_id},function(chat){
                           $(".minimizing-chats").html(minimizin_chats+chat);
                           });
                         }); 
                        /*----------------- end chat minimize function ------------------------------------*/
   
                        /*----------------- start chat close function ------------------------------------*/
                        $(".chat-close").on("click",function(){
                           $(this).parent().parent().remove();
                           $(".admins-div").css("display","table-cell");
                           });                 
                        /*----------------- end chat close function ------------------------------------*/
   
                        /*---------------------------------------------- start sockets -----------------------------------------------------------*/
   
                        $(".chat-footer .send").click(function(){
                              var   chat_footer =  $(this).parent(),
                                    reciever =$(this).parent().parent().find('.client_id').data('class') ,
                                    sender = $(this).parent().parent().find('.sender_id').data('class') ,                            
                                    sender_name = $(this).parent().parent().find('.sender_name').data('class') ,                            
                                    text = chat_footer.find(".text").val(),                 
                                    chat_body =chat_footer.parent().find(".chat-body");
                                    data = {
                                          msg:text,
                                          sender:sender,
                                          reciever:reciever,
                                          sender_name:sender_name
                                       };
                              if(data.msg.trim().length> 0)
                              {
                                 
                                 msg = "<div class='sender msg'>"+text+"<div style='color:#ccc'>"+time+' '+ampm+"</div></div><div style='clear:both' ></div>";
                                 chat_body.append(msg);
                                 chat_footer.find(".text").val('');
                                 chat_footer.find(".text").focus();
                                 chat_body.parent().scrollTop(chat_body.height());
                                 conn.send(JSON.stringify(data));
                              }
                        });
                     /*---------------------------------------------- end sockets -----------------------------------------------------------*/
   
                     $(".chats ."+reciever).find(".text").focus();
                     });
                  }  
                  /*--------------------------------------------end chat openning------------------------------------------*/

            }
         });
         /*--------------------------------- end fetch users ajax ----------------------------- */               

      }
/*------------------------------------------------------------------------------------------------------------------------- */

      $(".notifications").click(function(){
        $(".notifications_content").slideToggle(300);
        $(".notifications_shower").slideToggle(300);
        $(".sms_shower").fadeOut(1000);
        $(".sms_content").fadeOut(1000);
        $(".notifications_num").html("");
        g=" ";
        var userid = $(".fa-home").data("sender");
        var data = {
         notifications_seen:1,
         userid:userid,
        };
        conn.send(JSON.stringify(data));
        });
       $(".sms").click(function(){
        var userid = $(".fa-home").data("sender");
        var data = {
         sms_seen:1,
         userid:userid,
        };
        conn.send(JSON.stringify(data));         
         $(".sms_content").slideToggle(300);
         $(".sms_shower").slideToggle(300);
         $(".notifications_shower").fadeOut(1000);
         $(".notifications_content").fadeOut(1000);
         $(".sms_num").html("");
                 c=" ";

         });
       var $modal = $("#exampleModalCenter"),
            image = document.getElementById("sample_image"),
            cropper;
            $("#upload_image").on("change",function(event){
                  var files = event.target.files;
                  var done = function(url){
                     image.src=url;   
                     $modal.modal("show");
                  };
                  if(files && files.length > 0)
                  {
                     var reader =new FileReader();
                     reader.onload=function(){
                        done(reader.result);
                     };
                  reader.readAsDataURL(files[0]);

                  }
               });
            $modal.on("shown.bs.modal",function(){
                  cropper = new Cropper(image,{
                     aspectRatio:1,
                     viewMode:3,
                     preview:".preview"
                     });
               }).on("hidden.bs.modal",function(){
               cropper.destroy();
               cropper=null;
               
               });
            $("#crop").click(function(){
                  canvas = cropper.getCroppedCanvas({
                     width:400,
                     height:400
                     
                     });
                  canvas.toBlob(function(blob){
                     var reader = new FileReader();
                     reader.readAsDataURL(blob);
                     reader.onloadend=function(){
                        var base64data =reader.result,n,image_name;

                        $.ajax({
                           url:'upload_cropper.php',
                           method:'POST',
                           data:{image:base64data},
                           success:function(data){
                              $modal.modal("hide");
                              $("#uploaded_image").attr('src',data);
                              $("#upload_image").val('');
                              n = data.split("/");
                             image_name =  n[n.length-1];
                             $("#crpimg").val(image_name);
                             $(".show").html(" <div class='alert  text-center'  style='color : #28a745; font-weight:bold'> saved</div>");
                             
                              
                           }                           
                        });
                        };
                     });
               });
            $("#clo, #clos").click(function(){
                              $("#upload_image").val('');
               });
      $(".sending").click(function(){
        var name=$(".nameing").val();
        var email = $(".emailing").val();
        var msg = $("#msgus").val();
        $.ajax({
            url:"insert_msg.php",
            method:"POST",
            async:false,
            cache:false,
            data:{client_name:name,client_email:email,sms:msg},
            success:function(data){
                $(".instructions").html(data);
            }
            
            });
        $(".nameing").val("");
       $(".emailing").val("");
       $("#msgus").val("");        
        });

   });

