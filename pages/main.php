
<link href="../assets/bootstrap/css/bootstrap.min.css" rel="stylesheet"> 
<link href="../assets/css/stylesheet.css" rel="stylesheet">


<?php
session_start();
// echo $_SESSION['token'];
include("../includes/databaseservices.php");
$configs = include('../config/config.php');

if(isset($_SESSION['uid']))
{

$array=array();
$j=array();

$db =mysqli_connect("$configs->host","$configs->username","$configs->pass","$configs->database"); 
$query1="SELECT * FROM t_commits WHERE commit_author!='".$_SESSION['user']."'";
$res=$db->query($query1);
?>
<div class="align">        
<div class="container body1">

<div class="col-sm-10 col-sm-offset-1">

<div class="logout"><button><a href='logout.php'>LOGOUT</a></button></div>
<h1 class="h11">PICK A BADGE FOR A COMMIT</h1><br>
<!--  <form id ="msgfrm" method="post"> -->
<div id="msgfrm">
 <?php

  while( $array = mysqli_fetch_array($res) )
 {
  
 	?>
        
    
        <tr>
          <!--  <td>ID:<name="id" value= <?php echo $array['commit_id'];?>><?php echo $array['commit_id'];?> </td> -->
           
           <td>COMMIT MESSAGE:<name="mess" value=<?php echo $array['commit_messg'];?>><?php echo $array['commit_messg'];?></td><br>
           <td>COMMIT_AUTHOR: <name="author" value=<?php echo $array['commit_author'];?>><?php echo $array['commit_author'];?></td>&nbsp;

          <?php $_SESSION['code']=base64_decode($array['commit_code']);?>

                      <a class="js-open-modal" data-id="<?php echo $array['commit_code']?>" href="#" data-modal-id="popup">View Code </a>
                      <div id="popup" class="modal-box"> 
                      <header>
                      <a href="#" class="js-modal-close close">×</a>
                      <h3>Your Code</h3>
                      <p>your additions are preceded by a (+) sign while deletions are preceded by a (-) sign</p>
                      </header>
                      <div class="modal-body">
                      <pre ><code id="bookId"> </code></pre>
                      </div>
                      <footer>
                      <a href="#" class="js-modal-close">Close Button</a>
                      </footer>
                      </div><br>

          <!--  -->
          <?php
            $dash=new DatabaseServices();
            $return=$dash->b_dashboard($array['commit_id']);
            print_r($return);
          ?>
          <!--  <td>COMMIT_LINK:<?php echo "<a href=".$array['commit_link'].">.....link</a>";?></td> --><br>
          <td>BADGES:<?php 
                            $query2="SELECT *FROM t_badge";
                            $res1=$db->query($query2);
                            
                            while($arr=mysqli_fetch_array($res1))
                            {
                            ?>
                            <td><button id="sub" onclick="this.disabled=true"><img src=<?php echo $arr['badge_icon']?> onClick="review(<?php echo $array['commit_id']?>,<?php echo $arr['badge_id']?>)"></button></td><?php 
                            }
                            ?>
            </td>
        </tr>
        <br><br>
     <?php
}
?>
</div>
<!-- </form> -->


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
            // alert("success");
           },
           error: function(){
            alert('badge provided');
           }
           
        });
}

</script>
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<script>
  $(function(){
      var appendthis =  ("<div class='modal-overlay js-modal-close'></div>");
      $('a[data-modal-id]').click(function(e) {
      var myBookId = $(this).data('id');
      var code=atob(myBookId);
      // alert(code);
      $("#bookId").text( code );
      e.preventDefault();
      $("body").append(appendthis);
      $(".modal-overlay").fadeTo(500, 0.7);

      var modalBox = $(this).attr('data-modal-id');
      $('#'+modalBox).fadeIn($(this).data());
      }); 
      $(".js-modal-close, .modal-overlay").click(function() {
      $(".modal-box, .modal-overlay").fadeOut(500, function() {
      $(".modal-overlay").remove();
      });
      });
      $(window).resize(function() {
      $(".modal-box").css({
      top: ($(window).height() - $(".modal-box").outerHeight()) / 50,
      left: ($(window).width() - $(".modal-box").outerWidth()) /14
      });
      });
      $(window).resize();
    });
</script>




<?php
    mysqli_close($db);?>
    
    </div>
    </div>
    </div>
    <?php

} 
else{
  header('Location:login.php');
} 
 
?>

