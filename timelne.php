<?php require "mysql_con.php" ?>
<?php 
  session_start();
  $user_id = $_REQUEST["id"]
  

$sql = "select tweets.id,twitte,user_id,username,fullname,icon from tweets,user_tables where tweets.user_id = user_tables.id and ";

 ?>
