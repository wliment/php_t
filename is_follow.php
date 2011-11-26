
<?php

function if_follow($follow_user_name)
{
  $con = mysql_connect("localhost","root","wukong");
  mysql_select_db("php_twitter",$con);
  $sql = "select id from user_tables where username = '".$follow_user_name."'";
  session_start();
 $user_id = $_SESSION["id"];
  $query = mysql_query($sql);
  $follow_user_id = mysql_fetch_array($query); 
  $sql = "select count(*) as cc from follow_tables where user_id = '".$user_id."' and  follow_user_id ='" .$follow_user_id["id"]."'";
  $query = mysql_query($sql);
  $fav =mysql_fetch_array($query);
  $return_var = array();

  if($fav["cc"] >= 1)
  {
    return true;
  }
  else 
{
  return false;
  }

}

?>
