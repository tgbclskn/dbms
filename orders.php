<?php
	session_start();
	
	echo '<a href=mainpage.php>Mainpage</a>';
	echo '<h3>-- My orders --</h3><br><br>';
	
	
	/* List all orders */
	$db = new SQLite3('db.sqlite');
	
	
	$q = '
					SELECT G.description as gigdesc,
						   G.price as gigprice,
						   G.id as gigid,
						   C.name as categoryname,
						   Seller.name as gigsellername,
						   O.enddate as enddate,
						   O.id as orderid 
						   
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
	
	$i = 1;
	while(true)
	{
		$nextorder = $queryhandler->fetchArray();
		
		if($nextorder == false)
			break;
		
		$sellername = $nextorder['gigsellername'];
		
		echo $i . 
		'-<br>&emsp;@' . $sellername . '' 
		. '<br>&emsp;Desc: ' . 
					$nextorder['gigdesc'] 
		. '<br>&emsp;Category: ' . 
					$nextorder['categoryname'] 
		. '<br>&emsp;Price: ' . 
					$nextorder['gigprice']
		. '<br>&emsp;Due Date: ' 
				  . $nextorder['enddate'] . '<br>
		
		<a href="orderrem.php?id=' 
					. $nextorder['orderid'] 
						. '">Cancel Order</a><br><br>';
		$i = $i + 1;
	}
	 $db->close();
?>
