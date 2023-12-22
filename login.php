<?php 
	session_start();
?>

<?php

	/* Do not accept if either username or password is empty */
	if($_POST['username'] == "" || 
	   $_POST['password'] == "")
	{
			echo '<br>Empty username or password.';
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
	
	$db = new SQLite3('db.sqlite', SQLITE3_OPEN_READONLY);
	
	$q = 'SELECT * FROM "User" WHERE name == "' 
	. $_POST['username'] . '" AND password == "' . $_POST['password']
	. '"';
	//echo $q;
	
	$result = $db->query($q);
	
	
	/* Check username and password */
	if($result->fetchArray() == false)
	
	/* Refuse logging if it doesn't */
	{
			echo "Failed to log in";
			echo '<br><a href="index.php">go back</a>';
	}

	/* Continue with logging in */
	else
	{
			$_SESSION['user'] = $_POST['username'];
			
			$db->close();
			header('Location: mainpage.php');
	}
	
	$db->close();
?>


