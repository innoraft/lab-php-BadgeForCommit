<link href="../assets/bootstrap/css/bootstrap.min.css" rel="stylesheet"> 
<link href="../assets/css/stylesheet.css" rel="stylesheet">

<?php
include("../includes/githubServices.php");
include("../includes/databaseservices.php");
session_start();

$_SESSION['next']++;
// echo $_SESSION['next'];
$commits=new githubServices();
$commitslist=$commits->getcommits($_SESSION['token']);