
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
		 }
 ?>
