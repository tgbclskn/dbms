<!DOCTYPE html>
<head>
	<link href="../styles/style.css" rel="stylesheet" type="text/css">
</head>

<?php
	session_start();
	
/* If already logged in, redirect */
if(isset($_SESSION['user']))
	{
		if($_SESSION['user'] != "admin")
			header('Location: mainpage.php');
		else
			header('Location: admin.php');
	}
?>

<body>
	<div class="container glassbox">
		<h2>lancr.</h2>
		<form method="post">

		<label for="uname">User Name:</label><br>
		<input type="text" id="uname" name="username"><br>

		<label for="passwd">Password:</label><br>
		<input type="password" id="passwd" name="password"><br><br>

		<input type="submit" formaction="login.php" 
							 value="Log In"><br>
		<input type="submit" formaction="register.php" 
							 value="Register"><br>
		</form>
	</div>
</body>

