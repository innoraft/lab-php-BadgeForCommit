<?php
   include("../includes/databaseservices.php");
	
				$db=mysqli_connect("localhost","root","123","db_badge");
				
				$checkbox1= $_POST['chk1'];
				
				if(isset($_POST['Submit']))
				{
					for($i=0;$i<sizeof($checkbox1);$i++)
					{
						
						$var = explode(",", $checkbox1[$i]);			
							$a= $var[0];							
							$b= $var[1];							
							$c= $var[2];
						$query1="SELECT * FROM t_commits WHERE commit_git_hash='".$a."'";
				        $res = $db->query($query1);
				        $num= $res->num_rows;
				        if($num>=1){
				        	echo "$a already exists";
				        }
				        else{
						$sql="INSERT INTO t_commits(commit_git_hash,commit_author,commit_messg) VALUES('$a','$b','$c')";
						mysqli_query($db,$sql);
						}
					}
					echo "inserted";
				}
				else {
					echo "not inserted";
								}

  mysqli_close($db);

				 // header('Location:main.php');
  $badges=new DatabaseServices ();
  $badges->newbadge();
   // header('location:../includes/badges.php');

?>
