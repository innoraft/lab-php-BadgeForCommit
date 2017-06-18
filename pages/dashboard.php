<link href="../assets/bootstrap/css/bootstrap.min.css" rel="stylesheet"> 
<link href="../assets/css/style.css" rel="stylesheet">
<link href = "https://code.jquery.com/ui/1.10.4/themes/ui-lightness/jquery-ui.css"
         rel = "stylesheet">
<link rel="stylesheet" href="../assets/WOW-master/css/libs/animate.css">

<nav class="navbar navbar-inverse" style="margin-bottom: 0px;">
  <div class="container-fluid">
    <div class="navbar-header">
      <a class="navbar-brand" href="#">Badge For a Commit</a>
    </div>
    <ul class="nav navbar-nav">
      <li><a href="home.php">Home</a></li>
      <li><a href="main.php">Review</a></li>
      <li><a href="logout.php">Logout</a></li>
    </ul>
    <ul class="nav navbar-nav navbar-right">
      <li><a href="summary.php">Statistics</a></li>
      <li class="active"><a href="dashboard.php">Weekly Update</a></li>
      <li><a href="profile.php"><span class="glyphicon glyphicon-qrcode"></span>&nbspProfile</a></li>
    </ul>
  </div>
</nav>

<div class="background">
<div class="overlay">
<div class="container" style="padding:10%">
<div class="panel panel-default wow fadeIn" data-wow-duration="2s" >
<div class="panel-heading"><h3>TOP 5 RATED</h3></div>
<div class="panel-body"><?php

$configs = include('../config/config.php');
            $db =mysqli_connect("$configs->host","$configs->username","$configs->pass","$configs->database");
            $query = "SELECT commit_id, COUNT(*) as c from t_commit_review group by commit_id order by c DESC
        LIMIT 5";
        $result = $db->query( $query );
        // $c=array();
        $i=0;
        // $b=array();
        $data = array();
        // Print out rows
        while ($row = $result->fetch_assoc()) {
         $data[] = $row;
        }
        // print_r($data);echo "<br>";
        foreach ($data as $key => $value) {
          // print_r($value);echo "<br>";
          $query1= "SELECT commit_author,commit_messg,commit_code FROM t_commits WHERE commit_id= '".$value['commit_id']."'";
          $res = $db->query( $query1);
          while($row1 =$res->fetch_assoc()){
            // echo $value['c'];
            $row1['badge_sum']=$value['c'];
            $m= $row1['commit_messg']." of ".$row1['commit_author']." has received ".$row1['badge_sum']." badges";
             echo $m;
            ?>
            <a class="js-open-modal" data-id="<?php echo $row1['commit_code']?>" href="#" data-modal-id="popup">View Code</a>
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
                      </div>
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
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
                      <?php
           
            echo "<br>";
        }
      }
?>
</div>
</div>
</div>
</div>
</div>



<script src="../assets/bootstrap/js/bootstrap.min.js"></script>
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
