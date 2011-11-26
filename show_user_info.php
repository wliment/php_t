<? require "function.php"?> 

<?php 
$user_info = show_user_info($_REQUEST["username"]);
echo $user_info;

?>
