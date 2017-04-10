
<?php
		class DatabaseServices {

		     function insertuserinfo($output) {
				
		        $db =mysqli_connect("localhost","root","123","db_badge");        
		        $data = json_decode($output, true);        
		        $login=$data["login"];
		        $email=$data["email"];
		        $query1="SELECT * FROM t_users WHERE 'user_id'='$login' AND 'user_email'='$email'";

				$res = $db->query($query1);

				if ($res)

				{
				    echo "you are already registered";
				}
				else {  
		        $sql= "INSERT INTO t_users(user_id,user_email) VALUES('$login','$email')";
		        mysqli_query($db,$sql);
		        echo "connected";
		    	}
			}
		 }
 ?>
