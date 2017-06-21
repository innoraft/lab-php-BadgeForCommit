<!-- Resources -->
<link href="../assets/bootstrap/css/bootstrap.min.css" rel="stylesheet"> 

<script src="https://www.amcharts.com/lib/3/amcharts.js"></script>
<script src="https://www.amcharts.com/lib/3/serial.js"></script>
<script src="https://www.amcharts.com/lib/3/plugins/export/export.min.js"></script>
<link rel="stylesheet" href="https://www.amcharts.com/lib/3/plugins/export/export.css" type="text/css" media="all" />
<script src="https://www.amcharts.com/lib/3/themes/light.js"></script>
<link href="../assets/css/style.css" rel="stylesheet">
<style>
#chartdiv {
	width		: 100%;
	height		: 500px;
	font-size	: 11px;
}		
#chartdiv1 {
  width   : 100%;
  height    : 500px;
  font-size : 11px;
}   	
#chartdiv2 {
  width   : 100%;
  height    : 500px;
  font-size : 11px;
} 
p{
  font-size: 20px;
  text-align: center;
  color:white;
}    		
</style>



<?php
include("../includes/databaseservices.php");
 $configs = include('../config/config.php');?>
 <nav class="navbar navbar-inverse" style="margin-bottom: 0px;">
  <div class="container-fluid">
    <div class="navbar-header">
      <a class="navbar-brand">Badge For a Commit</a>
    </div>
    <ul class="nav navbar-nav">
      <li ><a href="home.php">Home</a></li>
      <li><a href="main.php">Review</a></li>
      <li><a href="logout.php">Logout</a></li>
    </ul>
    <ul class="nav navbar-nav navbar-right">
      <li  class="active"><a href="summary.php">Statistics</a></li>
      <li><a href="dashboard.php">Weekly update</a></li>
      <li><a href="profile.php"><span class="glyphicon glyphicon-qrcode"></span>&nbspProfile</a></li>
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
        $q=array();
        $r=array();
        $dat1=array();
				$dat=array();
				// $b=array();
				$data = array();
				$m=array();


        $rep=array();
        $rn=array();
        $dat2=array();
				// Print out rows
				while ($row = $result->fetch_assoc()) {
				 $data[] = $row;
				}
				// print_r($data);echo "<br>";
				foreach ($data as $key => $value) {
					// print_r($value);echo "<br>";
					$query1= "SELECT commit_author,commit_messg,commit_repo FROM t_commits WHERE commit_id= '".$value['commit_id']."'";
					$res = $db->query( $query1);
					while($row1 =$res->fetch_assoc()){
						// print_r($row1);
						$row1['badge_sum']=$value['c'];
						$m['messg']= $row1['commit_messg'];
						$m['count']=$row1['badge_sum'];
                        array_push($n,$m);
            $q['author']=$row1['commit_author'];
            $q['count']=$row1['badge_sum'];
            array_push($r, $q);
            $rep['repo']=$row1['commit_repo'];
            $rep['count']=$row1['badge_sum'];
            array_push($rn, $rep);
						
						// // $row1++=$value['c'];
						// print_r($row1);echo"<br>";
					// $b= json_encode($row1,true);
				}
				// $c[$i]=$b;
				// $i++;
					// echo $res;
				}
				$dat=(json_encode($n));
        $dat1=(json_encode($r));
        $dat2=(json_encode($rn));
				// echo $dat2;
				   
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


<script>
var chart = AmCharts.makeChart( "chartdiv1", {
  "type": "serial",
  "theme": "light",
  "dataProvider":<?php echo $dat1 ?> ,
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
  "categoryField": "author",
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


<script>
var chart = AmCharts.makeChart( "chartdiv2", {
  "type": "serial",
  "theme": "light",
  "dataProvider":<?php echo $dat2 ?> ,
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
  "categoryField": "repo",
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
<div class="overlay"><br><br>
<p>Most rated commits</p><div id="chartdiv"></div><br><br>
<p>Most rated commiters</p><div id="chartdiv1"></div><br><br>
<p>Most rated repositories</p><div id="chartdiv2"></div>

<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
</div>					


<script src="../assets/bootstrap/js/bootstrap.min.js"></script>
