<?php
$configs = include('config/config.php');
$con = new mysqli("$configs->host","$configs->username","$configs->pass");
if ($con->connect_error) {
    die("Connection failed: " . $con->connect_error);
} 
//change the db_name accordingly
$sql = "CREATE DATABASE $configs->database";
if ($con->query($sql) === TRUE) {
    echo "Database created successfully";
    header('Location:database_setup.php');
} else {
     header('Location: /pages/login.php');
}
  // header('Location: /pages/login.php');
 ?>