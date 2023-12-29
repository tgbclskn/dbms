<!DOCTYPE html>
<head>
	<link href="../styles/style.css" rel="stylesheet" type="text/css">
</head>

<?php 
	session_start();
	
	/* -> User is already logged in */
	if(isset($_SESSION['user']))
		{
			echo 'You are already logged in.';
			echo '<br><a href="index.php">go back</a>';
			exit();
		}
	
	/* Log in as admin if admin credentials are given */
	if($_POST['username'] == "admin" && 
	   $_POST['password'] == "admin")
	{
			$_SESSION['user'] = "admin";
			header('Location: admin.php');
	}
	
	/* -> DB file does not exist */
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

	/* -> Either username or password is empty */
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
	
	/* Check credentials */
	$q = 'SELECT * FROM Users WHERE name == "' 
	. $_POST['username'] . '" AND password == "' . $_POST['password']
	. '"';
		
	$result = $db->query($q);
	
	
	/* -> No account with specified username and password */
	if($result->fetchArray() == false)
	{
			echo '<div class="container glassbox">Failed to log in<br>
				  <a href="index.php">go back</a></div>';
	}
	
	/* Otherwise log in */
	else
	{
			$_SESSION['user'] = $_POST['username'];
			
			$db->close();
			header('Location: mainpage.php');
	}
	
	$db->close();
?>


