<?php
	session_start();
	
	if(!isset($_SESSION['user']))
		{
			echo 'You are not logged in.';
			echo '<br><a href="index.php">go back</a>';
			exit();
		}
		
	echo '<a href=mainpage.php>Mainpage</a>';
	echo '<h3>-- My orders --</h3>';
	
	
	/* List all orders */
	$db = new SQLite3('../db.sqlite');
	
	
	$q = '
					SELECT G.description	as	gigdesc,
						   G.price			as	gigprice,
						   G.id				as	gigid,
						   C.name			as	categoryname,
						   Seller.name		as	gigsellername,
						   O.enddate		as	enddate,
						   Seller.picture	as	picture,
						   O.id				as	orderid 
						   
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
	 $db->close();
?>
