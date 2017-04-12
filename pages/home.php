<?php
session_start();

 include("../includes/githubServices.php");

// $configs = include('/config/config.php');
$commits= new githubservices();
$usercommits=$commits->getusercommits($_SESSION['user']);
echo $usercommits;

// if (!isset($_SESSION['user'])) {
//         echo "Please Login again";
//         echo "<a href='http://badgethecommit.local/index.php'>Click Here to Login</a>";
//  }
// else {
//         $now = time(); 

//         if ($now > $_SESSION['expire']) {
//             session_destroy();
//             echo "Your session has expired! <a href='http://badgethecommit.local/index.php'>Login here</a>";
//         }

?>