
<?php
		session_start();
		class DatabaseServices {

		     function insertuserinfo($output) {
		     	
				
		        $db =mysqli_connect("localhost","root","123","db_badge");        
		        $data = json_decode($output, true);        
		        $login=$data["login"];
		        $email=$data["email"];

		        $query1="SELECT * FROM t_users WHERE user_id='".$login."' AND user_email='".$email."'";

				$res = $db->query($query1);
				$num= $res->num_rows;
					 $_SESSION['user'] = $login;
			         $_SESSION['start'] = time(); 
			         $_SESSION['expire'] = $_SESSION['start'] + (30 * 60);

				if ($num >=1)

				{
				    
			         echo "<a href='http://badgethecommit.local/pages/home.php'>Click Here See Your Commits</a>";
			         // header('Location: http://badgethecommit.local/pages/home.php');
				}
				else {  
		        $sql= "INSERT INTO t_users(user_id,user_email) VALUES('$login','$email')";
		        mysqli_query($db,$sql);
		        echo "connected";
		        echo "<a href='http://badgethecommit.local/pages/home.php'>Click Here See Your Commits</a>";
		        mysqli_close($db);
		    	}
			}


			



			// function insertcommithash(){

			// 	$db=mysqli_connect("localhost","root","123","db_badge");
			// 	$checkbox1= $_POST['chk1'];
			// 	if(isset($_POST['Submit']))
			// 	{
			// 		for($i=0;$i<sizeof($checkbox1);$i++){
			// 			$query="INSERT INTO t_commits(commit_git_hash) VALUES('".$checkbox1[$i]."')";
			// 			mysqli_query($db,$query);
			// 		}
			// 		echo "inserted";
					
			// 	}

			// 	$db=mysqli_connect("localhost","root","123","db_badge");
			// 	$commitsha= json_decode($usercommits,true);
			// 	foreach ($commitsha['items'] as $key => $value) {
			// 		$sha=$value['sha'];	
			// 		echo $value['sha'];
			// 		$query2="SELECT *FROM t_commits WHERE commit_git_hash='".$sha."'";
			// 		$res = $db->query($query2);
			// 		$num= $res->num_rows;
			// 		if($num>=1)
			// 		{
			// 			echo "commit already exists";
			// 		}
			// 		else{
					
		 //       			 $sql= "INSERT INTO t_commits(commit_git_hash) VALUES('$sha')";
		 //       			 mysqli_query($db,$sql);
		 //       			 echo "inserted";					
			// 		}
			// 	}

			// }
			function newbadge(){
				$db=mysqli_connect("localhost","root","123","db_badge");
				$badge_id=array("1","2","3");
				$badge_name=array("golden_badge","silver_badge","copper_badge");
				$badge_icon=array("../assets/images/gold.png","../assets/images/silver.png","../assets/images/copper.png");
				$badge_author=array("harpreet16","harpreet16","harpreet16");
				$badge_desc=array("highly efficient","helpul commit","satisfactory");
				for($i=0;$i<sizeof($badge_id);$i++){
				$query1="SELECT * FROM t_badge WHERE badge_id='".$badge_id[$i]."'";
					$res = $db->query($query1);
					$num= $res->num_rows;
				    if($num>=1){
						echo "already exists";
					}
					else{
						$sql= "INSERT INTO t_badge(	badge_id,badge_name,badge_icon,	badge_author,badge_desc) VALUES('$badge_id[$i]','$badge_name[$i]','$badge_icon[$i]','$badge_author[$i]','$badge_desc[$i]')";
						mysqli_query($db,$sql);
					}
				}
				  mysqli_close($db);
				  echo "inserted";
				  header('Location:../pages/main.php');
			}






		 }
 ?>
