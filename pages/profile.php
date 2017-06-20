
<link href="../assets/bootstrap/css/bootstrap.min.css" rel="stylesheet"> 

<link href = "https://code.jquery.com/ui/1.10.4/themes/ui-lightness/jquery-ui.css"
         rel = "stylesheet">
         <script src="https://www.amcharts.com/lib/3/amcharts.js"></script>
<script src="https://www.amcharts.com/lib/3/serial.js"></script>
<script src="https://www.amcharts.com/lib/3/plugins/export/export.min.js"></script>
<link rel="stylesheet" href="https://www.amcharts.com/lib/3/plugins/export/export.css" type="text/css" media="all" />
<script src="https://www.amcharts.com/lib/3/themes/light.js"></script>
<link rel="stylesheet" href="../assets/WOW-master/css/libs/animate.css">
<link href="../assets/css/style.css" rel="stylesheet">
<style>
#chartdiv {
	width		: 100%;
	height		: 300px;
	font-size	: 11px;
}		</style>

<?php
include("../includes/databaseservices.php");
$configs = include('../config/config.php');
session_start();
$row=array();
$q1=array();
$t=array();

 $db =mysqli_connect("$configs->host","$configs->username","$configs->pass","$configs->database");
 $q = "SELECT commit_id,count(*) as c from t_commit_review where commit_id in(select commit_id from t_commits where commit_author='".$_SESSION['user']."') group by commit_id order by c DESC LIMIT 5";
          $result = $db->query( $q );
          $num=$result->num_rows;
					 $query="SELECT * FROM t_users WHERE user_github_id='".$_SESSION['user']."'";
					 $res=  $db->query($query);

					 while( $array = mysqli_fetch_array($res) ){
					 	$stamp=$array['user_session_id'];
					 	$mail=$array['user_email'];
            $role=$array['user_role_id'];
					 }

					 $query1="SELECT commit_messg,commit_git_hash from t_commits where commit_author='".$_SESSION['user']."'";
					 $res1=$db->query($query1);
					 // while()


?>



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
      <li><a href="summary.php">Statistics</a></li>
      <li><a href="../pages/dashboard.php">Weekly update</a></li>
      <li  class="active"><a href="profile.php"><span class="glyphicon glyphicon-qrcode"></span>&nbspProfile</a></li>
    </ul>
  </div>
</nav>

<div class="background">
	<div class="overlay ">
		<div class="container">
			<div class="list">
				<div style="margin-top: 5%" class="dropdown">
           <button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
            <?php echo $_SESSION['user'];?>
            <span class="caret"></span>
           </button>
            <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
             <li><a href="#a">You Added</a></li>
             <li><a href="#b">Your Top 5</a></li>
             <li><a href="#c">Admin</a></li>
             <?php 
             if($role==1){?>
             <li><a href="#d">Badges</a></li><?php } ?>
            </ul>
          </div>
				<h4 class="glyphicon glyphicon-envelope"><?php echo $mail ?></h4>
			</div>	

			<br>	
			<div id =a class="panel panel-default wow slideInDown">
     			 <div class="panel-heading"><h3>You Added</h3></div>
     			 <div class="panel-body"><?php
					while( $array1 = mysqli_fetch_array($res1) ){
					 	
            // echo "<input type='checkbox' id='cb".$k."' onClick=".  
            //                  "delcom('".
            //                  "')><label for='cb".$k."'><img src='../assets/images/plus.png'></label>";
            echo"<button type='button' class='btn btn-default' onclick="."delcom('".$array1['commit_git_hash']."')".";this.disabled='disabled';>"; echo "remove"; echo "</button>";echo $array1['commit_messg'];
            echo "<br>";

					 }
				 	?>				 	
				  </div>
    	</div>		

    		<br><br>
    		<div id=b class="panel panel-default  wow slideInDown">
     			 <div class="panel-heading"><h3>Your Top 5</h3></div>
           
     			 <div class="panel-body"><?php
					if($num>=1){
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
<div id="chartdiv"></div>	 <?php } else
echo "You have not received badges yet";
?> </div>			 	
				
     
    		</div>




      <br><br>
     <div id =c class="panel panel-default  wow slideInDown">
           <div class="panel-heading"><h3>Create Admin</h3></div>
           <div class="panel-body">
           <?php $d=new DatabaseServices();
           $d->admin();
           ?>
          </div>
      </div>   

<?php
if($role==1){
?>
        <br><br>
     <div id =d class="panel panel-default  wow slideInDown">
           <div class="panel-heading"><h3>Create Badges</h3></div>
           <div class="panel-body">

        <div id="messages"></div>
          <form action="insert_image.php" method="post" enctype="multipart/form-data" id="uploadImageForm">
          <div class="form-group">
            <label for="fullName">Badge name</label>
            <input type="text" class="form-control" id="fullName" name="fullName" placeholder="Name">
          </div>
          <div class="form-group">
            <label for="fullName">Badge description</label>
            <input type="text" class="form-control" id="desc" name="desc" placeholder="description">
          </div>
          <div class="form-group">
            <label for="exampleInputPassword1">Badge icon</label>            
            <div id="kv-avatar-errors-2" class="center-block" style="width:800px;display:none"></div>
 
            <div class="kv-avatar center-block" style="width:200px">
                <input id="avatar-2" name="userImage" type="file" class="file-loading">
            </div>
          </div>
          <button type="submit" class="btn btn-default">Submit</button>
        </form>
           <!--  <form  class="feedback"  method="post" name="changer">       
                    <div class="form-group"" >
                      <input name="image"  enctype="multipart/form-data" accept="image/jpeg image/png" type="file">
                    </div>
                    <div class="form-group">
                        <input type="text" name="name" class="form-control" placeholder="Badge_name">
                    </div>
                    <div class="form-group">
                        <input type="text" name="author" class="form-control" placeholder="Badge_author" value="<?php echo $_SESSION['user']?>">
                    </div>
                    <div class="form-group">
                        <input type="text" name="desc" class="form-control" placeholder="Badge_description">
                    </div>
                    <button  value="Submit" id="submit" type="submit" class="btn btn-primary">Submit</button>
               
            </form> -->
          </div>
      </div>  
<?php
}
?>   





		</div>
    </div>
</div>





 
  

    <script>
$(document).ready(function() {
            $("#uploadImageForm").unbind('submit').bind('submit', function() { 
                var form = $(this);
                var formData = new FormData($(this)[0]);
 
                $.ajax({
                    url: form.attr('action'),
                    type: form.attr('method'),
                    data: formData,
                    dataType: 'json',
                    cache: false,
                    contentType: false,
                    processData: false,
                    async: false,
                    success:function(response) {
                        if(response.success == true) {
                            $("#messages").html('<div class="alert alert-success alert-dismissible" role="alert">'+
                          '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+
                          response.messages + 
                        '</div>');
 
                            $('input[type="text"]').val('');
                            $(".fileinput-remove-button").click();
                        }
                        else {
                            $("#messages").html('<div class="alert alert-warning alert-dismissible" role="alert">'+
                          '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>error'+
                          response.messages + 
                        '</div>');
                        }
                    }
                });
 
                return false;
            });
        });
    </script>


<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
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


  <script>
    function delcom($a){
       // $("#ajaxStart").attr("disabled", true);
       $.ajax({
                 type: "POST",
                 url: "delcom.php",
                 data: {  
                    cid:$a
                  },
                dataType: "json",
                 success: function(data){
                 alert(data);           
                 },
                 error: function(data){
                 // alert("added as admin");
                }
           
            });
    }
  </script>