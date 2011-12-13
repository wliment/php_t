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

    //微薄条目相关属性
    pt.lastest_tweet_id = 0;//当前用户最近更新的twitter_id
    pt.all_twitter_count=0; //已经更新的用户微薄总数 
    pt.have_update_count=0;//已经更新但是还未显示到列表的条目
    pt.update_tweets_data=[];//后台更新的微薄数据,渲染后清空
    pt.lastest_update_count = 0;//上一次更新的数据


    //用户条目相关属性
    pt.all_user_count = 0;   //用户总数量
    pt.user_data = []; //用户条目数据
    pt.tabhash={
   "收藏":"favorites", 
    "你关注的":"following", 
    "追随你的": "follower",
    "时间线":"timeline"
    
    };
    //页面属性
    pt.pages={};
    pt.currentPage="home"; //当前程序停留在哪一页
    pt.pages.home =  $("#twitter_list");
    pt.pages['is_render']={};
    pt.pages['is_render']['who_to_follow']= false;
    pt.pages['is_render']['home']= false;
    pt.pages['bb']= $("<div id ='user_item_list'></div>") ;

   
    pt.tab={};//页面的tab对象 
    pt.tab.pages ={
      timeline:{load:0},
      favorites:{load:0},
      following:{load:0},
      follower:{load:0} 
    };


/**************************************************************************************************************/

pt.tab.pages.favorites.get_loader = function(){ //每个tab页面都有一个loder 
$.ajax({
url:"/php_twitter/user_favorite.php",
  dataType:'json',
  async:false,
  success:function(data){
      var tweets_list_fav =$("#movieTemplate").tmpl(data).prependTo("#favorited_item_list").show("fast").find("._timestamp");
      tweets_list_fav.each(function(){
        pt.pre_process_tweets($(this));
      });
  }
});
}; 



/**************************************************************************************************************/

pt.tab.pages.following.get_loader = function(){ //user使用现成的loader 
  $.ajax( {  
    url: "/php_twitter/user_following.php",  
    dataType: 'json',  
    async: false,  
    success: function(data){  
      //success code  
      //
      var length = data.length;

      if(length === 0 ) {return 1;}
      else
  {
    pt.all_user_count = data.length;
    pt.user_data = data.concat(pt.user_data);

    var user_list =  $("#userTemplate").tmpl(pt.user_data).hide().prependTo("#following_item_list").show("fast").find(".js-action-follow") ;
     user_list.each(function(){
                     $(this).toggleClass("follow-button");
                     $(this).toggleClass("unfollow-button");
                     $(this).find("span").toggleClass("plus");
                     $(this).find("span").toggleClass("you-follow");
                     if($(this).find(".you-follow").length == 1)
                    {
                      $(this).find("b").remove(); 
                      $('<em class="wrapper"> <b class="unfollow">取消关注</b> <b>正在关注</b> </em>').appendTo($(this));
                    }
                    else
                    {
                      $(this).find(".wrapper").remove();
                      $('<b>关注</b>').appendTo($(this));
                    }

     
     }); 
  }
    }  
      });  

    };
/**************************************************************************************************************/

pt.tab.pages.follower.get_loader = function(){ //每个tab页面都有一个loder 
$.ajax({
url:"/php_twitter/user_follower.php",
  dataType:'json',
  async:false,
  success:function(data){
      var follower_user = $("#userTemplate").tmpl(data).prependTo("#follower_item_list").show("fast").find(".js-action-follow");
      follower_user.each(function()
        {
            if($(this).attr("followeach")==="true")
                { //查看用户是否为你关注的对象
                  $(this).removeClass("follow-button");
                  $(this).addClass("unfollow-button");
                  $(this).find("span").toggleClass("plus");
                  $(this).find("span").toggleClass("you-follow");
                  if($(this).find(".you-follow").length == 1)
                {
                  $(this).find("b").remove(); 
                  $('<em class="wrapper"> <b class="unfollow">取消关注</b> <b>正在关注</b> </em>').appendTo($(this));
                }
                  else
                {
                  $(this).find(".wrapper").remove();
                  $('<b>关注</b>').appendTo($(this));
                }


            }
      });

  }
});
}; 



/**************************************************************************************************************/
pt.tab.currentTab="timeline";
pt.tab.pages.timeline.load = 1;  //默认加载tab timeline
pt.tab.pages.favorites.page_content = $("<div id ='favorited_item_list'></div>") ; //用户收藏的tweets列表
pt.tab.pages.following.page_content = $("<div id ='following_item_list'></div>") ; //用户正在关注用户列表
pt.tab.pages.follower.page_content  = $("<div id='follower_item_list'></div>") ; //关注用户的列表
pt.tab.pages.timeline.page_content = $("#twitter_list") ; //用户timeline

/**************************************************************************************************************/
pt.tab.tab_route = function(tab){  //切换tab函数
  pt.tab.pages[this.currentTab].page_content.detach(); 
  pt.tab.currentTab = tab;
this.pages[tab].page_content.appendTo("#twitter_con"); 
  if(pt.tab.pages[tab].load === 0) //如果页面没加载过则执行加载渲染
  {
     pt.tab.pages[tab].get_loader();      
     this.pages[tab].load = 1; 
  }


};


/**************************************************************************************************************/

    function C(H,F){
if (F == null) {
                return H;
            }
return Mustache.to_html(H, F);
    }

    pt.helpers={ //一些页面辅助公共
      timeAgo:function (J, H, G) { //计算微薄条目离现在发送已经过了多少时间
      H = true;
        var I = pt.helpers.timeStrings();
      var O = I.words[H ? "longForm" : "shortForm"];
      var S = new Date;
      var M = new Date(J);
      var Q = S - M;
      var F = 1000,
          K = F * 60,
          L = K * 60,
          P = L * 24,
          E = P * 7,
          R, D, N;
      if (isNaN(Q) || Q < 0) {
        return "";
      }
      if (Q < F * 3) {
        R = "";
        D = "now";
        G = false
      } else {
        if (Q < K) {
          R = Math.floor(Q / F);
          D = "seconds";
          G = false
        } else {
          if (Q < L) {
            R = Math.floor(Q / K);
            D = "minutes";
            G = false
          } else {
            if (Q < P) {
              R = Math.floor(Q / L);
              D = "hours";
              G = false
            } else {
              if (Q < P * 365) {
                N = C("{{date}} {{month}}", {
                  date: M.getDate(),
                  month: I.dates.months[M.getMonth()]
                })
              } else {
                N = C("{{date}} {{month}} {{year}}", {
                  date: M.getDate(),
                  month: I.dates.months[M.getMonth()],
                  year: M.getFullYear().toString().slice(2)
                })
              }
            }
          }
        }
      }
      if (!N) {
        if (R === 1) {
          O = O.singular
        } else {
          O = O.plural
        }
        N = Mustache.to_html(O[D], {
          one: R,
          plural_number: R
        })
      }
      if (G) {
        N += " " + C("at {{time}}", {
          time: M.toTimeString().split(":").slice(0, 2).join(":")
        })
      }
      return N
    }
    ,timeStrings : function () { //模板数据用于mustcache
                    if ( !pt.helpers.memo) {
                      /*twttr.helpers.timeStrings.memo = {*/
                      pt.helpers.memo={
                        words: {
                                 longForm: {
                                             singular: {//单数
                                                         now: C("now"),
                                                         seconds: C("{{one}} second ago"),
                                                         minutes: C("{{one}} minute ago"),
                                                         hours: C("{{one}} hour ago"),
                                                         days: C("{{one}} day ago")
                                                       },
                                             plural: { //复数
                                                       now: C("now"),
                                                       seconds: C("{{plural_number}} seconds ago"),
                                                       minutes: C("{{plural_number}} minutes ago"),
                                                       hours: C("{{plural_number}} hours ago"),
                                                       days: C("{{plural_number}} days ago")
                                                     }
                                           },
                                 shortForm: {
                                              singular: {
                                                          now: C("now"),
                                                          seconds: C("{{one}} sec"),
                                                          minutes: C("{{one}} min"),
                                                          hours: C("{{one}} hr"),
                                                          days: C("{{one}} day")
                                                        },
                                              plural: {
                                                        now: C("now"),
                                                        seconds: C("{{plural_number}} sec"),
                                                        minutes: C("{{plural_number}} mins"),
                                                        hours: C("{{plural_number}} hrs"),
                                                        days: C("{{plural_number}} days")
                                                      }
                                            }
                               },
                        dates: {
                                 months: [C("Jan"), C("Feb"), C("Mar"), C("Apr"), C("May"), C("Jun"), C("Jul"), C("Aug"), C("Sep"), C("Oct"), C("Nov"), C("Dec")],
                                 dates: [C("1st"), C("2nd"), C("3rd"), C("4th"), C("5th"), C("6th"), C("7th"), C("8th"), C("9th"), C("10th"), C("11th"), C("12th"), C("13th"), C("14th"), C("15th"), C("16th"), C("17th"), C("18th"), C("19th"), C("20th"), C("21st"), C("22nd"), C("23rd"), C("24th"), C("25th"), C("26th"), C("27th"), C("28th"), C("29th"), C("30th"), C("31st")]
                               }
                      }
                    }
                    return pt.helpers.memo;
                    }
                  };
/************************************************************************************************************************/  

 //更新用户收藏的微薄条目
//pt.pages['home'].delegate(".js-actions .js-toggle-fav", "click", function(event) { 
$("#twitter_con").delegate(".js-actions .js-toggle-fav", "click", function(event) { 
  var element = this  ; 
  var tweet_id = $(this).closest(".tweets").attr("data-tweet-id");
  var favorite_is = JSON.parse($(this).attr("favorited"))?"unfavorite":"favorite" ; //获得微薄条目是否被收藏的状态
  $.ajax({
    url:"/php_twitter/tweet_fav.php",
        data:"action="+favorite_is+"&tweet_id="+tweet_id,      
         success:function(data){
                        $(element).toggleClass("favorite-action");
                        $(element).toggleClass("unfavorite-action");
                        $(element).attr("favorited","true");
                 }

     });
  event.preventDefault();


});

 
/************************************************************************************************************************/  

     (function() {
                var jump = 0, now_time; //jump为一个1-10之间的值为的是不让javascript一下子处理所有的微薄，一次大约处理1/10,如果一下子处理大量的微薄，可能会导致页面卡死
                pt.helpers.seek_element = function() {
                    var element = $(this), time_befor = parseInt(element.attr("data-time"), 10);
                    if (now_time - time_befor > 86400000) {
                        /*element.removeClass("_timestamp").addClass("_old-timestamp")*/
                        /*element.text("long long ago");*/
                    } else {
                        var now_time_text = pt.helpers.timeAgo(time_befor, JSON.parse(element.attr("data-long-form") || "false"), JSON.parse(element.attr("data-include-sec") || "false"));
                        if (now_time_text !== element.text()) {
                            element.text(now_time_text);
                        }
                    }
                };
                function process_twitter_time() { //设微薄从发送到现在有多少时间
                    var page = pt.pages[pt.currentPage];
                    now_time = +new Date();
                    page && page.find('span._timestamp[data-time$="' + jump +'000"]').each(pt.helpers.seek_element);
                    setTimeout(process_twitter_time, 2000);
                     jump++;
                    jump %= 10;
                }
                setTimeout(process_twitter_time, 2000);
            }());
/***************************************************************************************************************/
//获得用户收藏的tweets,并渲染
/***************************************************************************************************************/
    pt.get_users_render = function(){  //得到用户列表，并渲染
      $.ajax( {  
        url: "/php_twitter/who_to_follow.php",  
        dataType: 'json',  
        async: false,  
        success: function(data){  
          //success code  
          //
          var length = data.length;

          if(length === 0 ) {return 1;}
          else
      {
        pt.all_user_count = data.length;
        pt.user_data = data.concat(pt.user_data);

        $("#userTemplate").tmpl(pt.user_data).hide().prependTo("#user_item_list").show("fast")  ;
      }
        }  
      });  

    };


/*******************************************************************************************************************************************/

    pt.get_tweets = function(){ //返回微薄原始json数据

        $.ajax( {  
          url: "/php_twitter/home_timeline.php",  
          dataType: 'json',  
          data: "from_id="+pt.lastest_tweet_id,  
          async: false,  
          success: function(data){  
                          //success code  
                          //

             if(data.length === 0 ) 
              { 
                pt.lastest_update_count = 0; //最近更新微薄为0
                return;
              }
              else
              {
               pt.update_tweets_data = data.concat(pt.update_tweets_data); //还未渲染的数据
               pt.all_twitter_count += data.length; //更新未显示的微薄条目数量
               pt.have_update_count += data.length; //本次总共更新了多少条
               pt.lastest_tweet_id = data[0].id;
               pt.lastest_update_count = data.length; //上次跟新的
              }
                   }  
           });  



    };
/*******************************************************************************************************************************************/

  //渲染tweet的@xxx 与链接
pt.render_tweet_content = function(text){

  var url_exp = /(\b(https?|ftp|file):\/\/([-A-Z0-9+&@#%?=~_|!:,.;]*)([-A-Z0-9+&@#%?\/=~_|!:,.;]*)[-A-Z0-9+&@#\/%=~_|])/ig;
  var user_exp =  /(@)([a-zA-Z][a-zA-Z0-9_]+)/gi;
  return text.replace(url_exp, "<a href='$1' target='_blank'>$1</a>").replace(user_exp,"<a class='  twitter-atreply pretty-link' data-screen-name='$1' href='/php_twitter/#$2' rel='nofollow'><s>@</s><b>$2</b></a>");

}


/*******************************************************************************************************************************************/
//修改tweets的属性,在渲染在页面上
pt.pre_process_tweets = function(element){

        var time_befor = parseInt(element.attr("data-time"), 10);
        var now_time_text = pt.helpers.timeAgo(time_befor, true, false);//修改时间
        element.text(now_time_text);

        //tweet内容的渲染
        var tweet_content = element.parent().parent().prev();
        var render_url = pt.render_tweet_content(tweet_content.text());//将link渲染成<a></a>
        tweet_content.html(render_url);

            var fav_tweet = element.parent().next().find(".js-toggle-fav");
        if(fav_tweet.attr("favorited") == "true") //根据收藏的状态修改tweet的收藏按钮
            {
                  fav_tweet.toggleClass("unfavorite-action");
                  fav_tweet.toggleClass("favorite-action");
            }

};

/*******************************************************************************************************************************************/



/*******************************************************************************************************************************************/
      //初始化页面微薄  修改显示在页面上的属性
    (function(){ 

      pt.get_tweets();
      var tweets_list_time = $("#movieTemplate").tmpl(pt.update_tweets_data).hide().prependTo("#twitter_list").show("fast").find("._timestamp");
      tweets_list_time.each(function(){
        pt.pre_process_tweets($(this));//预处理
      });

      pt.have_update_count = 0;
      pt.lastest_update_count =0 ;
      pt.update_tweets_data= [];

    }());

/*******************************************************************************************************************************************/


    pt.regular_get_tweets = function()  //定时从服务器取微薄json条目数据然后在页面上渲染
  {
    pt.get_tweets();//先更新微薄数据 

    if(pt.lastest_update_count === 0)//如果本次更新数量为0,则不做任何操作
      {
      return;
      }

    var tweets_count_str = {tweets_count: pt.have_update_count + " 条新信息" };

    //判断是否已经有一个tweets_bar 在页面上，有直接更新上面的信息，否则创建一个
    var tweets_bar = $("#new-tweets-bar");
    if(tweets_bar.length !== 0)
      tweets_bar.text(tweets_count_str.tweets_count); 
    else  //如果没有new-tweets-bar 则新建一个
    {
      var tweets_bar_template = $("#template-new-tweets-bar");
      tweets_bar_template.tmpl(tweets_count_str).prependTo("#twitter_list");
    }
    };
  
 setInterval("pt.regular_get_tweets()", 5000); //每隔5s从服务器取一次数据



/**************************************************************************************************************/
 
//绑定new_tweet_bar的click 事件
  $("body").delegate("#new-tweets-bar", "click", function(){ 
    var new_tweets = pt.update_tweets_data;
    var return_tweet = $("#movieTemplate").tmpl(new_tweets).hide().prependTo("#twitter_list").show("fast").find("._timestamp"); 
      pt.pre_process_tweets(return_tweet);
    $(this).remove();   //移除new_tweet_bar 
    //pt.tweets_data = pt.update_tweets_data.concat(pt.tweets_data);//将更新的数据附加到总列表
    
    pt.update_tweets_data = [];//清空后台更新的数据
    pt.have_update_count= 0 ;
    });

/**************************************************************************************************************/



  $("#tweets_top_login").click(function(event){ //登陆按钮绑定 点击显示登陆窗口
    if (this.href.split('/')[4] == "logout.php")
  {
    return true;
  }
  $("#tweets_login_popup").toggleClass("hidden");
  $("#log_email").focus();
  event.preventDefault();
  });

  $("#user_setting_bar").click(function(){ //点击用户名显示下拉菜单

    $("#wrap-bar .dropdown").toggleClass("dropdown_hidden") ;
    $(this).toggleClass("user_setting_bar_color");


  });

  $("#global-actions li").click(function(){
    $("#global-actions li.active").toggleClass("active new");  
    $(this).addClass("active new");

  });


  window.onhashchange = function(){
    /*rreturn;*/
    switch (location.hash)
    { 
    case "": 
      pt.pages["who_to_follow"] = $("#user_item_list").detach(); 
      pt.pages["home"].appendTo("#twitter_con");
        break;

    case "#timeline":
    case "#following":
    case "#follower":
    case "#favorites":
        pt.tab.tab_route(location.hash.substring(1));
        break;
    case "#who_to_follow":
        pt.pages["home"] = $("#twitter_list").detach();
        pt.pages["bb"].appendTo("#twitter_con");

        if( pt.pages["is_render"]["who_to_follow"]== false )  /*页面没有渲染过的话，执行渲染*/ 
        {
          pt.get_users_render();
          pt.pages["is_render"]["who_to_follow"]= true;
        }
        break;
    default:
        alert(location.hash);
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
    });
  });
  //$("[id^=tweets_wrap_]").click(function(){
    //var child = $(this).find(".tweets_username").text();
    //if (child == $("#tweets_user_bar").find("#tweets_user_bar_utxt").text().trim())
    //return
    //var image_src= $(this).find("img").prop("src");
  //$("#tweets_user_bar").find("#icon").prop("src",image_src);
  //$("#tweets_user_bar").find("#tweets_user_bar_utxt").text(child);

  //$.ajax({
    //type:"post", 
    //url:"/php_twitter/show_user_info.php",
    //data:"username="+child, 
    //datatype:"json",
    //success:function(data){

      //$("#tweets_user_bar").find("#tweets_user_bar_tcounts").text("信息 "+ data.t_count);
    //}
  //})

  //})
/************************************************************************************************************************/  

  //鼠标移动到twitter_List上的时候改变背景颜色, 此处已经替换为css实现
  //
/*
 *  $("[id^=tweets_wrap_]").hover(function(){
 *    $(this).css("background-color","#ff8345");
 *  },function(){
 *
 *    $(this).css("background-color","#b0e0e6");
 *
 *
 *  }) 
 */


/************************************************************************************************************************/  
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

$("#tweets_button").click(function(event){  //发送微薄到服务器,先发送twitter,然后在返回完整数据

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
    var return_tweet =$("#movieTemplate").tmpl(return_tweet).hide().prependTo("#twitter_list").show("fast").find("._timestamp");
    
        pt.pre_process_tweets(return_tweet);

      } 
    }); 
    event.preventDefault();
  });




//关注用户按钮,因为div是动态生成，普通的绑定无法生效
 $("body").delegate(".js-action-follow", "click", function(){ 
//$(this).removeClass("follow-button");
//$(this).addClass("unfollow-button");
var status;
var user_id = $(this).attr("data-user-id");
var action = ($(this).is(".follow-button")) ? "follow":"unfollow";
var that = $(this);
$.ajax({
  url:"/php_twitter/user_follow.php", 
  data:"action="+action+"&user_id="+user_id,
  dataType:"json",
           success:function(data){
                     status =  data.code; 

                     $(that).toggleClass("follow-button");
                     $(that).toggleClass("unfollow-button");
                     $(that).find("span").toggleClass("plus");

                     $(that).find("span").toggleClass("you-follow");
                     if($(that).find(".you-follow").length == 1)
                    {
                      $(that).find("b").remove(); 
                      $('<em class="wrapper"> <b class="unfollow">取消关注</b> <b>正在关注</b> </em>').appendTo($(that));
                    }
                    else
                    {
                      $(that).find(".wrapper").remove();
                      $('<b>关注</b>').appendTo($(that));
                    }

                  }
   })
 
 });  


$(".stream-tab").click( function  (event) {
  $(".stream-tabs .stream-tab").each(function(){$(this).removeClass("active")});
  $(this).toggleClass("active");
  //event.preventDefault();

})

/************************************************************************************************************************/
  /*
   * 显示用户详细信息面板
   */

$(".twitter-atreply").click(function(event){

  //$(".details-pane").css("display","block");
  var username = $(this).text().substring(1); 
  $(".details-pane").animate({"width":['toggle', 'swing']},"slow",function(){
    $.ajax(
      {
      url:"/php_twitter/user_status.php",  
      data: "username="+username ,
      dataType:"json",
      async: false,  
      success:function(data){
        var a =$("#user_at_Template").tmpl(data);
        alert(a);
        $("#user_at_Template").tmpl(data).appendTo(".pane-components-inner");

      }
      });

      
  });
  
event.preventDefault();

  });


/************************************************************************************************************************/

});
