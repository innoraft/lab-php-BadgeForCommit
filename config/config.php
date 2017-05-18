<?php 

return (object) array( 'host' => 'localhost',//add the hostname for db
	'server' =>'http://badgethecommit.local/', //add your server name
	'username' => 'root',//username of the db
	'pass' => '123',//password for sql
	'database' => 'db_badge' ,//name of the database
	'OAUTH2_CLIENT_ID' =>'1515c3a83fe0d7863e8f',//from github
	'OAUTH2_CLIENT_SECRET'=>'1f60e82145acf5330d96e2477e0d5348f56ea4ba',//from github
	'apiURLBase' =>'https://api.github.com/',
	'redirect_uri' => 'http://badgethecommit.local/pages/authentication.php',//same as what specified during app registration on github
	'authorizeURL' => 'https://github.com/login/oauth/authorize',
	'tokenURL' => 'https://github.com/login/oauth/access_token'
);
?>


