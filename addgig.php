<?php
	session_start();
	
	$desc = $_POST['desc'];
	$price = $_POST['price'];
	
	
	/* Fetch owner id */
	$db = new SQLite3('db.sqlite');
	$handler = $db->query('SELECT id FROM User U
						  WHERE U.name == "' . $_SESSION['user'] . '"');
	$ownerid = $handler->fetchArray()['id'];
	
	
	/* Fetch category id */
	$handler = $db->query('SELECT id FROM Category C
						 WHERE C.name == "' . $_POST['category'] . '"');
	$result = $handler->fetchArray();
	
	
	if($result == false)
	{
			echo 'Unknown category.';
			echo '<br><a href="gigenter.php">back</a>';
			$db->close();
			exit();
	}
	$catid = $result['id'];
	
	
	$q = '
		INSERT INTO 
			"Gig"(ownerid, description, categoryid, price, isactive)
		values(' . $ownerid . ', "' . 
				   $desc . '", ' . 
				   $catid . ', ' . 
				   $price . 
				   ', 1)
		';
	
	//echo $q;
	$db->query($q);
	$db->close();
	header('Location: gigs.php');
?>
