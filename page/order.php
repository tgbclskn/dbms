<!DOCTYPE html>

<?php
	session_start();
	
	if(!isset($_SESSION['user']))
		{
			echo 'You are not logged in.';
			echo '<br><a href="index.php">go back</a>';
			exit();
		}
		
	if(!isset($_GET['id']))
		exit();
?>
<h4>-Order Detail-</h4>
<?php
	
	$gigid = $_GET['id'];
	
	/* Fetch gig information */
	$db = new SQLite3('../db.sqlite', SQLITE3_OPEN_READONLY);
	
	$q = '
			SELECT U.name 		 as 	user,
				   G.description as 	gigdesc,
				   G.price 		 as 	gigprice,
				   C.name 		 as 	catname,
				   U.id			 as		sellerid
			FROM Users U,
				 Gigs G,
				 Categories C 
			WHERE G.id = ' . $gigid . ' AND 
				  U.id = G.ownerid AND
				  G.categoryid = C.id
		';
		
		$handler = $db->query($q);
		
		$gig = $handler->fetchArray();
		
		$gigowner = $gig['user'];
		$gigdesc = 	$gig['gigdesc'];
		$category = $gig['catname'];
		$price = 	$gig['gigprice'];
		$gigsellerid = $gig['sellerid'];
		
		/* Fetch buyer user id */
		$userid = $db->query
					('SELECT id FROM Users U 
					  WHERE U.name ="' . $_SESSION['user'] . '"')
						->fetchArray()['id'];
		
		echo 
				'@&nbsp;@' 
				. $gigowner 
			. '<br>@&nbsp;Description: ' 
				. $gigdesc 
			. '<br>@&nbsp;Category: ' 
				. $category 
			. '<br>@&nbsp;Price: ' 
				. $price . '<br>' 
			;
		
		echo '
			<br><form method="post">
	
			<label for="enddate">End Date:</label><br>
			<input type="date" id="enddate" name="enddate"><br>
			
			<input 
			type="submit" formaction="../func/addorder.php?
											buyer=' . $userid . '&
											seller='. $gigsellerid . '&
											gig=' .   $gigid . '" 
													value="Buy Order">
			
			&nbsp;todo: continue with payment<br>
			</form>
		';
	
	$db->close();
?>
