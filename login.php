<?php require "mysql_con.php" ?>
<?php    
      $email = $_REQUEST["email"];
      $passwd = $_REQUEST["password"];
      $sql = "select  passwd ,id ,icon from user_tables where email='".$email."'";
      $query = mysql_query($sql);

      $user = mysql_fetch_array($query); 
      $return_var = array();
      if(trim($user["passwd"]) != trim($passwd)){
          $return_var["code"] = "0";
      }
      else
      { //如果密码正确将用户信息保存到session
          $_SESSION["email"]=$email;
          $_SESSION["id"]=$user["id"];
          $_SESSION["icon"] =$user["icon"];
          $return_var["code"] = "1" ;
      }
      $return_json = json_encode($return_var);
      echo trim($return_json);

?>







