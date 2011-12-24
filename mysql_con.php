<?php 

//echo "php for twitter"
session_start();
$con = mysql_connect("localhost","root","wukong");
mysql_query("SET NAMES UTF8"); 
mysql_select_db("php_twitter",$con);

?>

