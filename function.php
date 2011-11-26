
<?php

function if_follow($follow_user_name)
{
  $con = mysql_connect("localhost","root","wukong");
  mysql_select_db("php_twitter",$con);
  $sql = "select id from user_tables where username = '".$follow_user_name."'";
  $query = mysql_query($sql);
  $follow_user_id = mysql_fetch_array($query); 
if(isset($_SESSION["id"]))
{
  $user_id = $_SESSION["id"];
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
}

function show_user_info($username){

  $con = mysql_connect("localhost","root","wukong");
  mysql_select_db("php_twitter",$con);
  $sql = "select count(*) as t_count from tweets where user_id =  (select id from user_tables where username ='".$username."')";
  $query = mysql_query($sql);

  $temp =mysql_fetch_array($query);
  $retun_json = json_encode($temp);
  echo $retun_json;
   
}


?>
