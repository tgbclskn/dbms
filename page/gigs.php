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

<a href="mainpage.php">Mainpage&nbsp;</a>
<a href="message.php">Message&nbsp;</a>
<a href="profile.php">Profile&nbsp;</a>
<a href="gigs.php">My Gigs&nbsp;</a>
<a href="orders.php">My Orders&nbsp;</a>
<a href="pendingorders.php">Pending Orders&nbsp;</a>
<a href="../func/logout.php">Log out&nbsp;</a><br><br>
<a href="gigenter.php">Add gig&nbsp;</a>
<h3>-- My gigs --</h3>

<?php	
	
	$db = new SQLite3('../db.sqlite', SQLITE3_OPEN_READONLY);
	listgig(30000, $db, $_SESSION['user']);
	
	$db->close();
?>
