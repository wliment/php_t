
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
