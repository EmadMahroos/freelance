$(document).ready(function(){

   "use strict";
 
   $(".profile-logo li").click(function(){
                                        $('.profile-logo li ul').slideToggle();
                                        
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
               $(this).addClass("select").removeClass("point").siblings(".show-data").removeClass('select').addClass("point");
            });
   $(".show-data").click(function()
            {
               $(this).parent().parent().parent().find('.card-body').slideDown();
               $(this).addClass("select").removeClass("point").siblings(".hide-data").removeClass('select').addClass("point");
               
               

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
      $(".file-close").on("click",function(){
      var item = $(this).parent().data("class");
      $.post("jobs.php",{name:item},function(name,n,b){console.log(name);
             console.log(n);
             console.log(b);});
      
      
      });
      setInterval(function(){
            update_last_activity();
         },5000);
      function update_last_activity(){
         $.ajax({
            
            url:"update_last_activity.php",
            success:function()
            {
            }
            
            });
         }
         
});