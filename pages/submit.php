<?php
// echo "entered";
// include("../includes/githubServices.php");
$configs = include('../config/config.php');
// header('location:login.php');
session_start();
$a=$_POST['cid'];
$b=$_POST['did'];
$c=$_POST['eid'];
$d=urldecode($_POST['fid']);
$e=$_POST['gid'];
$repo=$_POST['rid'];
		$ch=curl_init();
        $url=$e."?access_token=".$_SESSION['token'];
        curl_setopt($ch,CURLOPT_URL,$url);
        curl_setopt($ch, CURLOPT_HTTPHEADER,array(
            "Accept: application/vnd.github.v3+json",
            "Content-Type: text/plain",
            "User-Agent: Mozilla/5.0 (Windows NT 6.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/47.0.2526.111 YaBrowser/16.3.0.7146 Yowser/2.5 Safari/537.36"
           

        ));
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
        $url1=curl_exec($ch);
        
       
        curl_close($ch);
        // return $output;
// $code_url=new githubServices();
// $url=$code_url->raw_url($e);
$loc=json_decode($url1,true);
$array=array();
foreach ($loc['files'] as $key => $value) {
	$g=$value['patch'];
	$array[]=$g;
}
$h=implode("=>",$array);
$base_64=base64_encode($h);



$db =mysqli_connect("$configs->host","$configs->username","$configs->pass","$configs->database"); 
$query1="SELECT * FROM t_commits WHERE commit_git_hash='".$a."'";
				        $res = $db->query($query1);
				        $num= $res->num_rows;
				        if($num>=1){
				        	// echo "$a already exists";
				        	$sql= "DELETE FROM t_commits WHERE commit_git_hash='".$a."'";
				        	echo "entered";
				        }
				        else{
						$sql= "INSERT INTO t_commits(commit_git_hash,commit_author,commit_link,commit_messg,commit_code,commit_repo) VALUES('$a','$b','$c','$d','$base_64','$repo')";
						echo "entered";
						}
mysqli_query($db,$sql);
mysqli_close($db);

?>