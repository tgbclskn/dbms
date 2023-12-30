<?php
	session_start();
	
	if(!isset($_POST['desc']))
		exit();
	
	
	$desc = $_POST['desc'];
	$price = $_POST['price'];
	
	
	/* Fetch owner id */
	$db = new SQLite3('../db.sqlite', SQLITE3_OPEN_READWRITE);
	$handler = $db->query('SELECT id FROM Users U
						  WHERE U.name == "' . $_SESSION['user'] . '"');
	$ownerid = $handler->fetchArray()['id'];
	
	
	/* Fetch category id */
	$handler = $db->query('SELECT id FROM Categories C
						 WHERE C.name == "' . $_POST['category'] . '"');
	$result = $handler->fetchArray();
	
	
	/*if($result == false)
	{
			echo 'Unknown category.';
			echo '<br><a href="../page/gigenter.php">back</a>';
			$db->close();
			exit();
	}*/
	$catid = $result['id'];
	
	
	$q = '
		INSERT INTO 
			Gigs(ownerid, description, categoryid, price)
		values(' . $ownerid . ', "' . 
				   $desc . '", ' . 
				   $catid . ', ' . 
				   $price . ')'
		;
	
	//echo $q;
	
	$db->query($q);
	$db->close();
	header('Location: ../page/gigs.php');
?>
