<?php 
      session_start();
      $email = $_POST["email"];
      $passwd = $_POST["password"];
       $con = mysql_connect("localhost","root","wukong");
      mysql_select_db("php_twitter",$con);
       $sql = "select  passwd ,id ,icon from user_tables where email='".$email."'";
      $query = mysql_query($sql);

      mysql_close($con);
      $user = mysql_fetch_array($query); 
      $return_var = array();
      if(trim($user["passwd"]) != trim($passwd)){
          $return_var["code"] = "1";
      }
      else
      { //如果密码正确将用户信息保存到session
          $_SESSION["email"]=$email;
          $_SESSION["id"]=$user["id"];
          $_SESSION["icon"] =$user["icon"];
          $return_var["code"] = "0" ;
      }
      $return_json = json_encode($return_var);
      echo trim($return_json);

?>







