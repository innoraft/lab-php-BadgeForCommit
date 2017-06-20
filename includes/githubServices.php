<link href="../assets/bootstrap/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="../assets/WOW-master/css/libs/animate.css">
<link href="../assets/css/style.css" rel="stylesheet">


<?php
// include("/databaseservices.php");

session_start();

class githubServices {

	
    function getAccessToken($request_code) {
        
	    $configs = include('../config/config.php');
	    $ch = curl_init(); 
	    $url="https://github.com/login/oauth/access_token?code=".$request_code."&client_id=".$configs->OAUTH2_CLIENT_ID."&client_secret=".$configs->OAUTH2_CLIENT_SECRET; 
	 
	    curl_setopt($ch,CURLOPT_URL,$url);
	    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Accept: application/json'));
	    curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);

	   	$output=curl_exec($ch);			
		  $a=json_decode($output);
	   	$b=$a->access_token;
	    curl_close($ch);
	    return $b;
    }

    function getUserInfo($token) {

    	$ch=curl_init();
    	// session_start();
     //   $_SESSION['token']=$token;
    	$url="https://api.github.com/user?access_token=".$token;
    	curl_setopt($ch,CURLOPT_URL,$url);
    	curl_setopt($ch, CURLOPT_HTTPHEADER,array(
            "Accept: application/vnd.github.v3+json",
            "Content-Type: text/plain",
            "User-Agent: Mozilla/5.0 (Windows NT 6.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/47.0.2526.111 YaBrowser/16.3.0.7146 Yowser/2.5 Safari/537.36"
           

        ));
    	curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
    	$output=curl_exec($ch);
		
       
	    curl_close($ch);
        return $output;
	    }

function getcommits($token){
        $configs = include('../config/config.php');
        $db =mysqli_connect("$configs->host","$configs->username","$configs->pass","$configs->database");
        
        $sha=array();
        $link=array();
        $code=array();
        $author=array();
        $messg=array();
        $com=array();
        $commit_sha=array();
        $repo=array();
        $i=0;
        $a=array();
        $ch=curl_init();

        $url="https://api.github.com/search/commits?q=author:".$_SESSION['user']."&type=Commits&access_token=$token&page=".$_SESSION['next']."&per_page=20";
        curl_setopt($ch,CURLOPT_URL,$url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array("Accept:application/vnd.github.cloak-preview",
            "Content-Type: text/plain",
            "User-Agent: Mozilla/5.0 (Windows NT 6.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/47.0.2526.111 YaBrowser/16.3.0.7146 Yowser/2.5 Safari/537.36"
            ));
         curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
         $output= curl_exec($ch);
         // echo $output;
         // return $output;
         $commit_sha=json_decode($output,true);
         // print_r($commit_sha);
         foreach ($commit_sha['items'] as $key => $value) {
                if($_SESSION['user']==$value['author']['login']){
                $sha[$i]= $value['sha'];
                $code[$i]=$value['url'];
                $link[$i]=$value['html_url'];
                $author[$i]=$value['author']['login'];
                $messg[$i]=$value['commit']['message'];
                $repo[$i]=$value['repository']['full_name'];
            $i++; 
            }                
         }


         for($j=0;$j<sizeof($sha);$j++){
                $var = $sha[$j].','.$author[$j].','.$messg[$j].','.$link[$j].','.$code[$j].','.$repo[$j];
                $com[$j] = $var;
            } 
            


if(sizeof($com)!=0){  
        ?>   
<nav class="navbar navbar-inverse" style="margin-bottom: 0px;">
  <div class="container-fluid">
    <div class="navbar-header">
      <a class="navbar-brand">Badge For a Commit</a>
    </div>
    <ul class="nav navbar-nav">
      <li class="active"><a href="../pages/home.php">Home</a></li>
      <li><a href="../pages/main.php">Review</a></li>
      <li><a href="../pages/logout.php">Logout</a></li>
    </ul>
    <ul class="nav navbar-nav navbar-right">
      <li><a href="../pages/summary.php">Statistics</a></li>
      <li><a href="../pages/dashboard.php">Weekly update</a></li>
      <li><a href="../pages/profile.php"><span class="glyphicon glyphicon-qrcode"></span>&nbspProfile</a></li>
    </ul>
  </div>
</nav>

<!-- <div id="popup" class="modal-box"> 
                      <header>
                      <a href="#" class="js-modal-close close">×</a>
                      <h3>Weekly Summary: The Dashboard</h3>
                      </header>
                      <div class="modal-body">
                      <pre ><code id="bookId"> </code></pre>
                      </div>
                      <footer>
                      <a href="#" class="js-modal-close">Close</a>
                      </footer>
</div> -->

               <div class=background>
               <div class="overlay">
               <h1 style="margin: 0px; padding-top: 5%; text-align: center;z-index: 4;color: white;" class=" wow pulse">PICK YOUR COMMITS</h1><br>
               <!--  <form method="post"> -->
                <div class="list">
                
                <?php 
                    // $a = "kjaskjSHKJHAKsj";
                    // $myVar = (string)$a;
                    for($k=0;$k<sizeof($com);$k++) {
                        $var = explode(",", $com[$k]);            
                            // $a = $com[$k];                          
                            // $b= $var[1];                    
                            // $c= $var[2];
        $query1="SELECT * FROM t_commits WHERE commit_git_hash='".$sha[$k]."'";
        $res = $db->query($query1);
        $num= $res->num_rows;
        // echo $num;
           
       

        if ($num == 0){
                ?>   
                    <div class="col-sm-12 list wow fadeIn" >

                    <?php 
                        // echo $messg[$k];
                        // echo "<br>";
                        echo "<input type='checkbox' id='cb".$k."' name='chk' onClick=".  
                             "showAlert('".
                             $sha[$k].
                             "','".
                             $author[$k].
                             "','".
                             $link[$k].
                             "','".
                             urlencode($messg[$k]).
                             "','".
                             $repo[$k].
                             "','".
                             $code[$k]."')><label for='cb".$k."'><img src='../assets/images/plus.png'></label>
";
     
     // $var = " ";

     // echo "hekko". $var . "asdsad";               ?>
                    

                           <?php
                        
                        
                           echo $var[2];


                    echo "<a style='color:white;' href=".$link[$k]." target='_blank'>.....link</a>";?></div><br>

                <?php
                }      
                    }
                    if(sizeof($com)==20){
                ?>


                
               <!--  </form> -->
               
                <form  class="nex col-lg-offset-5 col-xs-offset-5" action="../pages/nextpage.php" method="post">
                    <input type="submit" name="nextpage" value="More Commits">
                </form> 
              
       <?php 
       }

       ?>
        </div>
        </div>
              
       </div>
           
          
    
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



<!--  <div class="container body1">
    
 </div> -->
 <script>
  function showAlert(sha, author, link, message,repo,code) { 

   $.ajax({
   type: "POST",
   url:"../pages/submit.php",
   data: {  
                cid: sha,
                did: author,
                eid: link,
                fid: message,
                rid: repo,
                gid: code
               
            },
   dataType: "json",
   success:function(data){
    $("input:checkbox[name=chk]:checked").prop( "checked", false ); 
     
  },
  error:function(data){
    // $("input:checkbox[name=chk]:checked").prop( "checked", false );
     console.log(data);
     // console.log(data.responseText === "entered"?'asa':'zzzzzzzz');
    if(data.responseText === "entered"){
       $("input:checkbox[name=chk]:checked").prop( "checked", true ); 
       console.log(data.responseText);
     }
     else
      $("input:checkbox[name=chk]:checked").prop( "checked", false ); 
       // alert(data);
  },
});
}
</script>
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>

     
                <?php


    } 
      
        else{
                header('location:../pages/main.php');
            }
 
         

    }



// function raw_url($link){
//         $ch=curl_init();
//         $url=$link."?access_token=".$_SESSION['token'];
//         curl_setopt($ch,CURLOPT_URL,$url);
//         curl_setopt($ch, CURLOPT_HTTPHEADER,array(
//             "Accept: application/vnd.github.v3+json",
//             "Content-Type: text/plain",
//             "User-Agent: Mozilla/5.0 (Windows NT 6.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/47.0.2526.111 YaBrowser/16.3.0.7146 Yowser/2.5 Safari/537.36"
           

//         ));
//         curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
//         $output=curl_exec($ch);
        
       
//         curl_close($ch);
//         return $output;

//     }

    }
?>
