<?php
define('OAUTH2_CLIENT_ID', '1515c3a83fe0d7863e8f');
define('OAUTH2_CLIENT_SECRET', '26589a28100f7837a32d9a686f151b923e972c85');
$authorizeURL = 'https://github.com/login/oauth/authorize';
$tokenURL = 'https://github.com/login/oauth/access_token';
$apiURLBase = 'https://api.github.com/';
 echo $_SERVER['REQUEST_URI'] ; ?> <br>
  <?php echo get('code'); ?>
 <a href="index.php?varname=<?php echo $var_value= get('code') ?>">Page1</a>
<?php
 function get($key, $default=NULL) {
 return array_key_exists($key, $_GET) ? $_GET[$key] : $default; 
}

?>