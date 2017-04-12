<?php



class githubServices {

	
    function getAccessToken( $request_code) {
	    $configs = include('../config/config.php');
	    $ch = curl_init(); 
	    $url="https://github.com/login/oauth/access_token?code=".$request_code."&client_id=".$configs->OAUTH2_CLIENT_ID."&client_secret=".$configs->OAUTH2_CLIENT_SECRET; 
	 
	    curl_setopt($ch,CURLOPT_URL,$url);
	    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Accept: application/json'));
	    curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);

	 	$output=curl_exec($ch);
			
		$a=json_decode($output);
	 	// echo $a->access_token;
	   	$b=$a->access_token;

	    curl_close($ch);
	    return $b;
    }

    function getUserInfo($token) {

    	$ch=curl_init();
    	

    	$url="https://api.github.com/user?access_token=".$token;
    	curl_setopt($ch,CURLOPT_URL,$url);
    	curl_setopt($ch, CURLOPT_HTTPHEADER,array(
            "Accept: application/vnd.github.v3+json",
            "Content-Type: text/plain",
            "User-Agent: Mozilla/5.0 (Windows NT 6.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/47.0.2526.111 YaBrowser/16.3.0.7146 Yowser/2.5 Safari/537.36"
        ));
    	curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
    	$output=curl_exec($ch);
		
        // echo $output;
	    curl_close($ch);
        return $output;
	    }


    function getusercommits($user){
    
        $ch=curl_init();
        $url="https://api.github.com/search/commits?q=author:".$user . "&type=Commits";
        curl_setopt($ch,CURLOPT_URL,$url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array("Accept:application/vnd.github.cloak-preview",
             "Content-Type: text/plain",
            "User-Agent: Mozilla/5.0 (Windows NT 6.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/47.0.2526.111 YaBrowser/16.3.0.7146 Yowser/2.5 Safari/537.36"
            ));
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);

        $output=curl_exec($ch);
        return $output;
            
    }
}









?>