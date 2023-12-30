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
<html>
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title>Lancr.</title>
		<link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@800&family=Permanent+Marker&display=swap" rel="stylesheet">
        <!-- <link href="../styles/mainpage.css" type="text/css" rel="stylesheet">
        -->
	</head>
	
<body>
<div id="menu">
	<div id="menu-items">
		<a href="mainpage.php">Mainpage&nbsp;</a>
		<a href="profile.php">Profile&nbsp;</a>
		<a href="message.php">Message&nbsp;</a>
		<a href="gigs.php">Gigs&nbsp;</a>
		<a href="orders.php">Buys&nbsp;</a>
		<a href="pendingorders.php">Sells&nbsp;</a>
		<a href="../func/logout.php">Log out&nbsp;</a>
	</div>
</div>

<br><br>

<b>-- Latest gigs --</b><br><br>

<?php
	listgig(5, $db);
	$db->close();
?>

</body>
</html>
