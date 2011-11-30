<?php require "mysql_con.php" ?>
<?php require "function.php" ?>
<?php 
/*
 *为某个用户增加一个关注的对象
 *
 *url：tweets_favorite.php?action="unfollow or follow"&user_id=xxx
 *
 */

$action  = $_REQUEST["action"];
$user_id = $_REQUEST["user_id"];

switch($action)
{
case "follow":
  echo follow_user($user_id);
    break;
case "unfollow":
   echo unfollow_user($user_id);
}
?>
