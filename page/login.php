<!DOCTYPE html>
<head>
	<link href="../styles/style.css" rel="stylesheet" type="text/css">
</head>

<?php 
	session_start();
	
	if(isset($_SESSION['user']))
		{
			echo 'You are already logged in.';
			echo '<br><a href="index.php">go back</a>';
			exit();
		}
	
	/* Master admin account */
	if($_POST['username'] == "admin" && 
	   $_POST['password'] == "admin")
	{
			$_SESSION['user'] = "admin";
			header('Location: admin.php');
	}
	
	if(!file_exists('../db.sqlite'))
	{
			echo 
			'<div class="container glassbox">
			DB file does not exists. Log in as admin to create.<br>
			<a href="index.php">go back</a></div>';			
			exit();
	}
?>

<?php

	/* Do not accept if either username or password is empty */
	if($_POST['username'] == "" || 
	   $_POST['password'] == "")
	{
			echo 
			'<div class="container glassbox">
			Empty username or password.<br>
			<a href="index.php">go back</a></div>';			
			exit();
	}
	
	
	
	$db = new SQLite3('../db.sqlite', SQLITE3_OPEN_READONLY);
	
	$q = 'SELECT * FROM Users WHERE name == "' 
	. $_POST['username'] . '" AND password == "' . $_POST['password']
	. '"';
		
	$result = $db->query($q);
	
	
	/* Check username and password */
	if($result->fetchArray() == false)
	{
			echo '<div class="container glassbox">Failed to log in<br>
				  <a href="index.php">go back</a></div>';
	}
	else
	{
			$_SESSION['user'] = $_POST['username'];
			
			$db->close();
			header('Location: mainpage.php');
	}
	
	$db->close();
?>

