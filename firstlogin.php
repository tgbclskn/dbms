<?php
		
		/* Illegal access */
		if($_POST['username'] == "" ||
		   $_POST['password'] == "")
		{
			echo '<br>You cannot do that.';
			echo '<br><a href="index.php">go back</a>';
			exit();
		}
		
		$db = new SQLite3('db.sqlite', SQLITE3_OPEN_READWRITE);
		
		$q = 'INSERT INTO "User" (name, password, location, about) 
		values("' 
		. $_POST['username'] . '", "'
		. $_POST['password'] . '", "'
		. $_POST['location'] . '", "'
		. $_POST['about'] . '")';
		//echo $q;
		
		$db->query($q);
		
		session_start();
		$_SESSION['user'] = $_POST['username'];
		
		$db->close();
		echo "<br>Registration complete.";
		echo '<br><a href="mainpage.php">go to mainpage</a>';


?>
