<?php
	session_start();

	$id = $_GET['id'];
	
	
	/* Fetch owner id */
	$db = new SQLite3('db.sqlite');
	$handler = $db->query('SELECT id FROM Users U
						  WHERE U.name == "' . $_SESSION['user'] . '"');
	$ownerid = $handler->fetchArray()['id'];
	
	$q = '
		DELETE FROM Gigs
		WHERE id =' . $id . ' 
		AND ownerid =' . $ownerid
		;

	$db->query($q);
	$db->close();
	header('Location: gigs.php');
?>
