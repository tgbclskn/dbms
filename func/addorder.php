<?php
	session_start();
	
	if(!isset($_SESSION['user']) || 
	   !isset($_GET['gig']) || 
	   !isset($_POST['enddate']))
		exit();
	
	$db = new SQLite3('../db.sqlite', SQLITE3_OPEN_READWRITE);
	
	$q = '
		SELECT U.id as id 
		FROM Users U 
		WHERE U.name = "' . $_SESSION['user'] . '"';
	
	$buyerid = $db->query($q)->fetchArray()['id'];
	$date = date("Y-m-d");
	
	$q = '
		INSERT INTO Orders(gigid,sellerid,buyerid,enddate,startdate,isactive)
		values(' . $_GET['gig'] 
		   . ',' . $_GET['seller'] 
		   . ',' . $buyerid
		   . ',"' . $_POST['enddate'] . '","' . $date . '",1)	
	';
	
	$db->exec($q);
	$db->close();
	header('Location: ../page/orders.php');
	exit();
?>
