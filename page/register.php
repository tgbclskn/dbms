<!DOCTYPE html>
<head>
	<link href="../styles/style.css" rel="stylesheet" type="text/css">
</head>

<?php 
	session_start();
	if(isset($_SESSION['user']))
		{
			echo 'You are already logged in.';
			echo '<br><a href="mainpage.php">go back</a>';
			exit();
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
	if(!isset($_POST['username']) ||
		$_POST['username'] == "" || 
		$_POST['password'] == "")
	{
			echo 
			'<div class="container glassbox">
			Empty username or password.<br>
			<a href="index.php">go back</a></div>';
			exit();
	}
	
	/* The name "admin" is reserved */
	if($_POST['username'] == "admin")
	{
			echo 
			'<div class="container glassbox">
			You cannot register as \'admin\'.<br>
			<a href="index.php">go back</a></div>';
			exit();
	}
	
	$db = new SQLite3('../db.sqlite', SQLITE3_OPEN_READONLY);
	
	$q = 'SELECT * FROM Users WHERE name == "' 
							. $_POST['username'] . '"';
	
	$result = $db->query($q);
	
	
	/* Check if username exists in the DB */
	if($result->fetchArray() == false)
	
	/* New user, ask other information */
	{
		
		echo '
		<div class="container glassbox">
			<form enctype="multipart/form-data" method="post">
				<label for="uname">User Name:</label><br>
				<input type="text" id="uname" name="username" value="' 
				. $_POST['username'] . '"><br>
  
				<label for="passwd">Password:</label><br>
				<input type="text" id="passwd" name="password" value="' 
				. $_POST['password'] . '"><br>
  
				<label for="location">Location:</label><br>
				<input type="text" id="location" name="location"><br>
			
				<label for="about">About:</label><br>
				<input type="text" id="about" name="about"><br><br>
				
				<label for="pp">Profile Picture:</label><br>
				<input type="file" id="pp" name="pp" accept="image/png, 
															image/jpeg">
			
				<br><br><input type="submit" formaction="firstlogin.php" 
				value="Complete Registration"><br>
			</form>
		</div>
		';
	}
	
	/* Cannot register same username twice */
	else
	{
			echo 
			'<div class="container glassbox">
			Username exists.<br>
			<a href="index.php">go back</a></div>';
		
	}
	
	$db->close();
?>

