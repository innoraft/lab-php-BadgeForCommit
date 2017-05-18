PROJECT TITLE: A BADGE FOR A COMMIT

INSTALLATION PROCEDURE:

		STEP1: Register your application on github.Set the redirect_uri to http://badgethecommit.local/pages/authentication.php.
		Save the OAUTH2_CLIENT_ID and OAUTH2_CLIENT_SECRET obtained thereafter.

                STEP2: Open the file → includes/config.php in any text or code editor.

		STEP3: In the file you've just opened, set the Application credentials(OAUTH2_CLIENT_ID,OAUTH2_CLIENT_SECRET,redirect_uri)as obtained from the registered application from github and MySQL credentials(host,username,password and database).

		STEP4: Upload the application on the server.

		STEP5: Run the index.html file to start the application.The database will be created if it does not exist.







GETTING STARTED AND USING THE APPLICATION:

		STEP1: Running the index.html file starts the application.Login through Github.
		
		STEP2: You will be asked to authorize the application.Provide all required permissions and proceed.
		
		STEP3: This redirects you to the home page of the application.
		
		STEP4: Select your commits to add them for review on the application.(a link to the code has also been provided).

		STEP5: Next you can go to the review page and provide badges to the commits of all the other users after viewing their code.

		STEP6: Logout after you are done.

CRON SETUP REQUIREMENTS:
 
		STEP1: execute command crontab -e from the terminal and add the following at the end of the file.
			*/2 * * * * php /path of the /pages/mail.php file > path of the text file for logging in the data obtained after     				analysis(html/badgethecommit/pages/output.txt)




