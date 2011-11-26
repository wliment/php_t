/*
 *生成全部用户的微薄列表
 */
<?php 

//echo "php for twitter"
session_start();
$con = mysql_connect("localhost","root","wukong");
mysql_select_db("php_twitter",$con);
/*$sql = "select tweets,user_id,username from tweets";*/
$sql = "select tweets.id,twitte,user_id,username,fullname,icon from tweets,user_tables where tweets.user_id = user_tables.id";

if( isset($_SESSION["email"]) ) 
{
$sql = "select tweets.id,twitte,tweets.user_id,username,fullname,icon,create_time from tweets,follow_tables,user_tables where tweets.user_id = user_tables.id and tweets.user_id = follow_tables.follow_user_id and tweets.user_id in(select follow_tables.follow_user_id from follow_tables  where user_id='".$_SESSION["id"]."') order by create_time desc";
}
$tweets = mysql_query($sql);
$tweets_arr = array();
while($tweet = mysql_fetch_array($tweets)) {
   $tweet["twitte"];
   $tweets_arr[] = $tweet;
   /*echo $tweet["id"];*/
}
mysql_close($con);
?>
