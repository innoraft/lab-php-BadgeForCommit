<?php

session_start();

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
    	session_start();
        $_SESSION['token']=$token;
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

    function getuserrepos($user){
        // echo $user;
        
         $ch=curl_init();
         $url="https://api.github.com/user/repos?access_token=$user";
        curl_setopt($ch,CURLOPT_URL,$url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array("Accept:application/vnd.github.mercy-preview+json",
             "Content-Type: text/plain",
            "User-Agent: Mozilla/5.0 (Windows NT 6.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/47.0.2526.111 YaBrowser/16.3.0.7146 Yowser/2.5 Safari/537.36"
            ));
         curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
         $output=curl_exec($ch);
         return $output;
    }


    function getusercommits($user,$token){
       
        $sha=array();
        $link=array();
        $author=array();
        $i=0;
    for($j=0;$j<sizeof($user);$j++){
        
        $ch=curl_init();
        $url="$user[$j]/commits?access_token=$token";
        curl_setopt($ch,CURLOPT_URL,$url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
             "Content-Type: text/plain",
            "User-Agent: Mozilla/5.0 (Windows NT 6.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/47.0.2526.111 YaBrowser/16.3.0.7146 Yowser/2.5 Safari/537.36",
            
            ));
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);

        $output=curl_exec($ch);
        // echo $output;

       
        $commit_sha= json_decode($output,true);
        foreach ($commit_sha as $key => $value) {
            
            
            $sha[$i]= $value['sha'];
            $link[$i]=$value['html_url'];
            $author[$i]=$value['author']['login'];
                     
      
        $i++; 
        }
     }
     ?>
    <form action ="submit.php" method="post">
        <?php 
        for($k=0;$k<sizeof($sha);$k++) {
            if($_SESSION['user']==$author[$k])
            {
        ?>            
        <input type="checkbox" name="chk1[]" value ="<?php echo  $sha[$k] ?>"><?php echo  $sha[$k];  echo "<a href=".$link[$k].">.....link</a>"; ?><br>
        <?php  
        }     
        }
        ?>

        <input type="submit" name="Submit" value="Submit">
        </form>
        <?php    
    
}
}
?>


