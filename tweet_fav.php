<?php require "mysql_con.php" ?>
<?php require "function.php" ?>
<?php 

/*
 *
 *Ϊĳ���û�����һ���ղ�΢����Ŀ
 *url : tweet_fav.php?action="favorite pr unfavorite"&tweet_id=xxx
 *
 */

$action = $_REQUEST["action"];
$tweet_id = $_REQUEST["tweet_id"];

switch ($action)
{
  
case "favorite":
  echo add_fav_tweet($tweet_id);
  break;

case "unfavorite":
  echo remove_fav_tweet($tweet_id);
  break;
}
?>
