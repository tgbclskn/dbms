<?php
	/* List only $count number of gigs.
	   Sorted by date */
	function listgig($count, $db, $user)
	{
		$q = '
			SELECT G.description as 	gigdesc,
				   G.price 		 as 	gigprice,
				   C.name 		 as 	catname,
				   G.id 		 as 	gigid
			FROM Users U,
				 Gigs G,
				 Categories C 
			WHERE U.name = "' . $user . '" AND
				  U.id = G.ownerid AND
				  G.categoryid = C.id
			ORDER BY G.id DESC
		';
		
		$handler = $db->query($q);
		
		
		if($user != $_SESSION['user'])
			$sameuser = true;
		else 
			$sameuser = false;
		
		
		for($i = 0; $i < $count; $i++)
		{
			$nextgig = $handler->fetchArray();
			if($nextgig == false)
				break;
				
			$desc = 	$nextgig['gigdesc'];
			$category = $nextgig['catname'];
			$price = 	$nextgig['gigprice'];
			$id = 		$nextgig['gigid'];
			echo 
			
			'Description: ' 
				. $desc 
			. '<br>Category: ' 
				. $category 
			. '<br>Price: ' 
				. $price . '<br>' 
			;
			
			/* User can order gigs which are not his/her own */
			if($sameuser)
				echo '<a href="order.php?id=' . $id . '">Order</a>';
			
		}
	}


?>
