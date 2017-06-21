<?php
require("/var/www/html/badgethecommit/includes/class.phpmailer.php");
$configs = include('/var/www/html/badgethecommit/config/config.php');

// replace the db_credentials from the line below with  your db credentials
$db =mysqli_connect("$configs->host","$configs->username","$configs->pass","$configs->database"); 


$query = "SELECT commit_id, COUNT(*) as c from t_commit_review group by commit_id order by c DESC
LIMIT 5";
$result = $db->query( $query );
$c=array();
$i=1;
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
		$message.='<div style="margin-left:50px;margin-right:50px;padding-left:10px; padding-right:10px;"><div style="margin-bottom: 20px;background-color: #fff;border: 1px solid transparent; border-radius: 4px; border-color: grey;"><div style=" padding: 10px 15px; border-bottom: 1px solid transparent;background-color:rgba(0,0,0,0.3);color:white;  border-top-left-radius: 3px;border-top-right-radius: 3px;border-color: grey;text-align:center;"><b>MOST RATED.....RANK '.$i.'</b></div><div style="padding: 15px;"><p>Commiter_name: '.$row1['commit_author'].'</p><p>Commit_message: '.$row1['commit_messg'].'</p><p>Badges received: '.$row1['badge_sum'].'</p></div></div></div>';
		// $row1++=$value['c'];
		// print_r($row1);echo"<br>";
	// $b= json_encode($row1,true);
}// $c[$i]=$b;
$i++;
	// echo $res;
}


// echo $message;



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

$mail->Subject = "Badge the commit: Top 5 Rated Commits of the week";
$mail->Body    = $message;
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