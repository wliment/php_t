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

$("[id^=tweets_follow_]").click(function(){
  var will_follow_user = $(this).parent().parent().find(".tweets_username").text();
  var data_str ="follow_user_name=" + will_follow_user;
  $.ajax({
    type:"POST", 
      url:"/php_twitter/tweets_follow.php",
    data:data_str, 
    dataType:"json",
    success:function(data){
      if(data.code == "1")
      {
        alert("你已经关注此对象");
      }

    }
  })
})
$("[id^=tweets_wrap_]").click(function(){
var child = $(this).find(".tweets_username").text();
if (child == $("#tweets_user_bar").find("#tweets_user_bar_utxt").text().trim())
  return
var image_src= $(this).find("img").prop("src");
$("#tweets_user_bar").find("#icon").prop("src",image_src);
$("#tweets_user_bar").find("#tweets_user_bar_utxt").text(child);

  $.ajax({
    type:"POST", 
      url:"/php_twitter/show_user_info.php",
    data:"username="+child, 
    dataType:"json",
    success:function(data){

$("#tweets_user_bar").find("#tweets_user_bar_tcounts").text("信息 "+ data.t_count);
    }
  })

})
$("[id^=tweets_wrap_]").hover(function(){
  $(this).css("background-color","#FF8345");
},function(){

  $(this).css("background-color","#B0E0E6");

  
}) 
$(".twitter-box-editor").keyup(function(){
  if($(this).val().length > 0){  //如果输入区域有内容则打开j
    $(".tweet-button").removeClass("disabled")
  }
  else{

    $(".tweet-button").addClass("disabled")
  }
  //显示还能输入多少字
  $(".tweet-counter").val(140 -  $(this).val().length );
            
  })

    $("#tweets_button").click(function(event){  //发送微薄到服务器

      var tweet_text = "tweet_text="+$(".twitter-box-editor").val();
      $.ajax({ 
            type: "POST", 
            url: "update_tweet.php", 
            data:tweet_text , 
            success: function(data){ //返回新的数据添加的列表中
                $(".twitter-box-editor").val("");
                $(".tweet-counter").val("140");
                $(".tweet-button").addClass("disabled");
                if(data == "0" )
                {
                    alert("请先登录,确定后自动跳转");
                    window.location = "/php_twitter/sigin.php";
                    return;
                }
                var return_tweet = jQuery.parseJSON(data);
                $("#movieTemplate").tmpl(return_tweet).hide().prependTo("#twitter_list").show("fast");

            } 
          }); 

    event.preventDefault();
    });
});

