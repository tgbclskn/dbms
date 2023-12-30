<!DOCTYPE html>
<?php
	session_start();
	
	if(!isset($_SESSION['user']))
		{
			echo 'You are not logged in.';
			echo '<br><a href="index.php">go back</a>';
			exit();
		}
		
	/* Page shouldn't be accessible without orderid GET */
	if(!isset($_GET['orderid']))
	{
		echo 'Invalid request';
		exit();
	}
	
	$db = new SQLite3('../db.sqlite', SQLITE3_OPEN_READWRITE);
	
	$q = '
		SELECT *
		FROM Users U,
			 Orders O
		WHERE U.name = "' . $_SESSION['user'] . '" AND 
			  O.id = ' . $_GET['orderid'] . ' AND 
			  O.sellerid = U.id
	';
	
	if($db->query($q)->fetchArray() == false)
	{
			echo 'User does not have such order';
			exit();
	}
	
	// Handle file upload
	if($_FILES['submission']['error'] == 0)
	{
		$file_extension 
		= pathinfo($_FILES['submission']['name'], PATHINFO_EXTENSION);
		
		$file_name = 'order-' . $_GET['orderid'] . '.' . $file_extension;
		
		$file_dir = '../orderfiles/' . $file_name;
		
		move_uploaded_file
			($_FILES['submission']['tmp_name'], $file_dir);
	}
	
	$date = date("Y-m-d");
	
	$q = '
		UPDATE Orders
		SET isactive = 0,
			file = "' . $file_name . '",
			completeddate = "' . $date . '" 
		WHERE Orders.id = ' . $_GET['orderid']
		;
		
	
	$db->exec($q);
	header('Location: ../page/pendingorders.php');
	$db->close();
?>
