<?php 


session_start();
  if( isset($_SESSION["email"])   )
  {
    unset($_SESSION["email"]);
    unset($_SESSION["id"]);
      echo "你已经成功注销";
      echo '<a href="/php_twitter/">返回首页</a>';
  }
  else
  {
      echo "error,没有任何用户登录";
  }

?>
