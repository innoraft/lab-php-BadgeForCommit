

// $("#sub[$i]").click( function() {
//  $.post( $("#myForm").attr("action"), 
//          $("#myForm :td").serializeArray(), 
//          function(info){ $("#result").html(info); 
//    });
//  clearInput();
// });
 
// $("#myForm").submit( function() {
//   return false;	
// });
 
// function clearInput() {
// 	$("#myForm :td").each( function() {
// 	   $(this).val('');
// 	});
// }

function deleteauth(){
        $configs = include('../config/config.php');
        $ch = curl_init(); 
        $url="https://api.github.com/authorizations/delete?client_=id".$configs->OAUTH2_CLIENT_ID; 
     
        curl_setopt($ch, CURLOPT_URL,$url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
        $output=curl_exec($ch);    
        // $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
             
    }


    ?>
						                            <button onClick="commits(<?php echo $list[$i]?>,<?php echo $_SESSION['token']?>)"><?php echo $list[$i];?></button><?php 






						                            <button onClick="commits('<?php echo $list[$c]?>')"><?php echo $list[$c]?></button><?php echo "<br>";


						                            <script>

										function commits($a,callback)
										{ 
											console.log("hello");
											console.log($a);      
										    $.ajax({
										           type: "GET",
										           url: "../includes/badges.php",
										           data: {  
										                repo:$a
										            },
										           dataType: "json",
										           success: function(data){
										           	alert(data);
										           },
										        });
										}

										</script>
										<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>




echo $_SESSION['user'];
									$commits=new githubServices();
									$commitslist=$commits->getcommits($_SESSION['token']);