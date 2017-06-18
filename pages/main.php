
<link href="../assets/bootstrap/css/bootstrap.min.css" rel="stylesheet"> 
<link href="../assets/css/style.css" rel="stylesheet">
<link href = "https://code.jquery.com/ui/1.10.4/themes/ui-lightness/jquery-ui.css"
         rel = "stylesheet">
 <link rel="stylesheet" href="../assets/WOW-master/css/libs/animate.css">
         

<?php
session_start();
// echo $_SESSION['token'];
include("../includes/databaseservices.php");
$configs = include('../config/config.php');

if(isset($_SESSION['uid']))
{

$array=array();


$db =mysqli_connect("$configs->host","$configs->username","$configs->pass","$configs->database"); 
$query1="SELECT * FROM t_commits WHERE commit_author!='".$_SESSION['user']."'";
$res=$db->query($query1);
?>


<!-- <div class="logout"><a href='logout.php'>LOGOUT</a></div> -->
<nav class="navbar navbar-inverse" style="margin-bottom: 0px;">
  <div class="container-fluid">
    <div class="navbar-header">
      <a class="navbar-brand" href="#">Badge For a Commit</a>
    </div>
    <ul class="nav navbar-nav">
      <li ><a href="home.php">Home</a></li>
      <li class="active"><a href="main.php">Review</a></li>
      <li><a href="logout.php">Logout</a></li>
    </ul>
    <ul class="nav navbar-nav navbar-right">
      <li><a href="summary.php">Statistics</a></li>
       <li><a href="dashboard.php">Weekly update</a></li>
      <li><a href="profile.php"><span class="glyphicon glyphicon-qrcode"></span>&nbspProfile</a></li>
      <!-- <li><a href="#myModal" data-toggle="modal">Summary</a></li> -->
    </ul>
  </div>
</nav>


<!-- <div id="myModal" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title">Weekly Summary: The Dashboard</h4>
                </div>
                <div class="modal-body">
                    <p><?php $dash=new DatabaseServices();
                        $dash->getdisplay();?></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div> -->


<div class=background>
<div class="overlay">

               <!--  <form method="post"> -->
<div class="container">
<div class="row">
<div class="col-sm-11 list1 wow fadeIn"  data-wow-duration="2s" >
<h1 style="margin: 0px; padding-top: 5%;z-index: 4;color: white;" >Pick a badge</h1><br>

 <?php

  while( $array = mysqli_fetch_array($res) )
 {

  
 	?>

    <div id="<?php echo $array['commit_id']?>" ondrop="drop(event, this)" ondragover="allowDrop(event)">
        <tr>
          <!--  <td>ID:<name="id" value= <?php echo $array['commit_id'];?>><?php echo $array['commit_id'];?> </td> -->
           
           <td>COMMIT MESSAGE:<name="mess" value=<?php echo $array['commit_messg'];?>><?php echo $array['commit_messg'];?></td><br>
           <td>COMMIT_AUTHOR: <name="author" value=<?php echo $array['commit_author'];?>><?php echo $array['commit_author'];?></td>&nbsp;

          <?php $_SESSION['code']=base64_decode($array['commit_code']);?>

                      <a class="js-open-modal" data-id="<?php echo $array['commit_code']?>" href="#" data-modal-id="popup">View Code</a>
                      <div id="popup" class="modal-box"> 
                      <header>
                      <a href="#" class="js-modal-close close">×</a>
                      <h3 style="color:black">Your Code</h3>
                      <p style="color:black">your additions are preceded by a (+) sign while deletions are preceded by a (-) sign</p>
                      </header>
                      <div class="modal-body">
                      <pre ><code id="bookId"> </code></pre>
                      </div>
                      <footer>
                      <a href="#" class="js-modal-close">Close</a>
                      </footer>
                      </div><br>

          <!--  -->

          <?php
            $dash=new DatabaseServices();
            
          ?>

          



          
          <?php 
                            $query2="SELECT *FROM t_badge";
                            $res1=$db->query($query2);
                            
                            while($arr=mysqli_fetch_array($res1))
                            {
                                $return=$dash->b_count($array['commit_id'],$arr['badge_id']);
                            ?>
                            <img src=<?php echo $arr['badge_icon']?>  onclick="review(<?php echo $array['commit_id']?>,<?php echo $arr['badge_id']?>)"><?php
                             echo'<span id="div'.$array['commit_id'].''.$arr['badge_id'].'">'.$return.'</span>'; 
                            }
                            ?>
        </tr>
       <br><br>
</div>
     <?php
    
}
?>

</div>
<nav class="col-sm-1 wow pulse">
<ul class="badge nav nav-pills nav-stacked list1" data-spy="affix"  data-offset-top="105">
    <?php 
                            $query2="SELECT *FROM t_badge";
                            $res1=$db->query($query2);
                            
                            while($arr=mysqli_fetch_array($res1))
                            {
                            ?>
                            <div><button><img id=<?php echo $arr['badge_id'] ?> src=<?php echo $arr['badge_icon']?>  draggable='true' ondragstart='drag(event)'></button></div><?php 
                            }
     ?>
  
</ul>
</nav>
<script>
function allowDrop(ev) {
    ev.preventDefault();
}

function drag(ev) {
    ev.dataTransfer.setData('Text/html', ev.target.id);
}

function drop(ev, target) {
  ev.preventDefault();
   var data = ev.dataTransfer.getData("text/html"); 
    // alert(ev.target.id);
    // alert(target.id);
    // alert(data);
   $.ajax({
           type: "POST",
           url: "../includes/badges.php",
           data: {  
                cid:target.id,
                bid:data
            },
           dataType: "json",
           success: function(data){
            // alert("inserted");
            if(Object.keys(data.b).length===2)
             $('#div'+data.a+data.c).html(" ");
            // console.log(data);
            else
             $('#div'+data.a+data.c).html(data.b);
           console.log(data.b);
           },
           error: function(data){
            console.log(data);

           }
           
        });
}
</script>



<!-- </form> -->


<script>

function review($a,$b)
{    
   
   $.ajax({
           type: "POST",
           url: "../includes/b_del.php",
           data: {  
                cid:$a,
                bid:$b
            },
           dataType: "json",
           success: function(data){
            // alert("inserted");
            if(Object.keys(data.b).length===2)
             $('#div'+data.a+data.c).html(" ");
            // console.log(data);
            else
             $('#div'+data.a+data.c).html(data.b);
           },
           error: function(data){
            console.log(data);

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
</div>
</div>
</div>
</div>


<?php
    mysqli_close($db);?>
    
   
    <?php

} 
else{
  header('Location:login.php');
} 
 
?>

<script src="../assets/bootstrap/js/bootstrap.min.js"></script>
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<script src="../assets/WOW-master/dist/wow.min.js"></script>

  <script>
  wow = new WOW(
  {
  boxClass: 'wow',
  animateClass: 'animated',
  offset: 100
  }
  );
  wow.init();
  </script>
