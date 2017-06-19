<link href="../assets/bootstrap/css/bootstrap.min.css" rel="stylesheet"> 
<link href="../assets/css/style.css" rel="stylesheet">

<?php
include("../includes/githubServices.php");
include("../includes/databaseservices.php");
session_start();

$_SESSION['next']--;
// echo $_SESSION['next'];
$commits=new githubServices();
$commitslist=$commits->getcommits($_SESSION['token']);
if($_SESSION['next']!=1){?>
<form  class="nex1" action="../pages/previous.php" method="post">
<input type="submit" name="prepage" value="PREV PAGE">
</form><?php
}

?>
