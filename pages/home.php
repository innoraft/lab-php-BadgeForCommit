<!DOCTYPE html>
<html>
<head>
<link href="../assets/bootstrap/css/bootstrap.min.css" rel="stylesheet"> 
<link href="../assets/css/stylesheet.css" rel="stylesheet">
	<title>home page</title>
</head>
<body>




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
					 $query="SELECT * FROM t_users WHERE user_github_id='".$_SESSION['user']."'";
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
									?>
									<div class="container body1">
									<div class="col-sm-10 col-sm-offset-1">
									<div style="border:1px solid black;text-align: center;">
									 <h3> LATEST SUMMARY</h3>
							             <?php $dash=new DatabaseServices();
							            $dash->getdisplay();?>
							        </div>
							        </div>
							        </div>

							            <?php

									

					}

					else{	
						header('Location:logout.php');
					}







}
else{
	header('Location:login.php');
}

?>

<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<script src="../assets/bootstrap/js/bootstrap.min.js"></script>
</body>
</html>