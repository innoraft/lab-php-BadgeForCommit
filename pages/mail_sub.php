
<?php
$configs = include('../config/config.php');
session_start();
if (isset($_POST['name'])) {
$name = strip_tags($_POST['name']);
$email = strip_tags($_POST['email']);
// $message = strip_tags($_POST['message']);
// echo "<strong>Name</strong>: ".$name."</br>";
$db =mysqli_connect("$configs->host","$configs->username","$configs->pass","$configs->database");
$query="UPDATE t_users SET user_email='".$email."' WHERE user_github_id='".$_SESSION['user']."'";
$res=  $db->query($query);

// echo "<strong>Email</strong>: ".$email."</br>";
// echo "<strong>Message</strong>: ".$message."</br>";
// echo "<span class='label label-info'>Your feedback has been submitted with above details!</span>";
}
?>
