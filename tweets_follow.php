<?php 
/*
 *为某个用户增加一个关注的对象
 *
 *url：tweets_favorite.php?follow_user_id=xxx
 *
 */

 session_start();
 $con = mysql_connect("localhost","root","wukong");
 mysql_select_db("php_twitter",$con);
 $user_id = $_SESSION["id"];
 $follow_user_name = $_REQUEST["follow_user_name"]; 
 $sql = "select id from user_tables where username = '".$follow_user_name."'";
 $query = mysql_query($sql);
 $follow_user_id = mysql_fetch_array($query); 

/*检查此用户是否已经关注过此对象*/
$sql = "select count(*) as cc from follow_tables where user_id = '".$user_id."' and  follow_user_id ='" .$follow_user_id["id"]."'";
$query = mysql_query($sql);
$fav =mysql_fetch_array($query);
$return_var = array();
if($fav["cc"] >= 1)
  {
    $return_var["code"]="1";
  }
else 
  {
    $sql = "insert into follow_tables(user_id,follow_user_id)  values('".$user_id."','".$follow_user_id["id"]."')";
    mysql_query($sql);
    $return_var["code"]="0";
  }

  $return_json= json_encode($return_var);
  echo trim($return_json);
 mysql_close($con);

?>
