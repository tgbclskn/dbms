<?php
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
	
	echo "<br><b> -- Latest gigs -- </b>";
	listgig(5, $db);
	
	
	/**/
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
	/**/
	
	$db->close();

?>


<?php
	/* List only $count number of gigs.
	   Sorted by date */
	function listgig($count, $db)
	{
		$q = '
			SELECT U.name 		 as 	user,
				   G.description as 	gigdesc,
				   G.price 		 as 	gigprice,
				   C.name 		 as 	catname,
				   G.id 		 as 	gigid
			FROM Users U,
				 Gigs G,
				 Categories C 
			WHERE U.id = G.ownerid AND
				  G.categoryid = C.id
			ORDER BY G.id DESC
		';
		
		$handler = $db->query($q);
		
		for($i = 0; $i < $count; $i++)
		{
			$nextgig = $handler->fetchArray();
			if($nextgig == false)
				break;
				
			$user = 	$nextgig['user'];
			$desc = 	$nextgig['gigdesc'];
			$category = $nextgig['catname'];
			$price = 	$nextgig['gigprice'];
			$id = 		$nextgig['gigid'];
			echo 
			
				'<br><br>@' 
				. $user 
			. '<br>Description: ' 
				. $desc 
			. '<br>Category: ' 
				. $category 
			. '<br>Price: ' 
				. $price . '<br>' 
			;
			
			/* User can order gigs which are not his/her own */
			if($user != $_SESSION['user'])
			{
					echo '<a href="order.php?id=' . $id . '">Order</a>';
			}
			
		}
	}


?>
