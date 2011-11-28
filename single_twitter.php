
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
