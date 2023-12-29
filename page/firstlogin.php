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
			echo '<br><a href="mainpage.php">go back</a>';
			exit();
		}
		
		/* -> Illegal access */
		if(!isset($_POST['username']) || 
		   $_POST['username'] == "" ||
		   $_POST['password'] == "")
		{
			echo '<br>You cannot do that.';
			echo '<br><a href="index.php">go back</a>';
			exit();
		}
		
		
		
		// Handle picture upload
		if($_FILES['pp']['error'] == 0)
		{
			$picture_extension 
				= pathinfo($_FILES['pp']['name'], PATHINFO_EXTENSION);
			
			/* Find unique name for the picture file on the server */
			do 
			{
				$new_picture_name 
				= random_int(0, 2170000000) . '.' . $picture_extension;
				
				$new_picture_dir 
				= '../pictures/' . $new_picture_name;	
			} while (file_exists($new_picture_dir));
			
			move_uploaded_file
				($_FILES['pp']['tmp_name'], $new_picture_dir);
		}
		
		// -> No picture was uploaded
		elseif ($_FILES['pp']['error'] == 4)
		{
			$new_picture_name = 'default.png';
		}
		
		// -> Picture exceeds maximum file size
		elseif ($_FILES['pp']['error'] == 1 || 
				$_FILES['pp']['error'] == 2)
		{
				echo '<div class="container glassbox">
			Uploaded file size is too big.<br>
			<a href="index.php">go back</a></div>';
				exit();
		}
		
		/* -> Upload failed */
		elseif ($_FILES['pp']['error'] == 3)
		{
				echo '<div class="container glassbox">
			Upload failed.<br>
			<a href="index.php">go back</a></div>';
				exit();
		}
		
		/* -> Other error */
		else
		{
				echo '<div class="container glassbox">
			Error.<br>
			<a href="index.php">go back</a></div>';
				exit();
		}		


		$db = new SQLite3('../db.sqlite', SQLITE3_OPEN_READWRITE);
				
		
		/* Insert registered user information into the DB */
		$q = 
		'INSERT INTO Users 
		(name, password, location, about,picture) 
	values("' 
		. $_POST['username'] . '","'
		. $_POST['password'] . '","'
		. $_POST['location'] . '","'
		. $_POST['about'] . '","' 
		. $new_picture_name . '")';	
	
		
		$db->query($q);
		
		
		/* Log in as the registered user */
		$_SESSION['user'] = $_POST['username'];
		
		$db->close();
		echo 
			'
			<div class="container glassbox">
			Registration complete.
			<br><a href="mainpage.php">go to mainpage</a></div>
			';


?>
