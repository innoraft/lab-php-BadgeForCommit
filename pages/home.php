<?php
include("../includes/githubServices.php");
include("../includes/databaseservices.php");
session_start();
// echo $_SESSION['token'];
$_SESSION['next']=1;
if(isset($_SESSION['uid']))
{
					 $array= array();
					 $db =mysqli_connect("localhost","root","123","db_badge");
					 $query="SELECT user_session_id FROM t_users WHERE user_github_id='".$_SESSION['user']."'";
					 $res=  $db->query($query);

					 while( $array = mysqli_fetch_array($res) ){
					 	$stamp=$array['user_session_id'];

					 }
					 
					 if($_SESSION['uid']=$stamp)
					 {
									 
									$commits=new githubServices();
									$commitslist=$commits->getcommits($_SESSION['token']);
									

					}

					else{	
						header('Location:http://badgethecommit.local/pages/logout.php');
					}






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
}
else{
	header('Location:http://badgethecommit.local/pages/login.php');
}

?>
