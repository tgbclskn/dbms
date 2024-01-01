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
		<img class="logo" src="../favicon.ico" alt="logo" width=100 height=100/>
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
</body>
<h3>-- Ongoing --</h3>

<?php
	
	$db = new SQLite3('../db.sqlite', SQLITE3_OPEN_READONLY);
	
	
	$q = '
					SELECT G.description	as	gigdesc,
						   G.price			as	gigprice,
						   G.id				as	gigid,
						   C.name			as	categoryname,
						   Seller.name		as	gigsellername,
						   O.enddate		as	enddate,
						   Seller.picture	as	picture,
						   O.id				as	orderid,
						   O.isactive		as	isactive,
						   O.completeddate	as	date
						   
					FROM Gigs G,
						 Users Seller,
						 Users Buyer,
						 Categories C,
						 Orders O 
						 
					WHERE Buyer.name = "' . $_SESSION['user'] . '" AND
						  O.buyerid = Buyer.id AND 
						  O.sellerid = Seller.id AND 
						  O.gigid = G.id AND 
						  G.categoryid = C.id
						  ';

	$queryhandler = $db->query($q);
	
	while(true)
	{
		$nextorder = $queryhandler->fetchArray();
		
		if($nextorder == false)
			break;
		
		if($nextorder['isactive'] == 0)
			continue;
		
		$sellername = $nextorder['gigsellername'];
		
		echo  
		'<a href="profile.php?
				user=' . $sellername . '">@' . $sellername . '</a><br>'
		. '<img style="max-height: 100px;max-width: 100px;"
				  src="../pictures/' . $nextorder['picture'] . '"><br>' 
		. 'Description: '
		. 	$nextorder['gigdesc'] . '<br>' 
		. 'Category: '
		. 	$nextorder['categoryname'] . '<br>' 
		. 'Price: '
		. 	$nextorder['gigprice'] . '<br>' 
		. 'Due Date:'
		. 	$nextorder['enddate'] . '<br>
		
		<a href="../func/orderrem.php?id=' 
					. $nextorder['orderid'] 
						. '">Cancel Order</a><br><br>';
	}
?>

<br><h3>-- Completed --</h3>

<?php
while(true)
	{
		$nextorder = $queryhandler->fetchArray();
		
		if($nextorder == false)
			break;
		
		if($nextorder['isactive'] == 1)
			continue;
		
		$sellername = $nextorder['gigsellername'];
		
		echo  
		'<a href="profile.php?
				user=' . $sellername . '">@' . $sellername . '</a><br>'
		. '<img style="max-height: 100px;max-width: 100px;"
				  src="../pictures/' . $nextorder['picture'] . '"><br>' 
		. 'Description: '
		. 	$nextorder['gigdesc'] . '<br>' 
		. 'Category: '
		. 	$nextorder['categoryname'] . '<br>
		Completed on: ' . $nextorder['date'] . ' ID: ' . $nextorder['orderid'] . '<br>
		<a href="../func/download.php?orderid=' . $nextorder['orderid'] . '">Download</a><br><br>
		';
	}



?>
