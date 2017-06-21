<?php
session_start();
$c=$_POST['cid'];
$configs = include('../config/config.php');
$db =mysqli_connect("$configs->host","$configs->username","$configs->pass","$configs->database");
$q="DELETE FROM t_commits WHERE commit_git_hash='".$c."'";
$r=$db->query($q);
		        ?>