<!DOCTYPE html>

<?php

	session_start();
	
	/* -> User is already logged in */
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
<h3>-- Pending --</h3>

<?php	
	
	$db = new SQLite3('../db.sqlite', SQLITE3_OPEN_READONLY);
	
	$q = '
					SELECT G.description	as	gigdesc,
						   G.price			as	gigprice,
						   G.id				as	gigid,
						   C.name			as	categoryname,
						   Buyer.name		as	buyer,
						   O.enddate		as	enddate,
						   Buyer.picture	as	picture,
						   O.id				as	orderid 
						   
					FROM Gigs G,
						 Users Seller,
						 Users Buyer,
						 Categories C,
						 Orders O 
						 
					WHERE Seller.name = "' . $_SESSION['user'] . '" AND
						  O.buyerid = Buyer.id AND 
						  O.sellerid = Seller.id AND 
						  O.gigid = G.id AND 
						  G.categoryid = C.id AND
						  O.isactive = 1
			';
			
	
	$queryhandler = $db->query($q);
	
	while(true)
	{
		$nextorder = $queryhandler->fetchArray();
		
		if($nextorder == false)
			break;
		
		$buyername = $nextorder['buyer'];
		
		if(strlen($nextorder['gigdesc']) > 20)
			$dot = "...";
		else
			$dot = "";
			
		echo  
		'<a href="profile.php?
				user=' . $buyername . '">@' . $buyername . '</a><br>'
		. '<img style="max-height: 100px;max-width: 100px;"
				  src="../pictures/' . $nextorder['picture'] . '"><br>' 
		. 'Description: '
		. 	substr($nextorder['gigdesc'], 0, 20) . $dot . '<br>'  
		. 'Price: '
		. 	$nextorder['gigprice'] . '<br>' 
		. 'Due Date:'
		. 	$nextorder['enddate'] . '<br>
		
		<form enctype="multipart/form-data" method="post">
		
		<input type="submit" formaction="../func/uploadorderfile.php?orderid=' 
											. $nextorder['orderid'] . '" 
							 value="Finish Order">&emsp;&emsp;
		<label for="submission">Select file: </label>
		<input type="file" id="submission" name="submission">
		</form>
		<a href="../func/orderrem.php?id=' . $nextorder['orderid'] 
						. '">Cancel Order</a><br><br>';
	}
	 $db->close();
?>
