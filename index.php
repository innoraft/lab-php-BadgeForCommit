<?php
session_start();

$configs = include('config/config.php');
$_SESSION['server']=$configs->server;
$con = new mysqli("$configs->host","$configs->username","$configs->pass");
if ($con->connect_error) {
    die("Connection failed: " . $con->connect_error);
} 
//change the db_name accordingly
$sql = "CREATE DATABASE $configs->database";
if ($con->query($sql) === TRUE) {
    echo "Database created successfully";
    header('Location:'.$_SESSION['server'].'database_setup.php');
} else {
     header('Location:'.$_SESSION['server'].'pages/login.php');
}
  // header('Location: /pages/login.php');
 ?>