<?php
require("/var/www/html/badgethecommit/includes/class.phpmailer.php");
$configs = include('/var/www/html/badgethecommit/config/config.php');

// replace the db_credentials from the line below with  your db credentials
$db =mysqli_connect("$configs->host","$configs->username","$configs->pass","$configs->database"); 


$query = "SELECT commit_id, COUNT(*) as c from t_commit_review group by commit_id order by c DESC
LIMIT 5";
$result = $db->query( $query );
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
	$res = $db->query( $query1);
	while($row1 =$res->fetch_assoc()){
		// echo $value['c'];
		$row1['badge_sum']=$value['c'];
		// $row1++=$value['c'];
		// print_r($row1);echo"<br>";
	$b= json_encode($row1,true);
}
$c[$i]=$b;
$i++;
	// echo $res;
}

print_r($c);



//sending emails
$mail = new PHPMailer();

// $mail->IsSMTP();                                      // set mailer to use SMTP
// $mail->Host = "mail.example.com;mail2.example.com";  // specify main and backup server
// $mail->SMTPAuth = true;     // turn on SMTP authentication
// $mail->Username = "jswan";  // SMTP username
// $mail->Password = "secret"; // SMTP password
$query2="SELECT user_email from t_users";
$res2=$db->query($query2);
while ($row2 = $res2->fetch_assoc()) {
	// echo"<br>";
 // echo $row2['user_email'];

$mail->From = "harpreet.kaur@gmail.com";
$mail->FromName = "harpreet";
$mail->AddAddress($row2['user_email']);
$mail->AddAddress($row2['user_email']);                  // name is optional
// $mail->AddReplyTo("info@example.com", "Information");
$mail->IsHTML(true);   

$mail->Subject = "SUMMARY OF MOST RATED COMMITS";
$mail->Body    = "$c";
$mail->AltBody = "This is the body in plain text for non-HTML mail clients";

if(!$mail->Send())
{
   echo "Message could not be sent. <p>";
   echo "Mailer Error: " . $mail->ErrorInfo;
   // exit;
}

echo "Message has been sent";
}


mysqli_close($db);




?>