
<link href="../assets/bootstrap/css/bootstrap.min.css" rel="stylesheet"> 

<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
<link href="../assets/css/style.css" rel="stylesheet">





<?php
include("../includes/githubServices.php");
include("../includes/databaseservices.php");
 $configs = include('../config/config.php');
session_start();
// echo $_SESSION['token'];
$_SESSION['next']=1;
if(isset($_SESSION['uid']))
{
					 $array= array();
					
		             $db =mysqli_connect("$configs->host","$configs->username","$configs->pass","$configs->database");
					 $query="SELECT * FROM t_users WHERE user_github_id='".$_SESSION['user']."'";
					 $res=  $db->query($query);

					 while( $array = mysqli_fetch_array($res) ){
					 	$stamp=$array['user_session_id'];
					 	$mail=$array['user_email'];

					 }
					 
					 if($_SESSION['uid']==$stamp)
					 {
									if(empty($mail)){
										// $message = "PLEASE MAKE YOUR EMAIL_ID ON GITHUB ACCOUNT PUBLIC TO RECEIVE WEEKLY NOTIFICATIONS....IGNORE IF ALREADY SET";
										// echo "<script type='text/javascript'>alert('$message');</script>";?>
<div id="myModal" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">REGISTER</h4>
            </div>
            <div class="modal-body">
                <p>Register to get the latest updates straight in your inbox.</p>
                <form class="feedback">
                    <div class="form-group">
                        <input type="text" name="name" class="form-control" placeholder="Name">
                    </div>
                    <div class="form-group">
                        <input type="email" name="email" class="form-control" placeholder="Email Address">
                    </div>
                    <button id="submit" type="submit" class="btn btn-primary">Submit</button>
                </form>
            </div>
        </div>
    </div>
</div><?php
									} 
									$commits=new githubServices();
									$commitslist=$commits->getcommits($_SESSION['token']);
									?>
									<!-- <div class="container body1">
									<div class="col-sm-10 col-sm-offset-1">
									<div style="border:1px solid black;text-align: center;">
									 <h3> LATEST SUMMARY</h3>
							             <?php $dash=new DatabaseServices();
							            $dash->getdisplay();?>
							        </div>
							        </div>
							        </div>
 -->
							            <?php

									

					}

					else{	
						header('Location:logout.php');
					}







}
else{
	header('Location:login.php');
}

?>
<script type="text/javascript">
    $(document).ready(function(){
        $("#myModal").modal('show');
        $("button#submit").click(function(){
        $("#myModal").modal('hide');
$.ajax({
type: "POST",
url: "mail_sub.php",
data: $('form.feedback').serialize(),
success: function(message){
	// alert("success");
// $("#feedback").html(message)
// $("#feedback-modal").modal('hide');
},
error: function(){
// alert("Error");
}
});
});

    });
</script>

<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<script src="../assets/bootstrap/js/bootstrap.min.js"></script>

