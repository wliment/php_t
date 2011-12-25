<head>
  <meta http-equiv="Content-type" content="text/html; charset=utf-8">
 <link rel="stylesheet" href="./stylesheets/sigin.css" type="text/css" media="screen" title="no title" charset="utf-8"> 
<script type="text/javascript" src="jquery-1.6.4.min.js" charset="utf-8"> </script>
  <title>登录</title>
  
</head>
<body>
<div id="control">
    <form method="post" action="/log_in" id="form">
        <div id="label1" class="label">邮箱</div>
        <div class="rounded_input">
            <input id="field1" name="email"  type="email" value="">
        </div>

        <div id="label2" class="label">密码</div>
        <div class="rounded_input">
            <input id="field2" name="sign_in[password]" type="password">
        </div>

        <input class="button" id="sigin_button"  type="submit" value="登录">

        <div id="forgot1" class="forgot">
            <a  id="b_forget_password" href="#">忘记密码</a>
        </div>
    <input type="hidden" style="display: none" name="token" value="eebc6ae170c4bb132c6b79c07d136183"></form>

    
</div>

    <div class="forget_password_box" id="forget_password_box" style="display: none; ">
              <div class="close_forget_password"><a href="javascript:void(0);" id="close_forget_password">关闭</a></div>
              <div class="forget_password_inner">
                
                <div class="send_email" id="send_email_ok" style="text-align: left; display: none; ">
                  一封包含密码重置链接的电子邮件<br>已被发送至您的邮箱，请注意查收。<br><br>
                  <button type="submit" class="input_button bg_i" id="b_send_email_ok"><span>确定</span></button>
                </div>
                <div class="row fixfloat" id="send_email" style="display: block; "><h3>忘记密码了？</h3>
                  <label>电子邮箱：</label>
                  <div class="collection">
                    <p class="input_bg"><input type="text" msg="请输入邮箱" value="" class="input_txt required" name="email" id="email_input" ><span></span></p>
                    <em id="email_str">我们将稍后发给您一封电子邮件，请遵循里面<br>的步骤进行密码重设。</em>
                  </div>
                </div>
                <div class="form_btn" id="form_btn" style="display: block; ">
                  <button type="submit" class="input_button bg_i"><span>发送</span></button>
                </div>
              </div>
            </div>
</body>
<script type="text/javascript">

 $('#b_forget_password').click(function(event){
     event.preventDefault();
		 $('#forget_password_box').css("display","block"); 	
	 });


 $('#close_forget_password').click(function(){
			$('#forget_password_box').css("display","none"); 	 
	 });



 /****************************************************************************************************/

  $("#sigin_button").click(function(event){ //登录

    event.preventDefault(); 
  var email = $("#field1").val();
  var password = $("#field2").val();
  var data_str = "email="+email+"&password="+password;
  $.ajax({
    type:"POST",
    url:"/php_twitter/login.php",
    data: data_str,
    dateType: "json" ,
    success:function (data){
      var str  =data.trim();
      var return_code = $.parseJSON(str).code; 

      if(return_code == 0)
      {
          $("#error_notify").removeClass("hidden");

      }
      else{
           window.location.href = "/php_twitter/"; 
      
      }
      
    }
  })

     });

</script>
