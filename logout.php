<head>
<script type="text/javascript" src="jquery-1.6.4.min.js" charset="utf-8"> </script>
</head>
<?php 


session_start();
  if( isset($_SESSION["email"])   )
  {
    unset($_SESSION["email"]);
    unset($_SESSION["id"]);
    echo "2s后自动跳转";
    echo "如果页面没有跳转请点击<a href='/php_twitter/sigin.php'>此处</a>"; 
  }
  else
  {
      echo "error,没有任何用户登录";
  }

?>


<script>
$(document).ready(function(){

  function jump(){
 window.location = "/php_twitter/sigin.php";
  
  }
 setTimeout(jump, 2000);

  })
    </script>
