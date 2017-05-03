<?php
header('location:login.php');
session_start();
$a=$_POST['cid'];
$b=$_POST['did'];
$c=$_POST['eid'];
$d=urldecode($_POST['fid']);
$db=mysqli_connect("localhost","root","123","db_badge");
$query1="SELECT * FROM t_commits WHERE commit_git_hash='".$a."'";
				        $res = $db->query($query1);
				        $num= $res->num_rows;
				        if($num>=1){
				        	// echo "$a already exists";
				        	$sql= "DELETE FROM t_commits WHERE commit_git_hash='".$a."'";
				        }
				        else{
						$sql= "INSERT INTO t_commits(commit_git_hash,commit_author,commit_link,commit_messg) VALUES('$a','$b','$c','$d')";
}
mysqli_query($db,$sql);
mysqli_close($db);
?>