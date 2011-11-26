  <div id="tweets_login_popup" class="hidden">
          <div id="login_form"> 
            <form action="/php_twitter/login.php" method="post">
              <input type="hidden" name="done" value="/">
              <p class="textbox">
                <label for="log_email">E-mail 地址</label>
                <input type="text" tabindex="1" title="E-mail 地址" value="" name="email" class="noime txt_input r3px" id="log_email" spellcheck="false">
              </p>
              <p class="textbox">
                <span class="fr"><a class="minor" href="/php_twitter/getpassword.php">忘记密码</a></span>
                <label for="log_password">密 码</label>
                <input type="password" tabindex="2" title="密码" value="" name="password" class="txt_input r3px" id="log_password" maxlength="16">
              </p>
              <p class="remember clearfix">
                <input type="submit" class="fr text blue_btn blue_btn2 r3px f14" tabindex="4" value="登 录"  id="log_submit" name="submit">
                <input type="checkbox" tabindex="3" value="1" name="autologin" id="log_remember">
                <label class="minor" for="log_remember">记住我</label>
              </p>
              <div class="error_notify hidden" id="error_notify">
                           用户名或密码错误 
              </div>
            </form>
          </div> 
        </div>
<script>
$("#log_submit").click(function(){
  var email = $("#log_email").val();
  var password = $("#log_password").val();
  var remember_login = $("#log_remember").prop("checked");
  var data_str = "email="+email+"&password="+password+"&remember="+remember_login;
  $.ajax({
    type:"POST",
    url:"/php_twitter/login.php",
    data: data_str,
    dateType: "json" ,
    success:function (data){
      var str  =data.trim();
      var return_code = $.parseJSON(str).code; 
      if(return_code == 1)
      {
          $("#error_notify").removeClass("hidden");

      }
      else{
           window.location.href = "/php_twitter/index.php"; 
      
      }
      
    }
  })
return false;
}
) 
</script>
