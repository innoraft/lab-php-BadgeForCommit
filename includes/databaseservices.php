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
			        header('Location: ../pages/home.php');
				}
				else {  
		        $sql= "INSERT INTO t_users(user_email,user_session_id,user_github_id,user_role_id) VALUES('$email','".$_SESSION['uid']."','$login','$id')";
		        mysqli_query($db,$sql);
		        echo "connected";
		        header('Location: ../pages/home.php');
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
			}


			function b_dashboard($id){
				$data=array();
				$list=array();
				$configs = include('../config/config.php');
		        $db =mysqli_connect("$configs->host","$configs->username","$configs->pass","$configs->database"); 
		        $query="SELECT badge_id, count( * ) AS c
						FROM t_commit_review
						WHERE commit_id ='".$id."'
						GROUP BY badge_id";
		        $result=$db->query($query);
                if($result->num_rows!=0){ 
					 while ($row = $result->fetch_assoc()) 
					 {
						$q="SELECT badge_name from t_badge where badge_id='".$row['badge_id']."'";
						$res=$db->query($q);
						while($r=$res->fetch_assoc())
						{
							echo "  || ". $row['c']." ". $r['badge_name'] ;echo " ||  ";
						}
										 // $data[] = $row;
					}
				}
				else{
					echo "No badges received yet";
				}
		    }


		    function getdisplay(){

				$configs = include('../config/config.php');
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
						echo $row1['commit_messg']." of ".$row1['commit_author']." has received ".$row1['badge_sum']." badges";echo "<br>";
						// // $row1++=$value['c'];
						// print_r($row1);echo"<br>";
					// $b= json_encode($row1,true);
				}
				// $c[$i]=$b;
				// $i++;
					// echo $res;
				}
				// print_r($c);

                
				// for($j=0;$j<sizeof($c);$j++) {
				// 	echo $c['commit_messg']." of author ".$val['commit_author']." has received ".$val['badge_sum']."||";
				// }

		 }
		    



}
 ?>
