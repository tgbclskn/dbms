<!DOCTYPE html>

<?php
	include '../include/listgig_profile.php';
	session_start();
	
	/* -> User is not logged in */
	if(!isset($_SESSION['user']))
		{
			echo 'You are not logged in.';
			echo '<br><a href="index.php">go back</a>';
			exit();
		}
	
	
?>

<head>
	<link href="../styles/style.css" rel="stylesheet" type="text/css">
</head>

<a href="mainpage.php">Mainpage&nbsp;</a>
<a href="profile.php">Profile&nbsp;</a>
<a href="message.php">Message&nbsp;</a>
<a href="gigs.php">Gigs&nbsp;</a>
<a href="orders.php">Buys&nbsp;</a>
<a href="pendingorders.php">Sells&nbsp;</a>
<a href="../func/logout.php">Log out&nbsp;</a><br><br>
<a href="gigenter.php">Add gig&nbsp;</a>
<h3>-- My gigs --</h3>

<?php	
	
	$db = new SQLite3('../db.sqlite', SQLITE3_OPEN_READONLY);
	listgig(30000, $db, $_SESSION['user']);
	
	$db->close();
?>
