<?php
session_start();

if(isset($_SESSION['uid']))
{

$array=array();
$j=array();
$db=mysqli_connect("localhost","root","123","db_badge");
$query1="SELECT * FROM t_commits WHERE commit_author!='".$_SESSION['user']."'";
$res=$db->query($query1);
?>
 <form id ="msgfrm" method="post">
 <?php

  while( $array = mysqli_fetch_array($res) )
 {
 	?>
        <tr>
           <td>ID:<name="id" value= <?php echo $array['commit_id'];?>><?php echo $array['commit_id'];?> </td>
           
           <td>COMMIT MESSAGE: <name="mess" value=<?php echo $array['commit_messg'];?>><?php echo $array['commit_messg'];?></td>
           <td>COMMIT_AUTHOR: <name="author"<?php echo $array['commit_author'];?>><?php echo $array['commit_author'];?></td>
           <td>BADGES:<?php 
                            $query2="SELECT *FROM t_badge";
                            $res1=$db->query($query2);
                            
                            while($arr=mysqli_fetch_array($res1))
                            {
                            ?>
                            <td><button id="sub"><img src=<?php echo $arr['badge_icon']?> onClick="review(<?php echo $array['commit_id']?>,<?php echo $arr['badge_id']?>)"></button></td><?php 
                            }
                            ?>
           </td>
        </tr>
        <br><br>
     <?php
}
?>
</form>
<script>

function review($a,$b)
{       
   $.ajax({
           type: "POST",
           url: "../includes/badges.php",
           data: {  
                cid:$a,
                bid:$b
            },
           dataType: "json",
           success: function(data){
           },
        });
}

</script>
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>


<?php
    mysqli_close($db);?>
    <a href='http://badgethecommit.local/pages/logout.php'>LOGOUT</a>
    <?php

} 
else{
  header('Location:http://badgethecommit.local/pages/login.php');
}  
?>
