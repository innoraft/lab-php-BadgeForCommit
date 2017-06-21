

<?php
$id=array();
$configs = include('../config/config.php');
$db =mysqli_connect("$configs->host","$configs->username","$configs->pass","$configs->database"); 
$query = "SELECT commit_id, COUNT(*) as c from t_commit_review group by commit_id order by c DESC
				LIMIT 5";
$result = $db->query( $query );
while($row=$result->fetch_assoc()){
	// print_r($row);
	// echo $row['commit_id']; echo "<br>";
	$id= $row['commit_id'];echo "<br>"

	// $q="SELECT count(*) as b from t_commits group by commit_repo where commit_id='".$row['commit_id']."'";
	// $res1=$db->query($q);
	// while($row1=$res1->fetch_assoc()){
	// 	print_r($row1);
	// }

}


?>
