<link href="../assets/bootstrap/css/bootstrap.min.css" rel="stylesheet"> 
<link href="../assets/css/style.css" rel="stylesheet">

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
      <li class="active"><a href="dashboard.php">Summary</a></li>
    </ul>
  </div>
</nav>

<div class="background">
<div class="overlay">
<div class="list" style="padding: 10%" >
<h2>DASHBOARD:TOP 5 COMMITS</h2>
<?php

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
          $query1= "SELECT commit_author,commit_messg FROM t_commits WHERE commit_id= '".$value['commit_id']."'";
          $res = $db->query( $query1);
          while($row1 =$res->fetch_assoc()){
            // echo $value['c'];
            $row1['badge_sum']=$value['c'];
            $m= $row1['commit_messg']." of ".$row1['commit_author']." has received ".$row1['badge_sum']." badges";echo "<br>";
            echo $m;
        }
      }
?>
</div>
</div>
</div>

<script src="../assets/bootstrap/js/bootstrap.min.js"></script>