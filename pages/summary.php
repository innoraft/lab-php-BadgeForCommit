<!-- Resources -->
<link href="../assets/bootstrap/css/bootstrap.min.css" rel="stylesheet"> 
<link href="../assets/css/style.css" rel="stylesheet">
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
}					
</style>



<?php
include("../includes/databaseservices.php");
 $configs = include('../config/config.php');?>
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
      <li  class="active"><a href="summary.php">Statistics</a></li>
      <li><a href="dashboard.php">Summary</a></li>
    </ul>
  </div>
</nav>



<?php


 $db =mysqli_connect("$configs->host","$configs->username","$configs->pass","$configs->database"); 
  $query = "SELECT commit_id, COUNT(*) as c from t_commit_review group by commit_id order by c DESC
				LIMIT 5";
				$result = $db->query( $query );
				// $c=array();
				$i=0;
				$n=array();
				$dat=array();
				// $b=array();
				$data = array();
				$m=array();
				// Print out rows
				while ($row = $result->fetch_assoc()) {
				 $data[] = $row;
				}
				// print_r($data);echo "<br>";
				foreach ($data as $key => $value) {
					// print_r($value);echo "<br>";
					$query1= "SELECT commit_author,commit_messg FROM t_commits WHERE commit_id= '".$value['commit_id']."'";
					$res = $db->query( $query1);
					while($row1 =$res->fetch_assoc()){
						// echo $value['c'];
						$row1['badge_sum']=$value['c'];
						$m['messg']= $row1['commit_messg'];
						$m['count']=$row1['badge_sum'];
                        array_push($n,$m);
						
						// // $row1++=$value['c'];
						// print_r($row1);echo"<br>";
					// $b= json_encode($row1,true);
				}
				// $c[$i]=$b;
				// $i++;
					// echo $res;
				}
				$dat=(json_encode($n));
				// echo $dat;
				   
?>
<!-- Styles -->


<!-- Resources -->

<!-- Chart code -->
<script>
var chart = AmCharts.makeChart( "chartdiv", {
  "type": "serial",
  "theme": "light",
  "dataProvider":<?php echo $dat ?> ,
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
    "valueField": "count"
  } ],
  "chartCursor": {
    "categoryBalloonEnabled": false,
    "cursorAlpha": 0,
    "zoomable": false
  },
  "categoryField": "messg",
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

<!-- HTML -->
<div class="overlay">
<div id="chartdiv"></div>
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
</div>					


<script src="../assets/bootstrap/js/bootstrap.min.js"></script>
