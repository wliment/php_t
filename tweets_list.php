
               <div id = "twitter_con">

                      <div class="tweet-box">
                            <div class="tweet-box-title">
                            <h2>What’s happening?</h2>
                          </div>
                          <div class="text-area">
                          <div class="text-area-editor"><textarea class="twitter-box-editor" style="width: 540px; height: 74px; "></textarea>
                        </div>
              <div class="tweet-button-container">
          <span class="tweetbox-counter-tipsy" style="opacity: 0; "></span>
          <input class="tweet-counter" value="140" disabled="disabled">
          <a href="#" id="tweets_button" class="tweet-button button disabled">Tweet</a>
              </div>
                      </div>
                      </div>
               <div id="twitter_list" tweets_count = <?=count($tweets_arr) ?>>



  <?php foreach( $tweets_arr as $tw ) {?> 
  <div class ="tweets" id=<?= "tweets_wrap_".$tw["id"] ?> data-tweet-id=<?=$tw["id"] ?>>
              <div class="tweets_content_box">
                   <div class="tweets_user_icon"> 
                        <img  height="48" width="48" src=<?= $tw["icon"] ?>></img>
                   </div> 


                  <div class="tweets_content">
                          <div class="tweets_row"> 
                           <span class="tweets_username"><?= $tw["username"] ?></span>
                           <span class="tweets_fullname"><?= $tw["fullname"] ?></span>
                          </div>  
                          <div class="tweets_row"> 
                       <?= trim($tw["twitte"])."<br>" ; ?>
                          </div>  
                          <div class="tweets_row tweets_follow_row" > 
                          <a href="#" id = <?= "tweets_follow_".$tw["id"]  ?>><?=if_follow($tw["username"])?"取消关注":"关注"  ?></a>
                          </div>  

                    </div>
              </div>
        </div>
  <?php } ?> 


                 </div> 
                   </div>
<script>
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
</script>
