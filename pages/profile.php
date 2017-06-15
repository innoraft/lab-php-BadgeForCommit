
<link href="../assets/bootstrap/css/bootstrap.min.css" rel="stylesheet"> 
<link href="../assets/css/style.css" rel="stylesheet">
<link href = "https://code.jquery.com/ui/1.10.4/themes/ui-lightness/jquery-ui.css"
         rel = "stylesheet">
         <script src="https://www.amcharts.com/lib/3/amcharts.js"></script>
<script src="https://www.amcharts.com/lib/3/serial.js"></script>
<script src="https://www.amcharts.com/lib/3/plugins/export/export.min.js"></script>
<link rel="stylesheet" href="https://www.amcharts.com/lib/3/plugins/export/export.css" type="text/css" media="all" />
<script src="https://www.amcharts.com/lib/3/themes/light.js"></script>
<style>
#chartdiv {
	width		: 100%;
	height		: 500px;
	font-size	: 11px;
}		</style>

<?php
$configs = include('../config/config.php');
session_start();
$row=array();
$q1=array();
$t=array();
 $db =mysqli_connect("$configs->host","$configs->username","$configs->pass","$configs->database");
					 $query="SELECT * FROM t_users WHERE user_github_id='".$_SESSION['user']."'";
					 $res=  $db->query($query);

					 while( $array = mysqli_fetch_array($res) ){
					 	$stamp=$array['user_session_id'];
					 	$mail=$array['user_email'];

					 }

					 $query1="SELECT commit_messg from t_commits where commit_author='".$_SESSION['user']."'";
					 $res1=$db->query($query1);
					 // while()


?>



<nav class="navbar navbar-inverse" style="margin-bottom: 0px;">
  <div class="container-fluid">
    <div class="navbar-header">
      <a class="navbar-brand" href="#">Badge For a Commit</a>
    </div>
    <ul class="nav navbar-nav">
      <li ><a href="home.php">Home</a></li>
      <li><a href="main.php">Review</a></li>
      <li><a href="logout.php">Logout</a></li>
    </ul>
    <ul class="nav navbar-nav navbar-right">
      <li><a href="summary.php">Statistics</a></li>
      <li><a href="../pages/dashboard.php">Weekly update</a></li>
      <li  class="active"><a href="#"><span class="glyphicon glyphicon-qrcode"></span>&nbspProfile</a></li>
    </ul>
  </div>
</nav>

<div class="background">
	<div class="overlay ">
		<div class="container">
			<div class="list">
				<h1><?php echo $_SESSION['user']?></h1>
				<h4 class="glyphicon glyphicon-envelope"><?php echo $mail ?></h4>
			</div>	

			<br>	
			<div class="panel panel-default">
     			 <div class="panel-heading"><h3>You Added</h3></div>
     			 <div class="panel-body"><?php
					while( $array1 = mysqli_fetch_array($res1) ){
					 	echo $array1['commit_messg'];echo "<br>";

					 }
				 	?>				 	
				  </div>
    		</div>		

    		<br>
    		<div class="panel panel-default">
     			 <div class="panel-heading"><h3>Your Top 5</h3></div>
     			 <div class="panel-body"><?php
					$q = "SELECT commit_id,count(*) as c from t_commit_review where commit_id in(select commit_id from t_commits where commit_author='".$_SESSION['user']."') group by commit_id order by c DESC LIMIT 5";
					$result = $db->query( $q );
					 while ($row = $result->fetch_assoc()) {
        			$data[] = $row;
       					 }
       					 foreach ($data as $key => $value) {
          // print_r($value);echo "<br>";
          $query1= "SELECT commit_messg,commit_code FROM t_commits WHERE commit_id= '".$value['commit_id']."'";
          $res = $db->query( $query1);
          while($row1 =$res->fetch_assoc()){
            // echo $value['c'];
            $row1['badge_sum']=$value['c'];
            $m= $row1['commit_messg']." has received ".$row1['badge_sum']." badges";
            $q1['commit_messg']=$row1['commit_messg'];
            $q1['badge_count']=$row1['badge_sum'];
             echo $m;
             array_push($t,$q1);
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
      // print_r($t);





				 	?>
				 	<script>
var chart = AmCharts.makeChart( "chartdiv", {
  "type": "serial",
  "theme": "light",
  "dataProvider":<?php echo json_encode($t) ?> ,
  "valueAxes": [ {
    "gridColor": "#FFFFFF",
    "gridAlpha": 0.2,
    "dashLength": 0
  } ],
  "gridAboveGraphs": true,
  "startDuration": 1,
  "graphs": [ {
    "balloonText": "[[category]]: <b>[[value]]</b>",
    "fillAlphas": 0.8,
    "lineAlpha": 0.2,
    "type": "column",
    "valueField": "badge_count"
  } ],
  "chartCursor": {
    "categoryBalloonEnabled": false,
    "cursorAlpha": 0,
    "zoomable": false
  },
  "categoryField": "commit_messg",
  "categoryAxis": {
    "gridPosition": "start",
    "gridAlpha": 0,
    "tickPosition": "start",
    "tickLength": 20
  },
  "export": {
    "enabled": true
  }

} );
</script>
<div id="chartdiv"></div>				 	
				  </div>
    		</div>			
		</div>
    </div>
</div>



<script src="../assets/bootstrap/js/bootstrap.min.js"></script>
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>