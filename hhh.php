<?php
ob_start();
session_start();

include"init.php";

?>
<i class="fa fa-user u"></i>

<script>
        $(function(){
           
           $(".u").on("click",function(){
                    $.get('example.php?name=hhhh&good=pog',function(one,two,three){
                       console.log(one);
                       console.log(two);
                       console.log(three);
                       
                       });      
              
              
              });
        
        });
</script>
<?php
include $tpl . "footer.php";

ob_end_flush();
?>