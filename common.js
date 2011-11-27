$(document).ready(function(){
  $("#tweets_top_login").click(function(event){

    /*$("#tweets_login_popup").show();*/
 if (this.href.split('/')[4] == "logout.php")
        {
            return true;
        }
alert(1);
    $("#tweets_login_popup").toggleClass("hidden");
  $("#log_email").focus();
  event.preventDefault();
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
});

