
<?php
		class DatabaseServices {

		     function insertuserinfo($output) {
		        $db =mysqli_connect("localhost","root","123","db_badge");        
		        $data = json_decode($output, true);        
		        $login=$data["login"];
		        $email=$data["email"];
		        $sql= "INSERT INTO t_users(user_id,user_email) VALUES('$login','$email')";
		        mysqli_query($db,$sql);
		        echo "connected";
		    }
		 }
 ?>
