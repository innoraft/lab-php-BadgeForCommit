<?php
	include("../includes/githubServices.php");
    session_start();
 if(isset($_SESSION['uid'])){
         $configs = include('../config/config.php');
		 $db =mysqli_connect("$configs->host","$configs->username","$configs->pass","$configs->database"); 
		 $query="UPDATE t_users SET user_session_id=NULL WHERE user_github_id='".$_SESSION['user']."'";
		 $res=  $db->query($query);
		// $delauth=new githubServices();
		// $delauth->deleteauth();

    session_unset();
    session_destroy();
    header('Location:http://badgethecommit.local/index.php');
}
else{
	header('Location:login.php');
}
?>