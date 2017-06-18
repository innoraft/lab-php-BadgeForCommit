<!-- <link href="..assets/css/stylesheet.css" rel="stylesheet"> 
 -->
 <link href="../assets/bootstrap/css/bootstrap.min.css" rel="stylesheet"> 
 <link rel="stylesheet" href="../assets/WOW-master/css/libs/animate.css">
 <link href="../assets/css/style.css" rel="stylesheet">
 <?php
 session_start();
if(!isset($_SESSION['uid'])){ 
?>


	
		<div class ="backdrop">
			<div class="ha">
					<form action ="authentication.php" >
					 <!-- <img src="../assets/images/logo.png" id="logo" class="img-responsive" > -->
					 <h1 class="banner wow fadeIn"> A BADGE FOR A COMMIT</h1>
			 		 <input id="sub_button" class="wow pulse" type="submit" value="LOGIN WITH GITHUB">
			 
					</form>
			</div>
		</div>
	


	<div class ="overlay1">Upload your commits for review and provide badges to commits of other users.</div>


	<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
   <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>

    <!-- Include all compiled plugins (below), or include individual files as needed -->
   <script src="../assets/bootstrap/js/bootstrap.min.js"></script>

<?php
}
else
	header('location:'.$_SESSION['server'].'pages/home.php');
?>


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

