<?php
	session_start();
	
	$db = new SQLite3('db.sqlite');
	
	$q = '
		INSERT INTO Orders(gigid,sellerid,buyerid,enddate)
		values(' . $_GET['gig'] 
		   . ',' . $_GET['seller'] 
		   . ',' . $_GET['buyer'] 
		   . ',"' . $_POST['enddate'] . '")	
	';
	
	$db->query($q);
	header('Location: orders.php');
	
?>
