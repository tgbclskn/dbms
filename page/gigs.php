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
	<meta name = "viewport" content = "width=device-width, initial-scale = 1.0">
	<title>Lancr.</title>
	<link href="../styles/test.css" rel="stylesheet" type="text/css">
</head>

<body>
<header>
		<img class="logo" src="../logo.svg" alt="logo" width=100 height=100/>
		<nav>
			<ul class="nav__links">
				<li><a href="mainpage.php">Home&nbsp;</a></li>
				<li><a href="profile.php">Profile&nbsp;</a></li>
				<li><a href="message.php">Messages&nbsp;</a></li>
				<li><a href="gigs.php">Gigs&nbsp;</a></li>
				<li><a href="orders.php">Buys&nbsp;</a></li>
				<li><a href="pendingorders.php">Sells&nbsp;</a></li>
			</ul>
		</nav>
		<a href="../func/logout.php">Log out&nbsp;</a>
	</header>
	<div class="container"> 
	<a href="message.php?clear">Clear Messages</a><br><br>
</body>
<a href="gigenter.php">Add gig&nbsp;</a>
<h3>-- My gigs --</h3>
<?php	
	
	$db = new SQLite3('../db.sqlite', SQLITE3_OPEN_READONLY);
	listgig(30000, $db, $_SESSION['user']);
	
	$db->close();
?>

</div>
