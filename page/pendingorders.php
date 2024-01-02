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
</div>
	
</body>
