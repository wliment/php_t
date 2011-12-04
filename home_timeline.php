<?php require "function.php" ?>
<?php 
session_start();
$con = mysql_connect("localhost","root","wukong");
mysql_select_db("php_twitter",$con);
$from_id = isset($_REQUEST["from_id"]) ?$_REQUEST["from_id"]:0;

$sql = "select tweets.id,twitte,tweets.user_id,username,fullname,icon,create_time from tweets,follow_tables,user_tables where tweets.user_id = user_tables.id and tweets.user_id = follow_tables.follow_user_id and tweets.user_id in(select follow_tables.follow_user_id from follow_tables  where user_id={$_SESSION['id']}) and tweets.id >{$from_id} order by tweets.id desc";

$tweets =mysql_query($sql);
$tweets_arr = array();
while($tweet = mysql_fetch_array($tweets)){
  $tweet["create_time_int"] = strtotime($tweet["create_time"])*1000;
  $tweet["favorited"] = is_fav($tweet["id"])?"true" : "false";
  $tweets_arr[] = $tweet;
}

$return_json= json_encode($tweets_arr);
echo $return_json;

?>
