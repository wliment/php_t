<?require "list.php"?>
<?  require "function.php" ?>

<html>
<head>

<link rel="stylesheet" href="./stylesheets/custom.css" type="text/css" media="screen" title="no title" charset="utf-8">
  <title>php_twitter for fun!</title>

<script type="text/javascript" src="jquery-1.6.4.min.js" charset="utf-8"> </script>
<script type="text/javascript" src="jquery.tmpl.js" charset="utf-8"> </script>
<script type="text/javascript" src="common.js" charset="utf-8"> </script>
</style>
  
</head>
<body>


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


$("#tweets_top_login").click(function(){

    /*$("#tweets_login_popup").show();*/
 if (this.href.split('/')[4] == "logout.php")
        {
            return true;
        }

    $("#tweets_login_popup").toggleClass("hidden");
  $("#log_email").focus();
         return false;//阻止链接的默认行为
})

  $("#user_setting_bar").click(function(){
    
   $("#wrap-bar .dropdown").toggleClass("dropdown_hidden") ;
   $(this).toggleClass("user_setting_bar_color");

     
  })

    $("#global-actions li").click(function(){
        $("#global-actions li.active").toggleClass("active new");  
        $(this).addClass("active new");
    
    })


  window.onhashchange = function(){
    /*rreturn;*/
    switch (location.hash)
    { 
      case "": 
        $("#twitter_con").load("/php_twitter/index.php #twitter_list")
      break;

      case "#who_to_follow":
        $("#twitter_list").load("/php_twitter/who_to_follow.php#user_item-list")
      break;
    }
  };


setInterval("get_tweets()", 5000);

//初始化最近发表的信息id
$(document).ready(function(){
  var current_last_tweet_id =$("#twitter_list  .tweets:first").attr("data-tweet-id");
  $("#twitter_list").data("lastest_tweet_id",current_last_tweet_id);
  $("#twitter_list").data("new_tweets_count",0);
  $("#twitter_list").data("new_tweets",new Array());
})

function get_tweets()
{
  // 获得现在最近的一个信息id
    var current_last_tweet_id = $("#twitter_list").data("lastest_tweet_id");
    $.getJSON("/php_twitter/home_timeline.php","from_id="+current_last_tweet_id,function(data){
    var length = data.length;

    if(length == 0 )
        return;
    else
    {
      $("#twitter_list").data("lastest_tweet_id",data[0].id);
        var temp_count =  $("#twitter_list").data("new_tweets_count");
         new_tweets_count = temp_count + data.length;
      $("#twitter_list").data("new_tweets_count",new_tweets_count);

    }
        
    var tweets_count_str = {tweets_count: new_tweets_count + " 条新信息" };

    //判断是否已经有一个tweets_bar 在页面上，有直接更新上面的信息，否则创建一个
      var tweets_bar = $("#new-tweets-bar");
     if(tweets_bar.length != 0)
        tweets_bar.text(tweets_count_str.tweets_count); 
     else  //如果没有new-tweets-bar 则新建一个
     {
       var tweets_bar_template = $("#template-new-tweets-bar")
         tweets_bar_template.tmpl(tweets_count_str).prependTo("#twitter_list");
     }

      var tweets_data =data.concat( $("#twitter_list").data("new_tweets"));
      $("#twitter_list").data("new_tweets",tweets_data);
        
  })
}
$("body").delegate("#new-tweets-bar", "click", function(){
  var new_tweets = $("#twitter_list").data("new_tweets");
  $("#movieTemplate").tmpl(new_tweets).hide().prependTo("#twitter_list").show("fast"); 
  $(this).remove();    
  $("#twitter_list").data("new_tweets",[]);
  $("#twitter_list").data("new_tweets_count",0);

});
</script>

<script id="template-new-tweets-bar" type="text/x-text-query-tmpl">
  <div id="new-tweets-bar" >${tweets_count}</div>
</script>

<script id="movieTemplate" type="text/x-text-jquery-tmpl">
  <div class ="tweets" id= "tweets_wrap_${id}" data-tweet-id=${id}>
              <div class="tweets_content_box">
                   <div class="tweets_user_icon"> 
                     <img  height="48" width="48" src= ${icon} ></img>
                   </div> 


                  <div class="tweets_content">
                          <div class="tweets_row"> 
                            <span class="tweets_username"> ${username} </span>
                            <span class="tweets_fullname"> ${fullname} </span>
                          </div>  
                          <div class="tweets_row"> 
                             ${twitte} <br> 
                          </div>  
                          <div class="tweets_row tweets_follow_row" > 
                          </div>  

                    </div>
              </div>
        </div>
</script>
