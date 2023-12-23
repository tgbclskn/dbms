<?php
	session_start();
	$db = new SQLite3('db.sqlite');
	
	/* Refuse if not owner of the order */
	$q = '
		SELECT *
		
		FROM Users U,
			 Orders O
		
		WHERE O.id = ' . $_GET['id'] . ' AND 
			  O.buyerid = U.id AND
			  U.name = "' . $_SESSION['user'] . '"
	';
	
	if($db->query($q)->fetchArray() == false)
		exit();
	
	$db->query('DELETE FROM Orders WHERE Orders.id = ' . $_GET['id']);
	$db->close();
	header('Location: orders.php');
?>
