<?php

$configs = include('../config/config.php');

class githubServices {

	
    function getAccessToken( $request_code,$client_id, $client_secret) {
    $ch = curl_init(); 
    $url="https://github.com/login/oauth/access_token?code=".$request_code."&client_id=".$client_id."&client_secret=".$client_secret; 
 
    curl_setopt($ch,CURLOPT_URL,$url);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Accept: application/json'));
    curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);

 	$output=curl_exec($ch);
		// header('Content-Type: application/json');
		$a=json_decode($output);
 	echo $a->access_token;
   		// echo json_decode($output);
    curl_close($ch);
    
    // $json= json_decode($output);
    // // echo $json->access_token;
    // echo $json;
 

    // return $output;
    }

    function getUserInfo() {

    }

    function getCommits() {

    }


}

?>