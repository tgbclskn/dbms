<!DOCTYPE html>

<?php
	include '../include/listgig_profile.php';
	session_start();
	
	/* -> User is not logged in */
	if(!isset($_SESSION['user']))
		{
			header('Location: index.php');
			exit();
		}
		
	$db = new SQLite3('../db.sqlite', SQLITE3_OPEN_READONLY);

	
	/* Whose profile is this? */
	if(!isset($_GET['user']))
		$get_this_user = $_SESSION['user'];
	else
		$get_this_user = $_GET['user'];
		
	
	$q = 
	'
		SELECT name,location,about,picture 
		FROM Users 
		WHERE name = "' . $get_this_user . '"
	';
	
	$handler = $db->query($q);
	$userinfo = $handler->fetchArray();
	
	/* Invalid GET info. This would normally not happen */
	if($userinfo == false)
	{
			echo 'No such user.';;
			exit();
	}
	
	$username = $userinfo['name'];
	$location = $userinfo['location'];
	$about = $userinfo['about'];
	$picture = $userinfo['picture'];
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

<img
	src="../pictures/<?php echo $picture;?>"
	style="max-height: 150px;max-width: 250px;"
	border="3px"
><br>

<?php
	echo $username;
?>
<br>
<?php
	echo $location;
?>
<br>
<?php
	echo $about;
?>


<?php
	
	/* Show message button if the profile is not his/her own */
	if($_SESSION['user'] != $username)
	{
		echo '<br><a href="message.php?to=' . $username 
		. '">Message this user</a>';
	}
?>

<h3>-- Top 3 latest gigs --</h3>

<?php
	listgig(3, $db, $username);

?>
