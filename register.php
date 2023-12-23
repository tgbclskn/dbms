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
	
	/* The name "admin" is reserved */
	if($_POST['username'] == "admin")
	{
			echo '<br>Cannot register with that name.';
			echo '<br><a href="index.php">go back</a>';
			exit();
	}
	
	$db = new SQLite3('db.sqlite', SQLITE3_OPEN_READONLY);
	
	$q = 'SELECT * FROM Users WHERE name == "' 
	. $_POST['username'] . '"';
	//echo $q;
	
	$result = $db->query($q);
	
	
	/* Check if username exists in the DB */
	if($result->fetchArray() == false)
	
	/* New user, ask other information */
	{
		
		echo '
		
		<form method="post">
			<label for="uname">User Name:</label><br>
			<input type="text" id="uname" name="username" value="' 
			. $_POST['username'] . '"><br>
  
			<label for="passwd">Password:</label><br>
			<input type="text" id="passwd" name="password" value="' 
			. $_POST['password'] . '"><br>
  
			<label for="location">Location:</label><br>
			<input type="text" id="location" name="location"><br>
			
			<label for="about">About:</label><br>
			<input type="text" id="about" name="about"><br>
			
			<br><input type="submit" formaction="firstlogin.php" 
			value="Complete Registration"><br>
		</form>
		
		';
		
	}
	
	/* Cannot register same username twice */
	else
	{
			echo '<br>Username exists.';
			echo '<br><a href="index.php">go back</a>';
		
	}
	
	$db->close();
?>

