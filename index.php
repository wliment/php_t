
<?
session_start();
if(!isset($_SESSION["email"])) 
header("Location: /php_twitter/sigin.php");
 ?>
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
        <li id="global-nav-who_to_follow" data-global-action="who_to_follow"><a href="#who_to_follow">可关注的对象</a></li>
      
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
        <li><a class= "no_implement" href="#">设置</a></li>
        <li><a class= "no_implement" href="#">帮助</a></li>
        <li class="last-child"><a href="/php_twitter/logout.php">注销</a></li>
     </ul>
        </div>

<span class = "vr"></span>
</div>
<?php }  ?>

             <div id="continer">



                      <?php require "tweets_list.php" ?>

              <div id="details-pane-outer"  >
                <div class="details-pane-shell">
                  <div class="details-pane" >

                    <div class="inner-pane active">
                      <div class="pane-toolbar pane-built-in">
                        <a class="pane-close toolbar-control" href="#">关闭<span>×</span></a>
                        <br style="clear: both">
                      </div>
                      <div class="pane-components" style="height: 334px; ">
                        <div class="pane-components-inner">

                      </div>
                  </div>
                    </div>
                </div>
              </div>
              </div>


              </div>









</body>

</html>
