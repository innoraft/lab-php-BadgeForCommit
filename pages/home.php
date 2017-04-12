<?php
session_start();

 include("../includes/githubServices.php");
 include("../includes/databaseservices.php");

// $configs = include('/config/config.php');
$commits= new githubServices();
$usercommits=$commits->getusercommits($_SESSION['user']);
$commitsha= json_decode($usercommits,true);
foreach ($commitsha['items'] as $key => $value) {	
			echo $value['sha'];
			echo "<a href=".$value['html_url'].">.....link</a>";?><br><?php

}

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