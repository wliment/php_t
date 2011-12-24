<?php require "mysql_con.php" ?>
<?php require "function.php" ?>
<?php 

/*
 *返回用户的tweets总数，follower总数,folowing总数
 此处的user只任何一个可见的@xxxxx用户
 user_status.php?username=xxxx
 */

$username = $_REQUEST["username"];
$user_info = array();

$user_info["following"] = user_following_count($username) ;
$user_info["follower"] = user_follower_count($username);
$user_info["tweet_counts"] = user_tweets_count($username);
$user_info = $user_info +  user_info($username) ;
echo json_encode($user_info);

?>
