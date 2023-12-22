<?php
	session_start();
	
	echo '<a href=gigenter.php>Add gig</a><br>';
	echo '<h3>-- My gigs --</h3><br><br>';
	
	
	/* List all gigs */
	$db = new SQLite3('db.sqlite', SQLITE3_OPEN_READONLY);
	$queryhandler = $db->query('
					SELECT G.description,G.price,G.id FROM Gig G,User U 
					WHERE U.id == G.ownerid');
	
	$i = 1;
	while(true)
	{
		$nextgig = $queryhandler->fetchArray(SQLITE3_ASSOC);
		if(!isset($nextgig['description']))
			break;
		echo $i . '-<br>&emsp;Desc: ' . $nextgig['description'] 
		. '<br>&emsp;Price: ' . $nextgig['price'] . '<br>
		<a href="gigrem.php?id=' . $nextgig['id'] 
		. '">Remove gig</a><br><br>';
		$i = $i + 1;
	}
	 $db->close();
?>
