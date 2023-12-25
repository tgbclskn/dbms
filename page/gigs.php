<?php
	session_start();
	
	if(!isset($_SESSION['user']))
		{
			echo 'You are not logged in.';
			echo '<br><a href="index.php">go back</a>';
			exit();
		}
	
	echo '<a href=gigenter.php>Add gig&nbsp; </a>';
	echo '<a href=mainpage.php>Mainpage</a>';
	echo '<h3>-- My gigs --</h3><br><br>';
	
	
	/* List gigs belonging to user */
	$db = new SQLite3('../db.sqlite', SQLITE3_OPEN_READONLY);
	$queryhandler = $db->query('
					SELECT G.description,
						   G.price,
						   G.id,
						   C.name as categoryname
					FROM Gigs G,Users U,Categories C 
					WHERE U.id = G.ownerid AND 
						  G.categoryid = C.id AND 
						  U.name = "' . $_SESSION['user'] . '"');
	
	$i = 1;
	while(true)
	{
		$nextgig = $queryhandler->fetchArray(SQLITE3_ASSOC);
		
		if($nextgig == false)
			break;
		
		echo $i . 
		'-<br>&emsp;Desc: ' . 
					$nextgig['description'] 
		. '<br>&emsp;Category: ' . 
					$nextgig['categoryname'] 
		. '<br>&emsp;Price: ' . 
					$nextgig['price']
		. '<br>
		
		<a href="../func/gigrem.php?id=' . $nextgig['id'] 
		. '">Remove</a><br><br>';
		$i = $i + 1;
	}
	 $db->close();
?>
