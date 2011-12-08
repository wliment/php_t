<?require "list.php"?>
<?  require "function.php" ?>


<html>
<head>

<link rel="stylesheet" href="./stylesheets/custom.css" type="text/css" media="screen" title="no title" charset="utf-8">
  <title>php_twitter for fun!</title>

<script type="text/javascript" src="jquery-1.6.4.min.js" charset="utf-8"> </script>
<script type="text/javascript" src="jquery.tmpl.js" charset="utf-8"> </script>
<script type="text/javascript" src="./common.js" charset="utf-8"> </script>
<script type="text/javascript" src="./mustache.js" charset="utf-8"> </script>
</style>
  
</head>
<body>
<?php require "temple/twitter_templ.html" ?>
<? if(isset($_SESSION["email"])) { ?> 
<?  echo "dsf" ?>
<div id="wrap-bar">

<form id="search-form" class="js-search-form" action="/search" method="GET">
    <span class="glass js-search-action"><i></i></span>
    <input value="" placeholder="搜索" name="q" id="search-query" type="text">
  </form>

<div id="global-nav">
    <ul id="global-actions">
      
        <li id="global-nav-home" data-global-action="home" class="active new"><a href="#">首页</a></li>
        <li id="global-nav-profile" data-global-action="profile" class=""><a href="#">Profile</a></li>
        <li id="global-nav-messages" data-global-action="messages"><a href="#">Messages</a></li>
        <li id="global-nav-who_to_follow" data-global-action="who_to_follow"><a href="#who_to_follow">Who To Follow</a></li>
      
    </ul>
  </div>

<div id ="user_setting_bar">
<img height="21px" width = "21px" src= <?=$_SESSION["icon"]  ?>></img>
  <span class="screen-name">
     wliment  
  </span>
  <div id="dropdown-click"> </div>
</div>
  <div class="dropdown dropdown_hidden">
      <ul class="user-dropdown">
        <li><a href="/settings/account">设置</a></li>
        <li><a href="//support.twitter.com">Help</a></li>
        <li class="last-child"><a href="//support.twitter.com">signout</a></li>
     </ul>
        </div>

<span class = "vr"></span>
</div>
<?php }  ?>

             <div id="continer">



                      <?php require "tweets_list.php" ?>


                <div id="tweets_user_bar">
                          <p id = "tweets_user_bar_utxt"></p>
                         <img id = "icon" width ="60px" heigth ="60px" src ="" ></img> 
                          <p id = "tweets_user_bar_tcounts"></p> 
                </div>

              </div>



<div id = "tweets_login_bar" >
<?if(isset($_SESSION["email"])){ ?>
<a  id="tweets_top_logout" class ="ti" href="#" title = <?= isset($_SESSION["email"])?$_SESSION["email"]:" "?>> 
<?= $_SESSION["email"] ?>
</a>
<? } ?>
<?  $login_status = isset($_SESSION["email"])?"注销":"请登录" ?>
<a title= <?= $login_status ?> id="tweets_top_login" class="ti" href= <?=$log = isset($_SESSION["email"])?"/php_twitter/logout.php":"/php_twitter/login.php" ?> >
<?=$login_status  ?>
</a>
</div>

<?  require "tweets_login_popup.php" ?>

</body>

</html>
<script>
  </script>

