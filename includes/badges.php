<?php
session_start();
$a=$_POST['cid'];
$b=$_POST['bid'];
$c=$_SESSION['user'];
$d=date('Y-m-d H:i:s');
$id=$_POST['aid'];
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
else{
$sql= "INSERT INTO t_commit_review(commit_id,badge_id,commit_reviewer_id,commit_review_created) VALUES('$a','$b','$c','$d')";
}

mysqli_query($db,$sql);



$data=array();
$query="SELECT badge_id, count( * ) AS c
						FROM t_commit_review
						WHERE commit_id ='".$a."' AND commit_reviewer_id='".$c."'
						GROUP BY badge_id";
		        $result=$db->query($query);
                if($result->num_rows!=0){ 
					 while ($row = $result->fetch_assoc()) 
					 {
					 	// print_r($row);
						$q="SELECT badge_name from t_badge where badge_id='".$row['badge_id']."'";
						$res=$db->query($q);
						while($r=$res->fetch_assoc())
						{
							$data[$r['badge_name']]=$row['c'] ;
						}
										 // $data[] = $row;
					}
				}

// print_r($data);
 mysqli_close($db);
 $t= json_encode($data);
 echo json_encode(array("a" => $id, "b" => $t));
 // return(1);
 

?>