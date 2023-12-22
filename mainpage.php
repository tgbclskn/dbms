<?php
	session_start();
	if($_SESSION['user'] == "")
		{
			echo 'You are not logged in.';
			echo '<br><a href="index.php">go back</a>';
			exit();
		}
?>


<!DOCTYPE html>
<a href="message.php">Message&nbsp;</a>
<a href="profile.php">Profile&nbsp;</a>
<a href="gigs.php">My Gigs&nbsp;</a>
<a href="orders.php">My Orders&nbsp;</a>
<a href="logout.php">Log out</a>
<?php echo $_SESSION['user']?>
<br><br>

<?php
	
	echo "-- Main Page --";
	echo "<br>";
	
	
	
	
	/**/
	$db = new SQLite3('db.sqlite');
	$result = $db->query('SELECT * FROM User');
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
	/**/
	
	$db->close();

?>
