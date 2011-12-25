
<div id = "twitter_con">



  <div class="page-header home-header">
    <div class="tweet-box">
      <div class="tweet-box-title">
        <h2>新鲜事</h2>
      </div>
      <div class="text-area">
        <div class="text-area-editor"><textarea class="twitter-box-editor" style="width: 500px; height: 74px; "></textarea>
        </div>
        <div class="tweet-button-container">
          <span class="tweetbox-counter-tipsy" style="opacity: 0; "></span>
          <input class="tweet-counter" value="140" disabled="disabled">
          <a href="#" id="tweets_button" class="tweet-button button disabled">发推</a>
        </div>
      </div>
    </div>

    <ul class="stream-tabs">
      <li class="stream-tab stream-tab-tweets active">
        <a class="tab-text" href="#timeline">时间线</a>
      </li>
      <li class="stream-tab stream-tab-favorites">
        <a class="tab-text" href="#favorites">收藏</a>
      </li>
      <li class="stream-tab stream-tab-following">
        <a class="tab-text" href="#following">你关注的</a>
      </li>
      <li class="stream-tab stream-tab-followers">
        <a class="tab-text" href="#follower">追随你的</a>
      </li>
    </ul>
  </div>

  <div id="twitter_list" tweets_count = <?=count($tweets_arr) ?>>



  </div> 
</div>
