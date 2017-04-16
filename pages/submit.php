<?php

				$db=mysqli_connect("localhost","root","123","db_badge");
				
				$checkbox1= $_POST['chk1'];
				if(isset($_POST['Submit']))
				{
					for($i=0;$i<sizeof($checkbox1);$i++)
					{
						$a=$checkbox1[$i];
						echo $a;
						$sql="INSERT INTO t_commits(commit_git_hash) VALUES('$a')";
						
						mysqli_query($db,$sql);
					}
					echo "inserted";
				}
				else {
					echo "not inserted";
								}
								?>
