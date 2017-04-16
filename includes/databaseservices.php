
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
		    	}
			}



			function insertcommithash(){

				$db=mysqli_connect("localhost","root","123","db_badge");
				$checkbox1= $_POST['chk1'];
				if(isset($_POST['Submit']))
				{
					for($i=0;$i<sizeof($checkbox1);$i++){
						$query="INSERT INTO t_commits(commit_git_hash) VALUES('".$checkbox1[$i]."')";
						mysqli_query($db,$query);
					}
					echo "inserted";
					
				}

				// $db=mysqli_connect("localhost","root","123","db_badge");
				// $commitsha= json_decode($usercommits,true);
				// foreach ($commitsha['items'] as $key => $value) {
				// 	$sha=$value['sha'];	
				// 	echo $value['sha'];
				// 	$query2="SELECT *FROM t_commits WHERE commit_git_hash='".$sha."'";
				// 	$res = $db->query($query2);
				// 	$num= $res->num_rows;
				// 	if($num>=1)
				// 	{
				// 		echo "commit already exists";
				// 	}
				// 	else{
					
		  //      			 $sql= "INSERT INTO t_commits(commit_git_hash) VALUES('$sha')";
		  //      			 mysqli_query($db,$sql);
		  //      			 echo "inserted";					
				// 	}
				// }

			}






		 }
 ?>
