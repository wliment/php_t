<?php 

session_start();
$con = mysql_connect("localhost","root","wukong");
mysql_select_db("php_twitter",$con);
$sql = "select id,username,fullname,icon,user_desc from user_tables where id not in ( select follow_user_id from follow_tables where user_id = ".$_SESSION["id"].") and id <>".$_SESSION["id"];
$query = mysql_query($sql);
$temp = array();
$temp = mysql_fetch_array($query);
mysql_close($con);

?>

<div id="user-item-list" >
<img src=<?=$temp["icon"]  ?> alt=<?=$temp["username"]."|".$temp["fullname"]  ?> class="user-content-image user-profile-link" data-user-id="3325721">
  
  <div class="user-content-rest">
    <span class="user-name">
      <a class="user-profile-link" data-user-id="3325721" href="/#!/zicjin" title="Cheney|彩泥"><strong>zicjin</strong></a>
      <span class="full-name"><?=$temp["fullname"]  ?></span>
      </span>
      <div class="user-description"> <?=$temp["user_desc"] ?> </div>
    <div class="user-meta">
                  </div>
    </div>
</div>
</div>
