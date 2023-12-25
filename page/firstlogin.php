<!DOCTYPE html>
<head>
	<link href="../styles/style.css" rel="stylesheet" type="text/css">
</head>

<?php
		
		if(isset($_SESSION['user']))
		{
			echo 'You are already logged in.';
			echo '<br><a href="mainpage.php">go back</a>';
			exit();
		}
		
		/* Illegal access */
		if($_POST['username'] == "" ||
		   $_POST['password'] == "")
		{
			echo '<br>You cannot do that.';
			echo '<br><a href="index.php">go back</a>';
			exit();
		}
		
		$db = new SQLite3('../db.sqlite', SQLITE3_OPEN_READWRITE);
		
		$q = 'INSERT INTO Users (name, password, location, about) 
		values("' 
		. $_POST['username'] . '", "'
		. $_POST['password'] . '", "'
		. $_POST['location'] . '", "'
		. $_POST['about'] . '")';
		
		$db->query($q);
		
		session_start();
		$_SESSION['user'] = $_POST['username'];
		
		$db->close();
		echo 
			'
			<div class="container glassbox">
			Registration complete.
			<br><a href="mainpage.php">go to mainpage</a></div>
			';


?>
