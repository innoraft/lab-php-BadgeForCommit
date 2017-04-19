<?php
session_start();

 include("../includes/githubServices.php");
 include("../includes/databaseservices.php");
 $listrepo=array();
 $index=1;
 $flag=true;
 $repo= new githubServices();
 // $userrepos=$repo->getuserrepos($index,$_SESSION['token']);
 // $listrepo=$userrepos;
 // echo $userrepos;
 while($flag) {
 	$userrepos=$repo->getuserrepos($index,$_SESSION['token']);
 	$repolist= json_decode($userrepos,true);
 	$index=$index+1;
 	array_push($listrepo,$userrepos);
 	empty($repolist)?$flag=false:$flag=true;		
 }
 // print_r($listrepo);
 // $r=json_encode($listrepo,true);
 	
 


// $configs = include('/config/config.php');

$list=array();
$i=0;
// echo $listrepo[0];
// echo count($listrepo);
// $repos= json_decode($r,true);
$j=0;
while($j<sizeof($listrepo)){
	$repos=json_decode($listrepo[$j],true);
foreach($repos as $key => $value){


	$list[$i]=$value['url'];
	
	$i++;
}
$j++;
}
// echo $list[1];
// echo $list[2];

$commits= new githubServices();
// for($i=0;$i<count($list);$i++){
$usercommits=$commits->getusercommits($list,$_SESSION['token']);





// $commithash=new DatabaseServices();
// $commithash->insertcommithash($usercommits);




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
