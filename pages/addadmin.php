<?php
session_start();
$configs = include('../config/config.php');
$db =mysqli_connect("$configs->host","$configs->username","$configs->pass","$configs->database");
$id=$_POST['cid'];
$query3="UPDATE t_users SET user_role_id=1 WHERE user_github_id='".$id."'";
$db->query($query3);

?>