<?php
	session_start();
	
	if(!isset($_SESSION['user']) || 
	   !isset($_GET['gig']) || 
	   !isset($_POST['enddate']))
		exit();
	
	$db = new SQLite3('../db.sqlite');
	
	$q = '
		INSERT INTO Orders(gigid,sellerid,buyerid,enddate)
		values(' . $_GET['gig'] 
		   . ',' . $_GET['seller'] 
		   . ',' . $_GET['buyer'] /* !!! */
		   . ',"' . $_POST['enddate'] . '")	
	';
	
	$db->query($q);
	header('Location: ../page/orders.php');
	
?>
