<?php
include("../includes/githubServices.php");
include("../includes/databaseservices.php");
 $configs = include('../config/config.php');
session_start();
// echo $_SESSION['token'];
$_SESSION['next']=1;
if(isset($_SESSION['uid']))
{
					 $array= array();
					
		             $db =mysqli_connect("$configs->host","$configs->username","$configs->pass","$configs->database");
					 $query="SELECT user_session_id FROM t_users WHERE user_github_id='".$_SESSION['user']."'";
					 $res=  $db->query($query);

					 while( $array = mysqli_fetch_array($res) ){
					 	$stamp=$array['user_session_id'];
					 	$mail=$array['user_email'];

					 }
					 
					 if($_SESSION['uid']=$stamp)
					 {
									if(empty($mail)){
										$message = "PLEASE MAKE YOUR EMAIL_ID ON GITHUB ACCOUNT PUBLIC TO RECEIVE WEEKLY NOTIFICATIONS....IGNORE IF ALREADY SET";
										echo "<script type='text/javascript'>alert('$message');</script>";
									} 
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

<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
