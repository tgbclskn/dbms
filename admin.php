<?php
	session_start();
	
	/* Admin panel can only be seen by logged in moderators 
	   or the admin account */
	   
	if(!isset($_SESSION['user']) ||
		(!isModerator($_SESSION['user']) && 
		   $_SESSION['user'] != "admin")
	   )
	{
		echo 'You cannot do that.';
		exit();
	}

	echo '<br><a href="deletesession.php">delete session</a>
		  <br><a href="deletedb.php">delete database</a>
		  <br>
		  <form method="post">
		  <label for="cat">Add Category:</label>
		  <input type="text" id="cat" name="cat">  
		  <input type="submit" formaction="addcategory.php" value="add">
		  </form>
		  <a href="logout.php">logout</a>';
?>

<?php
	function isModerator() : bool
	{
			$db = new SQLite3('db.sqlite', SQLITE3_OPEN_READONLY);
			
			$q = 'SELECT * FROM Moderators M, Users U
						WHERE M.userid == U.id
						AND U.name == "' . $_SESSION['user'] . '"';
			
			$result = $db->query($q);
			
			if($result->fetchArray() == false)
				{
						$db->close();
						return false;
				}
			
			$db->close();
			return true;
	}
?>
