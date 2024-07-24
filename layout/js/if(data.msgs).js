



      $.get("index.php?comment="+item+"&job_owner="+job_ownert+"&job_id="+job_idt,function(data){
          thiscomment.find(".comments").prepend(data);
        $('.hiddentextarea').val("");
         });
$.get("profiles.php?comment="+item+"&job_owner="+job_ownert+"&job_id="+job_idt,function(data){
          thiscomment.find(".comments").prepend(data);
        $('.hiddentextarea').val("");
         });
                
                  
                  

    $(".text").focus();
//      $(function(){
//function init(){
//              $(".admins-div").css({"display":'none'});
//              $(".chat-close").click(function(){
//              $(".admins-div").css({"display":'table-cell'});
//                  $(this).parent().parent().remove();
//                  });
//                  }
//      let query =matchMedia("(max-width:750px)");
//      if(query.matches)
//      {
//            $("body").css({"background":'red'});
//            $(".admin").addEventListener("click" ,init());
//            
//      }
//}); 