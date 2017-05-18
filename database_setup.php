<?php
$configs = include('config/config.php');
session_start();
// $con = new mysqli("$configs->host","$configs->username","$configs->pass");
// if ($con->connect_error) {
//     die("Connection failed: " . $con->connect_error);
// } 
// //change the db_name accordingly
// $sql = "CREATE DATABASE $configs->database";
// if ($con->query($sql) === TRUE) {
//     echo "Database created successfully";
// } else {
//     echo "Error creating database: " . $con->error;
// }


$conn=mysqli_connect("$configs->host","$configs->username","$configs->pass","$configs->database"); 


$q1="CREATE TABLE `t_badge`(
  `badge_id` int(20) NOT NULL AUTO_INCREMENT,
  `badge_name` varchar(30) DEFAULT NULL,
  `badge_author` varchar(50) DEFAULT NULL,
  `badge_icon` varchar(50) DEFAULT NULL,
  `badge_desc` varchar(80) DEFAULT NULL,
  PRIMARY KEY (`badge_id`)
)";

if ($conn->query($q1) === TRUE) {
    echo "Table t_badge created successfully";
} else {
    echo "Error creating table: " . $conn->error;
}
$q2="CREATE TABLE `t_commit_review` (
  `commit_review_id` int(20) NOT NULL AUTO_INCREMENT,
  `commit_id` int(20) DEFAULT NULL,
  `commit_reviewer_id` varchar(50) DEFAULT NULL,
  `badge_id` varchar(20) DEFAULT NULL,
  `commit_review_created` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`commit_review_id`)
)";
if ($conn->query($q2) === TRUE) {
    echo "Table t_commit_review created successfully";
} else {
    echo "Error creating table: " . $conn->error;
}
$q3="CREATE TABLE `t_commits` (
  `commit_id` int(20) NOT NULL AUTO_INCREMENT,
  `commit_git_hash` varchar(50) DEFAULT NULL,
  `commit_messg` varchar(50) DEFAULT NULL,
  `commit_author` varchar(50) DEFAULT NULL,
  `commit_link` varchar(80) DEFAULT NULL,
  `commit_code` blob,
  PRIMARY KEY (`commit_id`)
)";
if ($conn->query($q3) === TRUE) {
    echo "Table t_commits created successfully";
} else {
    echo "Error creating table: " . $conn->error;
}
$q4="CREATE TABLE `t_user_role` (
  `user_role_id` int(50) NOT NULL AUTO_INCREMENT,
  `user_role_name` varchar(50) DEFAULT NULL,
  `user_role_desc` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`user_role_id`)
)";
if ($conn->query($q4) === TRUE) {
    echo "Table t_user_role created successfully";
} else {
    echo "Error creating table: " . $conn->error;
}
$q5="CREATE TABLE `t_users` (
  `user_id` int(50) NOT NULL AUTO_INCREMENT,
  `user_session_id` varchar(30) DEFAULT NULL,
  `user_github_id` varchar(50) DEFAULT NULL,
  `user_role_id` varchar(10) DEFAULT NULL,
  `user_email` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`user_id`)
)";
if ($conn->query($q5) === TRUE) {
    echo "Table t_users created successfully";
} else {
    echo "Error creating table: " . $conn->error;
}
$conn->close();
  header('Location:'.$_SESSION['server'].'pages/login.php');


?>