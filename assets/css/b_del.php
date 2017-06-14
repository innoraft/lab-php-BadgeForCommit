<?php

session_start();
$a=$_POST['cid'];
$b=$_POST['bid'];
$c=$_SESSION['user'];
$d=date('Y-m-d H:i:s');
// $id=$_POST['aid'];
// // echo $id;
// // echo $a;

$configs = include('../config/config.php');
$db =mysqli_connect("$configs->host","$configs->username","$configs->pass","$configs->database"); 
$query1="SELECT * FROM t_commit_review WHERE commit_reviewer_id='".$c."' AND badge_id='".$b."'  AND commit_id='".$a."'";
				        $res = $db->query($query1);
				        $num= $res->num_rows;

if($num>=1){
	$sql="DELETE FROM t_commit_review WHERE commit_reviewer_id='".$c."' AND badge_id='".$b."'  AND commit_id='".$a."'";
}
?>