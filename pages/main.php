<?php
$i=0;
session_start();
$array=array();
$db=mysqli_connect("localhost","root","123","db_badge");
$query1="SELECT * FROM t_commits WHERE commit_author!='".$_SESSION['user']."'";
$res=$db->query($query1);
?>
 <form action="badges.php" method="post">
 <?php

  while( $array = mysqli_fetch_array($res) )
 {
 	?>
        <tr>
           <td>ID: <?php echo $array['commit_id'];?> </td>
           <td>SHA: <?php echo $array['commit_git_hash'];?></td> 
           <td>COMMIT MESSAGE: <?php echo $array['commit_messg'];?></td>
           <td>COMMIT_AUTHOR: <?php echo $array['commit_author'];?></td>
           <td>BADGES:<?php 
                            $query2="SELECT *FROM t_badge";
                            $res1=$db->query($query2);


                            while($arr=mysqli_fetch_array($res1))
                            {
                                echo '<td><button id="sub[$i]"><img src="'.$arr['badge_icon'].'"></button></td>' ;
                                $i++;
                            }
                            ?>
           </td>
        </tr>
        <br><br>
     <?php
}
?>
</form>
<span id="result"></span>
<script src="script/jquery-1.8.1.min.js" type="text/javascript"></script>
<script src="script/my_script.js" type="text/javascript"></script>

<?php
    mysqli_close($db);

?>
