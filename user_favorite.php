
<?php require "mysql_con.php" ?>
<?php require "function.php" ?>
<?php 
/*
 *获得一个用户所有收藏的tweets
 *
 *url：user_follow.php
 *
 */


$sql = "select tweets.id,twitte,tweets.user_id,username,fullname,icon,create_time from tweets,user_tables  where tweets.user_id = user_tables.id and tweets.id in (select tweet_id from tweet_fav where user_id = {$_SESSION["id"]})";

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
