<?php require "mysql_con.php"  ?>
<?php require "function.php"  ?>
<?php 

echo user_follower_count("zheng"); 
echo " " ;
echo user_tweets_count("zheng");
echo " " ;
echo user_following_count("wliment");

?>
