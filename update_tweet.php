<?php require "function.php" ?>
<?php
session_start();
if(!isset($_SESSION["email"]))
{
  echo 0;
  exit;
}
$con = mysql_connect("localhost","root","wukong");
mysql_select_db("php_twitter",$con);
$tweet_text = isset($_REQUEST["tweet_text"]) ?$_REQUEST["tweet_text"]:0;


$sql = "insert into tweets(twitte,user_id) values('{$tweet_text}',{$_SESSION["id"]})" ;
$query =  mysql_query($sql);
$id =  mysql_insert_id($con);
$sql = "select tweets.id,twitte,tweets.user_id,username,fullname,icon,create_time from tweets,user_tables where tweets.user_id = user_tables.id and tweets.id={$id}" ;
$query = mysql_query($sql);
$return_tweet = mysql_fetch_array($query);
$return_tweet["create_time_int"] = strtotime($return_tweet["create_time"])*1000;
$return_tweet["favorited"] = is_fav($return_tweet["id"])?"true" : "false";
$return_json  = json_encode($return_tweet); 
echo $return_json;



?>
