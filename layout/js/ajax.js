$(document).ready(function()
{
     
        var sender=null , reciever = null;
            
        
      $(".chat-footer .send").click(function(){
        var chat_footer =  $(this).parent();
        var text = chat_footer.find(".text").val();
         reciever =$(this).parent().parent().find('.client_id').data('class') ;
         sender = $(this).parent().parent().find('.sender_id').data('class') ;
                     $.ajax({
                       url:"insert_msg.php",
                       type:'POST',
                       async:false,
                       cache:false,
                       data:{sender_id:sender,reciever_id:reciever,msg:text},
                       success:function(){
                           
                       }
                     });    
          chat_footer.find('.text').val('');

        
        
        });

      //function chatMsg(item)
      //{
      //  //if(sender==item.sender)
      //  //{
      //  //  let times = new Date(item.time);
      //  //  timeer = times.getHours();
      //  //  miner=times.getMinutes();
      //  //  timo=timeer+":"+miner;
      //  //return "<div class='msg sender'>"+item.msg+" <span>"+timo+"</span></div><div style='clear:both'></div>";
      //  //}
      //  //else
      //  //{
      //  return "<div class='msg reciever'>"+item.msg+"  <span>"+item.time+"</span></div><div style='clear:both'></div>";
      //    
      //  //}
      //}

        $(".text").focus();



            /*  ---------------------------------------------------------------------- */
       
       //setInterval(function(){ gg(); },10000);

       //function gg(){
       //     $(".chat-body").each(function(){
       //         var thiss= $(this);
       //         var last_msg = thiss.find(".msg:last").data("class");
       //         var varclient_id = thiss.parent().parent().find('.client_id').data('class');             
       //         var varclient_name = thiss.parent().parent().find('.client_name').data('class');             
       //         var varsender_id = thiss.parent().parent().find('.sender_id').data('class');    
       //            $.ajax({
       //              url:"refresh_msgs.php",
       //              type:"POST",
       //              async:false,
       //              cache:false,
       //              data:{lastmsg:last_msg,client_name:varclient_name,client_id:varclient_id,sender_id:varsender_id},
       //              success:function(msg){
       //                 if(msg!='')
       //                 {
       //                 thiss.append(msg);
       //                    
       //                 }
       //                 else
       //                 {
       //                    
       //                 }
       //                          
       //              }
       //              });
       //   
       //      });
       //  }
       //  
            ///*  ---------------------------------------------------------------------- */
            //
            //  $(".chat-footer .send").click(function(){
            //    var chat_body = $(this).parent().parent().find(".chat-body");
            //    var last_msg=chat_body.find(".msg:last").data("class");
            //    var chat_footer =  $(this).parent();
            //    var text = chat_footer.find(".text").val();
            //    var reciever_id =$(this).parent().parent().find('.client_id').data('class') ;
            //    var sender_id = $(this).parent().parent().find('.sender_id').data('class') ;
            //    if(text.trim()!='')
            //    {
            // //chat_body.append('<div class = "sender msg" data-class="'+last_msg+'">'+text+'</div><div style="clear:both"></div>');
            //     chat_footer.find(".text").val("");
            //     chat_footer.find(".text").focus();
            //
            //    $.post("insert_msg.php",{msg:text,reciever:reciever_id,sender:sender_id});
            //    
            //    chat_body.parent().scrollTop(chat_body.height());
            //    }
            //    
            //    chat_footer.find(".text").focus();
            //  });
            ///*  ---------------------------------------------------------------------- */
              $(".chat-close").on("click",function(){
             $(this).parent().parent().remove();
               });
            /*  ---------------------------------------------------------------------- */

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
              
            /*  ---------------------------------------------------------------------- */

   //$(".admin").click(function(){
   // setTimeout(function(){
   //     
   //     load();
   //     
   //     },1000);
   // 
   // });
   //load();
   //   function load(){
   //     $.get(url,"start="+start,function(result){
   //       if(result.items){
   //         result.items.forEach(item=>{
   //           start=item.msg_id;
   //           
   //           $(".chat-body").append(chatMsg(item));
   //           
   //           });
   //         
   //       }
   //
   //       });
   //     
   //     
   //   }
/*      setInterval(function(){
        load();
        
        },1000);
*/
});

   