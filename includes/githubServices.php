<link href="../assets/bootstrap/css/bootstrap.min.css" rel="stylesheet"> 
<link href="../assets/css/stylesheet.css" rel="stylesheet">


<?php
include("/databaseservices.php");

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
        
        $sha=array();
        $link=array();
        $code=array();
        $author=array();
        $messg=array();
        $com=array();
        $commit_sha=array();
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
            $i++; 
            }
                
         }
         for($j=0;$j<sizeof($sha);$j++){
                $var = $sha[$j].','.$author[$j].','.$messg[$j].','.$link[$j].','.$code[$j];
                $com[$j] = $var;
            } 
            if(sizeof($com)!=0){  
        ?>   

                <div class="align">        
<div class="container body1">
<div class="col-sm-10 col-sm-offset-1">
                <form method="post">
                <h1 class="h11">ADD YOUR COMMITS FOR REVIEW</h1><br>
                <?php 
                    // $a = "kjaskjSHKJHAKsj";
                    // $myVar = (string)$a;
                    for($k=0;$k<sizeof($com);$k++) {
                        $var = explode(",", $com[$k]);            
                            // $a = $com[$k];                          
                            // $b= $var[1];                    
                            // $c= $var[2];
                ?>   
                    <div class="col-sm-12 list" >

                    <?php 
                        // echo $messg[$k];
                        // echo "<br>";
                        echo "<input type='checkbox' onClick=".  
                             "showAlert('".
                             $sha[$k].
                             "','".
                             $author[$k].
                             "','".
                             $link[$k].
                             "','".
                             urlencode($messg[$k]).
                             "','".
                             $code[$k]."')>";
     
     // $var = " ";

     // echo "hekko". $var . "asdsad";               ?>
                    

                           <?php
                        
                        
                           echo $var[2];


                    echo "<a href=".$link[$k].">.....link</a>";?></div><br>
                <?php      
                    }
                ?>
                
                </form>
       

              
                <form  class="nex" action="../pages/nextpage.php" method="post">
                    <input type="submit" name="nextpage" value="NEXTPAGE">
                </form>
                <form  class="nex1" action="../pages/previous.php" method="post">
                    <input type="submit" name="prepage" value="PREV PAGE">
                </form>
   
                 <form  class="main" action="../pages/main.php" method="post">
                    <input type="submit" name="mainpage" value="GO TO REVIEW">
                </form>


            <div style="border:1px solid black;text-align: center;">
            <h3> LATEST SUMMARY</h3>
             <?php $dash=new DatabaseServices();
            $dash->getdisplay();?></div>
    
</div>
</div>
 </div>


<!--  <div class="container body1">
    
 </div> -->
 <script>
  function showAlert(sha, author, link, message,code) { 
    // alert(sha + author + link + message);
   var myText = "This is inserted!";
   $.ajax({
   type: "POST",
   url:"../pages/submit.php",
   data: {  
                cid: sha,
                did: author,
                eid: link,
                fid: message,
                gid: code
            },
   dataType: "json",
   success:function(data){
   alert(data);
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



function raw_url($link){
        $ch=curl_init();
        $url=$link."?access_token=".$_SESSION['token'];
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

    


}



?>


