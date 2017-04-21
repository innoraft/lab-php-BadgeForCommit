<?php
session_start();

 include("../includes/githubServices.php");
 include("../includes/databaseservices.php");
 $listrepo=array();
 $index=1;
 $flag=true;
 $repo= new githubServices();
 
 while($flag) {
 	$userrepos=$repo->getuserrepos($index,$_SESSION['token']);
 	$repolist= json_decode($userrepos,true);
 	$index=$index+1;
 	array_push($listrepo,$userrepos);
 	empty($repolist)?$flag=false:$flag=true;		
 }
 
$list=array();
$i=0;
$j=0;
while($j<sizeof($listrepo)){
	$repos=json_decode($listrepo[$j],true);
	foreach($repos as $key => $value){
		$list[$i]=$value['url'];	
		$i++;
		}
	$j++;
	}


$commits= new githubServices();
$usercommits=$commits->getusercommits($list,$_SESSION['token']);










// if (!isset($_SESSION['user'])) {
//         echo "Please Login again";
 //        echo "<a href='http://badgethecommit.local/index.php'>Click Here to Login</a>";
 // }
// else {
//         $now = time(); 

//         if ($now > $_SESSION['expire']) {
//             session_destroy();
//             echo "Your session has expired! <a href='http://badgethecommit.local/index.php'>Login here</a>";
//         }

?>
