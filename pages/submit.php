<?php
include("../includes/githubServices.php");
// header('location:login.php');
session_start();
$a=$_POST['cid'];
$b=$_POST['did'];
$c=$_POST['eid'];
$d=urldecode($_POST['fid']);
$e=$_POST['gid'];
$repo=$_POST['rid'];
$code_url=new githubServices();
$url=$code_url->raw_url($e);
$loc=json_decode($url,true);
$array=array();
foreach ($loc['files'] as $key => $value) {
	$g=$value['patch'];
	$array[]=$g;
}
$h=implode("=>",$array);
$base_64=base64_encode($h);


$configs = include('../config/config.php');
$db =mysqli_connect("$configs->host","$configs->username","$configs->pass","$configs->database"); 
$query1="SELECT * FROM t_commits WHERE commit_git_hash='".$a."'";
				        $res = $db->query($query1);
				        $num= $res->num_rows;
				        if($num>=1){
				        	// echo "$a already exists";
				        	$sql= "DELETE FROM t_commits WHERE commit_git_hash='".$a."'";
				        }
				        else{
						$sql= "INSERT INTO t_commits(commit_git_hash,commit_author,commit_link,commit_messg,commit_code,commit_repo) VALUES('$a','$b','$c','$d','$base_64','$repo')";
}
mysqli_query($db,$sql);
mysqli_close($db);
?>