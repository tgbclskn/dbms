<?php
	include '../include/listgig_mainpage.php';
	session_start();
	
	/* -> User is already logged in */
	if(!isset($_SESSION['user']))
		{
			echo 'You are not logged in.';
			echo '<br><a href="index.php">go back</a>';
			exit();
		}
		
	$db = new SQLite3('../db.sqlite', SQLITE3_OPEN_READONLY);
?>


<!DOCTYPE html>
<a href="mainpage.php">Mainpage&nbsp;</a>
<a href="message.php">Message&nbsp;</a>
<a href="profile.php">Profile&nbsp;</a>
<a href="gigs.php">My Gigs&nbsp;</a>
<a href="orders.php">My Orders&nbsp;</a>
<a href="pendingorders.php">Pending Orders&nbsp;</a>
<a href="../func/logout.php">Log out&nbsp;</a>
<?php echo $_SESSION['user']?><br><br>



<b>-- Main Page --</b><br><br>
<b>-- Latest gigs --</b><br><br>

<?php
	listgig(5, $db);
	$db->close();
?>



