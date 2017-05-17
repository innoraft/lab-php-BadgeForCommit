PROJECT TITLE: A BADGE FOR A COMMIT

INSTALLATION PROCEDURE:

		STEP1: Register your application on github.Set the redirect_uri to http://badgethecommit.local/pages/authentication.php.
		Save the OAUTH2_CLIENT_ID and OAUTH2_CLIENT_SECRET obtained thereafter.

                STEP2: Open the file → includes/config.php in any text or code editor.

		STEP3: In the file you've just opened, set the Application credentials(OAUTH2_CLIENT_ID,OAUTH2_CLIENT_SECRET)as obtained from 			the registered application from github and MySQL credentials(host,username,password and database).

		STEP4: Upload the application on the server.

		STEP5: Run the index.html file to start the application.



DATABASE QUERIES AND DATABASE STRUCTURE:
		
Queries for creating tables of the database(db_badge)

Creating table t_users:
create table t_users(user_id int(50) auto_increment primary key,user_session_id varchar(30),user_github_id varchar(50),user_role_id varchar(10),user_email varchar(50));

Creating table t_commits:
create table t_commits(commit_id int(20) auto_increment primary key,commit_git_hash varchar(50), commit_messg varchar(50), commit_author varchar(50),commit_link varchar(80),commit_code blob); 

Creating table t_commit_review:
create table t_commit_review(commit_review_id int(20) auto_increment primary key,commit_id int(20),commit_reviewer_id varchar(50),badge_id varchar(20),commit_review_created varchar(20));

Creating table t_user_role:
create table t_user_role(user_role_id int(50) auto_increment primary key,user_role_name varchar(50),user_role_desc varchar(50));

Insert data into table t_user_role:
insert into t_user_role(user_role_name,user_role_desc) values('admin','holds all administrative rights');
insert into t_user_role(user_role_name,user_role_desc) values('authenticated','only authenticated users can provide badges, donot have admin rights');



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




