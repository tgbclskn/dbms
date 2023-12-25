<?php
	/* test */
	session_start();
		
	
/* If already logged in, redirect */
if(isset($_SESSION['user']))
	{
		if($_SESSION['user'] != "admin")
			header('Location: mainpage.php');
		else
			header('Location: admin.php');
	}

/* On first visit, check DB file. 
   Create if not exists */
if(!isset($_SESSION['first_visit']))
{
	if(!file_exists('db.sqlite'))
		initdb();
	$_SESSION['first_visit'] = false;
}
?>


<!DOCTYPE html>
<head>
	<link href="style.css" rel="stylesheet" type="text/css">
</head>
<body>
	<div class="container glassbox">
		<h2>lancr.</h2>
		<form method="post">

		<label for="uname">User Name:</label><br>
		<input type="text" id="uname" name="username"><br>

		<label for="passwd">Password:</label><br>
		<input type="password" id="passwd" name="password"><br><br>

		<input type="submit" formaction="login.php" value="Log In"><br>
		<input type="submit" formaction="register.php" value="Register"><br>
		</form>
	</div>
</body>



<?php
function initdb()
{
		$db = new SQLite3('db.sqlite');
		
		foreach ([
		
		//User table
		'CREATE TABLE "Users" (
			"id" INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,
			"name" VARCHAR,
			"password" VARCHAR,
			"location" VARCHAR,
			"about" VARCHAR,
			"picture" VARCHAR
		)',
		
		//Gig table
		'CREATE TABLE "Gigs" (
			"id" INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,
			"ownerid" INTEGER NOT NULL,
			"description" VARCHAR,
			"categoryid" INTEGER NOT NULL,
			"price" VARCHAR,
			"isactive" INTEGER,
			FOREIGN KEY(ownerid) REFERENCES User(id)
		)', 
		
		//Order table
		'CREATE TABLE "Orders" (
			"id" INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,
			"gigid" INTEGER NOT NULL,
			"sellerid" INTEGER NOT NULL,
			"buyerid" INTEGER NOT NULL,
			"startdate" VARCHAR,
			"enddate" VARCHAR,
			"payment" VARCHAR,
			FOREIGN KEY(gigid) REFERENCES Gig(id),
			FOREIGN KEY(sellerid) REFERENCES User(id),
			FOREIGN KEY(buyerid) REFERENCES User(id)
		)',
		
		//Message table
		'CREATE TABLE "Messages" (
			"id" INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,
			"senderid" INTEGER NOT NULL,
			"receiverid" INTEGER NOT NULL,
			"text" INTEGER NOT NULL,
			"date" VARCHAR,
			FOREIGN KEY(senderid) REFERENCES User(id),
			FOREIGN KEY(receiverid) REFERENCES User(id)
		)',
		
		//Review table
		'CREATE TABLE "Reviews" (
			"id" INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,
			"raterid" INTEGER NOT NULL,
			"ratedid" INTEGER NOT NULL,
			"rating" INTEGER NOT NULL,
			"comment" VARCHAR,
			FOREIGN KEY(raterid) REFERENCES User(id),
			FOREIGN KEY(ratedid) REFERENCES User(id)
		)',
		
		//Category table
		'CREATE TABLE "Categories" (
			"id" INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,
			"name" VARCHAR NOT NULL
		)',
		
		//Moderator table
		'CREATE TABLE "Moderators" (
			"userid" INTEGER NOT NULL
		)'
		
		] as $query)
		
		{
			$db->query($query);
		}
		
		$db->close();
		
}
?>
