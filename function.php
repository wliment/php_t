<?php

//用户是否关注了某个用户
function if_follow($follow_user_id) //
{
if(isset($_SESSION["id"]))
{
  $user_id = $_SESSION["id"];
  $sql = "select count(*) as  cc from follow_tables where user_id = '".$user_id."' and  follow_user_id ='" .$follow_user_id."'";

  $query = mysql_query($sql);
  $fav =mysql_fetch_array($query);
  $return_var = array();

  if($fav["cc"] >= 1)
  {
    return 1;
  }
  else 
{
  return 0;
  }
}
}

/**************************************************************************************************************/
/*
 *返回用户关注的用户列表(json)
 */
  function user_following()
  {
    /*$user_id = $_SESSION["id"];*/
    $sql = "select id,username,fullname,icon,user_desc from user_tables where id  in ( select follow_user_id from follow_tables where user_id = ".$_SESSION["id"].") and id <>".$_SESSION["id"];
    $query = mysql_query($sql);
    $user_arr = array();
    while($user = mysql_fetch_array($query)){
      $user_arr[] = $user;
    }
    echo json_encode($user_arr);
  }

/**************************************************************************************************************/
/*
 *  返回关注此用户的列表
 */
  function user_follower()
  {

    $sql = "select id,username,fullname,icon,user_desc from user_tables where id  in ( select user_id from follow_tables where follow_user_id = ".$_SESSION["id"].") and id <>".$_SESSION["id"];
    $query = mysql_query($sql);
    $user_arr = array();
    while($user = mysql_fetch_array($query)){
      $user["followeach"] = if_follow($user["id"])?"true":"false";
      $user_arr[] = $user;
    }
    echo json_encode($user_arr);
  }
/**************************************************************************************************************/

function follow_user($follow_user_id)  //关注某个用户
{
  $user_id = $_SESSION["id"];
  $follow_user_id = $_REQUEST["user_id"]; 

  /*检查此用户是否已经关注过此对象*/
  if(if_follow($follow_user_id)) //查看用户是否已经关注过此用户
  {
    $return_var["code"]=0;
  }
  else 
  {
    $sql = "insert into follow_tables(user_id,follow_user_id)  values('".$user_id."','".$follow_user_id."')";
    mysql_query($sql);
    $return_var["code"]=1;
  }

  $return_json= json_encode($return_var);
  echo trim($return_json);
  }



function unfollow_user($user_id)  //取消关注一个用户
{

  $user_id = $_SESSION["id"];
  $follow_user_id = $_REQUEST["user_id"]; 

  /*检查此用户是否已经关注过此对象*/
  if(!if_follow($follow_user_id)) //查看用户是否已经关注过此用户
  {
    $return_var["code"]=0;
  }
  else 
  {
    $sql = "delete from follow_tables where user_id={$user_id} and follow_user_id = {$follow_user_id} ";
    mysql_query($sql);
    $return_var["code"]=1;
  }

  $return_json= json_encode($return_var);
  echo trim($return_json);
}


function show_user_info($username){
  $sql = "select count(*) as t_count from tweets where user_id =  (select id from user_tables where username ='".$username."')";
  $query = mysql_query($sql);

  $temp =mysql_fetch_array($query);
  echo $retun_json;
   
}
/***********************************************************************************************************************/  
/*
 *返回用户tweet的总数
 */
  function user_tweets_count($username)
  {

  $sql = "select count(*) as t_count from tweets where user_id =  (select id from user_tables where username ='{$username}')";
    
  $query = mysql_query($sql);

  $counts =mysql_fetch_array($query);

  return $counts["t_count"];

  }

/************************************************************************************************************************/  

/*
 *返回用户的追随者总数
 */
 function user_following_count($username)
    {
      // code...
      $sql = "select count(*) as u_count from follow_tables where follow_user_id =  (select id from user_tables where username ='{$username}')";
       $query = mysql_query($sql);
      $counts =mysql_fetch_array($query);
      return $counts["u_count"];
        
    }


/************************************************************************************************************************/  
/*
 *返回用户关注者总数
 */
  
    function user_follower_count($username)
    {
      // code...
      $sql = "select count(*) as u_count from follow_tables where user_id =  (select id from user_tables where username ='{$username}')";
       $query = mysql_query($sql);
      $counts =mysql_fetch_array($query);
      return $counts["u_count"];
        
    }

/************************************************************************************************************************/  
    /*
     *返回用户的资料
     */
    
      function user_info($username)
      {

        $sql = "select id,username ,fullname,icon,user_desc from user_tables where username = '{$username}'";
        $return = mysql_query($sql);
        if(!$return) 
          return;
        return mysql_fetch_array($return);

      }
/************************************************************************************************************************/  
//为当前用户增加一条tweets收藏
function add_fav_tweet($tweet_id){  
  $user_id = $_SESSION["id"];

    $sql = "insert into tweet_fav(user_id,tweet_id)  values('".$user_id."','".$tweet_id."')";
    $return = mysql_query($sql);
    $return_var["code"] = $return?1:0; 
    echo return_var;
}
/************************************************************************************************************************/  

//为当前登录用户增加去掉一条微波收藏
function remove_fav_tweet($tweet_id){  
  $user_id = $_SESSION["id"];

    $sql = "delete from tweet_fav where {$user_id} = user_id and tweet_id = {$tweet_id}";
    $return = mysql_query($sql);
    $return_var["code"] = $return?1:0; 
    echo return_var;
}

/************************************************************************************************************************/  
   //判断用户是否已经收藏某条tweet
     function is_fav($tweet_id) 
     {
       $user_id = $_SESSION['id'];
       $sql= "select count(*) as fav_count from tweet_fav where user_id= {$user_id } and tweet_id={$tweet_id}";    
       $query = mysql_query($sql);
       /*if($query == false)*/
         /*return;*/
       $result = mysql_fetch_array($query);
       if($result["fav_count"] == 1)  
            return true; 
       else
          return false;     
       } 
     
/************************************************************************************************************************/  
?>
