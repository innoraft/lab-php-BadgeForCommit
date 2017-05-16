 <link href="../assets/css/stylesheet.css" rel="stylesheet">
<?php
		session_start();
		class DatabaseServices {

		     function insertuserinfo($output) {
		     	
				$configs = include('../config/config.php');
		        $db =mysqli_connect("$configs->host","$configs->username","$configs->pass","$configs->database");        
		        $data = json_decode($output, true);        
		        $login=$data["login"];
		        $email=$data["email"];
		        $id=2;

		        $query1="SELECT * FROM t_users WHERE user_github_id='".$login."' AND user_email='".$email."'";

				$res = $db->query($query1);
				$num= $res->num_rows;
					 $_SESSION['user'] = $login;
			 

				if ($num >=1)

				{
					$query3="UPDATE t_users SET user_session_id='".$_SESSION['uid']."' WHERE user_github_id='".$_SESSION['user']."'";
		            $res1=  $db->query($query3);
			        header('Location: http://badgethecommit.local/pages/home.php');
				}
				else {  
		        $sql= "INSERT INTO t_users(user_email,user_session_id,user_github_id,user_role_id) VALUES('$email','".$_SESSION['uid']."','$login','$id')";
		        mysqli_query($db,$sql);
		        echo "connected";
		        header('Location: http://badgethecommit.local/pages/home.php');
		        mysqli_close($db);
		    	}
			}


			



			function newbadge(){
				$configs = include('../config/config.php');
		        $db =mysqli_connect("$configs->host","$configs->username","$configs->pass","$configs->database"); 
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
				  return 0;
				  // header('Location:../pages/main.php');
			}


			function badge_analysis(){
				$db=mysqli_connect("localhost","root","123","db_badge");

			}






		 }
 ?>
