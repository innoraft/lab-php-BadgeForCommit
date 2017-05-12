

<?php
$link = new mysqli( 'localhost', 'root', '123', 'db_badge' );
if ( $link->connect_errno ) {
 die( "Failed to connect to MySQL: (" . $link->connect_errno . ") " . $link->connect_error );
}

// Fetch the data
$query = "SELECT commit_id, COUNT(*) as c from t_commit_review group by commit_id order by c DESC
LIMIT 5";
$result = $link->query( $query );


if ( !$result ) {
 $message  = 'Invalid query: ' . $link->error . "n";
 $message  = 'Whole query: ' . $query;
 die( $message );
}


$c=array();
$i=0;
$b=array();
$data = array();
// Print out rows
while ($row = $result->fetch_assoc()) {
 $data[] = $row;
}
// print_r($data);echo "<br>";
foreach ($data as $key => $value) {
	// print_r($value);echo "<br>";
	$query1= "SELECT commit_author,commit_messg FROM t_commits WHERE commit_id= '".$value['commit_id']."'";
	$res = $link->query( $query1);
	while($row1 =$res->fetch_assoc()){
		// echo $value['c'];
		$row1['badge_sum']=$value['c'];
		// $row1++=$value['c'];
		// print_r($row1);echo"<br>";
	$b= json_encode($row1,true);
 // print_r($b);
	// $b=array_push($b,$value['c']);
	// print_r($b); echo "<br>";

	
}
$c[$i]=$b;
$i++;
	// echo $res;
}
// while($row1 =$res->fetch_assoc()){
// 	$b= $row1;
// }
print_r($c);




?>