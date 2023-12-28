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
				   G.id 		 as 	gigid,
				   U.picture	 as		picture
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
			$picture =	$nextgig['picture'];
			echo 
				
			'<a href="profile.php?user=' . $user . '">@' . $user . '</a><br>'
			. '<img style="max-height: 100px;max-width: 100px;"
				  src="../pictures/' . $picture . '"><br>'	
			. 'Description: ' 
				. $desc 
			. '<br>Category: ' 
				. $category 
			. '<br>Price: ' 
				. $price . '<br>' 
			;
			
			/* User can order gigs which are not his/her own */
			if($user != $_SESSION['user'])
			{
					echo '<a href="order.php?id=' . $id . '">Order</a><br>';
			}
			
			echo '<br>';
		}
	}


?>
