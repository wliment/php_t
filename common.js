$(document).ready(function(){



  //初始化全局对象php_twitter此对象包括所有的页面使用变量
  //初始化最近发表的信息id
  /*
   *$(document).ready(function(){
   *  var current_last_tweet_id =$("#twitter_list  .tweets:first").attr("data-tweet-id");
   *  $("#twitter_list").data("lastest_tweet_id",current_last_tweet_id);
   *  $("#twitter_list").data("new_tweets_count",0);
   *  $("#twitter_list").data("new_tweets",new Array());
   *})
   */




    pt={};  //pt 代表php_twitter
    pt.lastest_tweet_id = 0;//当前用户最近更新的twitter_id
    pt.all_twitter_count=0; //已经更新的用户微薄总数 
    pt.have_update_tweets=0;//已经更新但是还未显示到列表的条目
    pt.update_tweets_data=[];//后台更新的微薄数据
    pt.lastest_update_count = 0;//上一次更新的数据
   



    pt.get_tweets = function(){ //返回微薄原始json数据
      alert(3);

      $.ajaxSetup({
         async: false
      });
//after  
$.ajax( {  
  url: "/php_twitter/home_timeline.php",  
  dataType: 'json',  
  data: "from_id="+pt.lastest_tweet_id,  
  async: false,  
  success: function(data){  
                  //success code  
                  //
      var length = data.length;
    
      if(length == 0 )
        return;
      else
      {
       pt.update_tweets_data = data.concat(pt.update_tweets_data); //将更新的数据和还没有显示的数据合并在一起
       pt.all_twitter_count += data.length; //本次总共更新了多少条
       pt.have_update_tweets += data.length; //更新未显示的微薄条目数量
       pt.lastest_tweet_id = data[0].id;
       alert(1);
      }
               }  
   });  
    }





    pt.render_tweets = function()  //定时从服务器取微薄json条目数据然后在页面上渲染
  {
    pt.get_tweets();//先更新微薄数据 

       alert(2);
 $("#movieTemplate").tmpl(pt.update_tweets_data).hide().prependTo("#twitter_list").show("fast");
    if(pt.lastest_update_count == 0)//如果本次更新数量为0,则不做任何操作
      return

    var tweets_count_str = {tweets_count: pt.have_update_tweets + " 条新信息" };

    //判断是否已经有一个tweets_bar 在页面上，有直接更新上面的信息，否则创建一个
    var tweets_bar = $("#new-tweets-bar");
    if(tweets_bar.length != 0)
      tweets_bar.text(tweets_count_str.tweets_count); 
    else  //如果没有new-tweets-bar 则新建一个
    {
      var tweets_bar_template = $("#template-new-tweets-bar")
        tweets_bar_template.tmpl(tweets_count_str).prependTo("#twitter_list");
    }

    }
pt.render_tweets(); //初始化微薄列表




//绑定new_tweet_bar的click 事件
  $("body").delegate("#new-tweets-bar", "click", function(){ 
    var new_tweets = pt.update_tweets_data;
    $("#movieTemplate").tmpl(new_tweets).hide().prependTo("#twitter_list").show("fast"); 
    $(this).remove();    
    pt.tweets_data = pt.update_tweets_data.concat(pt.tweets_data);//将更新的数据附加到总列表
    pt.update_tweets_data = [];//清空后台更新的数据


    });

 // setInterval("pt.render_tweets()", 5000);




  $("#tweets_top_login").click(function(event){ //登陆按钮绑定 点击显示登陆窗口
    if (this.href.split('/')[4] == "logout.php")
  {
    return true;
  }
  $("#tweets_login_popup").toggleClass("hidden");
  $("#log_email").focus();
  event.preventDefault();
  })

  $("#user_setting_bar").click(function(){ //点击用户名显示下拉菜单

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












  $("[id^=tweets_follow_]").click(function(){
    var will_follow_user = $(this).parent().parent().find(".tweets_username").text();
    var data_str ="follow_user_name=" + will_follow_user;
    $.ajax({
      type:"post", 
      url:"/php_twitter/tweets_follow.php",
      data:data_str, 
      datatype:"json",
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
    type:"post", 
    url:"/php_twitter/show_user_info.php",
    data:"username="+child, 
    datatype:"json",
    success:function(data){

      $("#tweets_user_bar").find("#tweets_user_bar_tcounts").text("信息 "+ data.t_count);
    }
  })

  })
  $("[id^=tweets_wrap_]").hover(function(){
    $(this).css("background-color","#ff8345");
  },function(){

    $(this).css("background-color","#b0e0e6");


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
    type: "post", 
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
