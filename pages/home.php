<?php
session_start();

 include("../includes/githubServices.php");
 include("../includes/databaseservices.php");


 $repo= new githubServices();
 $userrepos=$repo->getuserrepos($_SESSION['token']);

// $configs = include('/config/config.php');

$list=array();
$i=0;
$repos= json_decode($userrepos,true);
foreach($repos as $key => $value){
$list[$i]=$value['url'];

$i++;
}

$commits= new githubServices();
for($i=0;$i<count($list);$i++){
$usercommits=$commits->getusercommits($list[$i],$_SESSION['token']);
}


?>

<form action ="submit.php" method="post">
<?php 
foreach ($rep as $key => $value) {	
			
			?>
			
			<input type="checkbox" name="chk1[]" value ="<?php echo $value['commits_url'] ?>"><?php echo $value['commits_url']; echo "<a href=".$value['html_url'].">.....link</a>"; ?><br>
<?php		
}
?>

			<input type="submit" name="Submit" value="Submit">
			</form>
			<?php


// $commithash=new DatabaseServices();
// $commithash->insertcommithash($usercommits);




// if (!isset($_SESSION['user'])) {
//         echo "Please Login again";
 //        echo "<a href='http://badgethecommit.local/index.php'>Click Here to Login</a>";
 // }
// else {
//         $now = time(); 

//         if ($now > $_SESSION['expire']) {
//             session_destroy();
//             echo "Your session has expired! <a href='http://badgethecommit.local/index.php'>Login here</a>";
//         }

?>