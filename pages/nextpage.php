<link href="../assets/bootstrap/css/bootstrap.min.css" rel="stylesheet"> 
<link href="../assets/css/stylesheet.css" rel="stylesheet">

<?php
session_start();

$_SESSION['next']++;
// echo $_SESSION['next'];
$sha=array();
        $link=array();
        $author=array();
        $messg=array();
        $com=array();
        $commit_sha=array();
        $i=0;
        $ch=curl_init();
        $url="https://api.github.com/search/commits?q=author:".$_SESSION['user']."&type=Commits&access_token=".$_SESSION['token']."&page=".$_SESSION['next']."&per_page=20";
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
                $link[$i]=$value['html_url'];
                $author[$i]=$value['author']['login'];
                $messg[$i]=$value['commit']['message'];
            $i++; 
            }
                
         }
         for($j=0;$j<sizeof($sha);$j++){
                $var = $sha[$j].','.$author[$j].','.$messg[$j];
                $com[$j] = $var;
            } 
if(sizeof($com)!=0){

        ?>   

                
                <div class="col-md-12 align">        
                </div>
                <div class="container body1">
                <div class="col-md-6 col-md-offset-3">
                <form action ="submit.php" method="post">
                <?php 

                    for($k=0;$k<sizeof($com);$k++) {
                        // echo sizeof($com);
                ?>   
                    
                    <input type="checkbox" name="chk1[]," value ="<?php  print_r($com[$k]) ?>"><?php
                        
                        
                        $var = explode(",", $com[$k]);            
                            // $a= $var[0]; echo $var[0];                           
                            // $b= $var[1]; echo $var[1];                      
                            $c= $var[2]; echo $var[2];


                    echo "<a href=".$link[$k].">.....link</a>";?><br><br>
                <?php      
                    }
                ?>
                <input type="submit" name="Submit" value="Submit">
                </form>
        </div>

    <div class="col-md-6 col-md-offset-3">            
                <form action="../pages/nextpage.php" method="post">
                    <input type="submit" name="nextpage" value="NEXTPAGE">
                </form>
   
                <form action="../pages/main.php" method="post">
                    <input type="submit" name="mainpage" value="GO TO REVIEW">
                </form>
    </div>
</div><?php
}
else{
    header('location:../pages/main.php');
}

