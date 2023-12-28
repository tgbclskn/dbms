<?php
	include '../include/listgig_mainpage.php';
	session_start();
	
	if(!isset($_SESSION['user']))
		{
			echo 'You are not logged in.';
			echo '<br><a href="index.php">go back</a>';
			exit();
		}
		
	$db = new SQLite3('../db.sqlite');
?>


<!DOCTYPE html>
<a href="mainpage.php">Mainpage&nbsp;</a>
<a href="message.php">Message&nbsp;</a>
<a href="profile.php">Profile&nbsp;</a>
<a href="gigs.php">My Gigs&nbsp;</a>
<a href="orders.php">My Orders&nbsp;</a>
<a href="../func/logout.php">Log out&nbsp;</a>
<?php echo $_SESSION['user']?>
<br><br>

<?php
	
	echo "<b>-- Main Page --</b>";
	echo "<br>";
	
	echo "<br><b> -- Latest gigs -- </b><br><br>";
	listgig(5, $db);
	
	
	/*
	$db = new SQLite3('../db.sqlite');
	$result = $db->query('SELECT * FROM Users');
	echo '<pre><br><br><br><br>db (User):<br>';
	while(true)
	{
		$result2 = $result->fetchArray(SQLITE3_ASSOC);
		if(!isset($result2['id']))
			break;
		var_dump($result2);
	}
	$db->close();
	echo '<br><br>session:<br>';
	var_dump($_SESSION);
	echo '<br><br>post:<br>';
	var_dump($_POST);
	echo '</pre>';
	*/
	
	$db->close();

?>



