<?php

   

 session_start();
	$configs = include('../config/config.php');
	include("../includes/githubServices.php");
  include("../includes/databaseservices.php");
  
  if(!isset($_SESSION['uid'])){ 
   $githubAuthUrl = "https://github.com/login/oauth/authorize?client_id=".$configs->OAUTH2_CLIENT_ID."&scope=repo&redirect_uri=".$configs->redirect_uri."&state=".hash('sha256', microtime(TRUE).rand().$_SERVER['REMOTE_ADDR']);
   

 
  
            	if(get('code')) {
                
                // echo $_SESSION['uid'];
                  		$userservices = new githubServices();
                  		$access_token=$userservices->getAccessToken(get('code'));
                      $_SESSION['token']=$access_token;
                      // echo $access_token;
                      session_start();
                      $_SESSION['uid']=strtotime("now");
                    	$userinfo=$userservices->getUserInfo($access_token);
                      $db_service= new DatabaseServices();
                    	$display=$db_service->insertuserinfo($userinfo);
                      // echo $display;
                 
            	}
            	else{
            		      header('Location: '.$githubAuthUrl);
            	}
 }
 else{
  header('Location:home.php');
 } 


//  $_SESSION['start'] = time(); 
//  $_SESSION['expire'] = $_SESSION['start'] + (30 * 60);



// if (!isset($_SESSION['token'])) {
//         echo "Please Login again";
//         echo "<a href='http://badgethecommit.local/index.php'>Click Here to Login</a>";
//  }
// else {
//         $now = time(); 

//         if ($now > $_SESSION['expire']) {
//             session_destroy();
//             echo "Your session has expired! <a href='http://badgethecommit.local/index.php'>Login here</a>";
//         }
//       }


	

function get($key, $default=NULL) {
  return array_key_exists($key, $_GET) ? $_GET[$key] : $default;
}



?>