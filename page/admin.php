<!DOCTYPE html>

<?php
	session_start();
	include '../include/listCatNames.php';
	include '../func/initdb.php';

	
	/* Admin panel can only be seen by logged in moderators 
	   or the admin account */
	   
	if(!isPrivileged())
		{
			echo 'You have no permission to view this page.';
			exit();
		}
		
		
	/*		Admin functions		*/
	
	/* Delete Session */
	if(isset($_GET['deletesession']))
	{
		session_destroy();
		header('Location: index.php');	
		exit();
	}
	
	/* Delete DB */
	if(isset($_GET['deletedb']))
	{
		if(file_exists('../db.sqlite'))
		{
			unlink("../db.sqlite");
			echo 'Deleted';
		}
		else
			echo 'Could not find DB';
		echo '<br><a href="admin.php">go back</a>';
		exit();
	}
	
	/* Create DB */
	if(isset($_GET['createdb']))
	{
			if(file_exists('../db.sqlite'))
				echo 'Already exists.<br>
					  <a href="admin.php">go back</a>';
					  
			else
				{
					initdb();
					echo 'Done.<br>
					  <a href="admin.php">go back</a>';
				}
				
			exit();
	}
	
	/* Add category */
	if(isset($_GET['addcategory']))
	{
		if(!file_exists('../db.sqlite'))
		{
				echo 'No DB.<br>
					  <a href="admin.php">go back</a>';
				exit();
		}
		
		$db = new SQLite3('../db.sqlite');
		
		$q = 
		'
			SELECT * FROM Categories
			WHERE name == "' . $_POST['cat'] . '"
		';
		
		if($db->query($q)->fetchArray() != false)
		{
			echo 'Category exists.<br>
			  <a href="admin.php">go back</a>';
			  $db->close();
			exit();
		}
		
		$q = 
		'
		INSERT INTO Categories(name)
		values("' . $_POST['cat'] . '")
		';
		$db->query($q);
		$db->close();
	}
	
	/* Delete category */
	if(isset($_GET['delcategory']))
	{
		if(!file_exists('../db.sqlite'))
		{
				echo 'No DB.<br>
					  <a href="admin.php">go back</a>';
				exit();
		}
		
		$db = new SQLite3('../db.sqlite');
		
		$q = 
		'
			SELECT * FROM Categories
			WHERE name == "' . $_POST['cattodelete'] . '"
		';
		
		if($db->query($q)->fetchArray() == false)
		{
			echo 'Category does not exist.<br>
			  <a href="admin.php">go back</a>';
			 $db->close();
			exit();
		}
		
		$q = 
		'
		SELECT id FROM Categories
		WHERE name = "' . $_POST['cattodelete'] . '"
		';
		$id = $db->query($q)->fetchArray()['id'];
		
		$q =
		'
		DELETE FROM gigs
		WHERE categoryid = ' . $id
		;
		$db->exec($q);
		
		$q = 
		'
		DELETE FROM Categories
		WHERE id = ' . $id
		;
		$db->exec($q);
		$db->close();
	}
	
	
	
	echo '<br><a href="admin.php?deletesession">Delete session</a>
		  <br><a href="admin.php?deletedb">Delete database</a>
		  <br><a href="admin.php?createdb">Create database</a>
		  <br>
		  <form method="post">
		  ' . getCategoryFuncIfDbExists() . '
		  </form>
		  <a href="../func/logout.php">logout</a>';
?>

<?php

function isModerator() : bool
{
		$db = new SQLite3('../db.sqlite', SQLITE3_OPEN_READONLY);
			
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
	
	
	
function isPrivileged()
{
	if(isset($_SESSION['user']) && $_SESSION['user'] == "admin")
		return true;
	if(file_exists('../db.sqlite'))
		if(isset($_SESSION['user']) && isModerator($_SESSION['user']))
			return true;
	return false;
}



function getCategoryFuncIfDbExists() : String 
{
	/* Show add/remove category options only when DB exists */
	if(file_exists('../db.sqlite'))
	{
		$s = 
		'<label for="cat">Add Category:</label>
		<br><input type="text" id="cat" name="cat">  
		<input type="submit" formaction="admin.php?addcategory"
															value="add">

		<br><label for="cattodelete">Delete Category:</label><br>
		<select name="cattodelete" id="cattodelete">
			<option value="">--Please choose one--</option>
				' . listCategoryNames() . '
		</select>
		<input type="submit" formaction="admin.php?delcategory"
														value="Delete">
		';
		return $s;
	}
	return "";
}

?>
