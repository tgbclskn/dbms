<?php
	session_start();
	
	if(!isset($_SESSION['user']) || !isset($_GET['id']))
		exit();
	
	$db = new SQLite3('../db.sqlite' SQLITE3_OPEN_READWRITE);
	
	/* Refuse if not seller or buyer of the specified order */
	$q = '
		SELECT *
		
		FROM Users Buyer,
			 Users Seller,
			 Orders O
		
		WHERE O.id = ' . $_GET['id'] . ' AND 
			  O.buyerid = Buyer.id AND
			  O.sellerid = Seller.id AND
			  (Buyer.name = "' . $_SESSION['user'] . '" OR 
			  Seller.name = "' . $_SESSION['user'] . '")
	';
	
	if($db->query($q)->fetchArray() == false)
		exit();
	
	$db->query('DELETE FROM Orders WHERE Orders.id = ' . $_GET['id']);
	$db->close();
	if(isset($_SERVER['HTTP_REFERER']))
		header('Location: ' . $_SERVER['HTTP_REFERER']);
	else
		header('Location: ../page/mainpage.php');
?>
