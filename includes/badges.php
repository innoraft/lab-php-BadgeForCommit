<?php
session_start();
$a=$_POST['cid'];
$b=$_POST['bid'];
$c=$_SESSION['user'];
$d=date('Y-m-d H:i:s');
$db=mysqli_connect("localhost","root","123","db_badge");
$sql= "INSERT INTO t_commit_review(commit_id,badge_id,commit_reviewer_id,commit_review_created) VALUES('$a','$b','$c','$d')";
mysqli_query($db,$sql);

 mysqli_close($db);
 

?>