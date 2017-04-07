<?php
	
	$configs = include('../config/config.php');
	 include("../includes/githubServices.php");
  	$githubAuthUrl = "https://github.com/login/oauth/authorize?client_id=".$configs->OAUTH2_CLIENT_ID."&scope=user&redirect_uri=".$configs->redirect_uri."&state=".hash('sha256', microtime(TRUE).rand().$_SERVER['REMOTE_ADDR']);

  	if(get('code')) {

  		$userservices = new githubServices();
  		 $access_token=$userservices->getAccessToken(get('code'),$configs->OAUTH2_CLIENT_ID, $configs->OAUTH2_CLIENT_SECRET);
    	echo  $access_token ;
    	

 
  	}
  	else{
  		header('Location: '.$githubAuthUrl);
  	}


	

function get($key, $default=NULL) {
  return array_key_exists($key, $_GET) ? $_GET[$key] : $default;
}



?>