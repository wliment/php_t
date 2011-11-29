<?php 

//返回用户没有跟随的用户列表
session_start();
$con = mysql_connect("localhost","root","wukong");
mysql_select_db("php_twitter",$con);
$sql = "select id,username,fullname,icon,user_desc from user_tables where id not in ( select follow_user_id from follow_tables where user_id = ".$_SESSION["id"].") and id <>".$_SESSION["id"];
$query = mysql_query($sql);
$user_arr = array();
while($user = mysql_fetch_array($query)){
  $user_arr[] = $user;
}
echo json_encode($user_arr);

?>


