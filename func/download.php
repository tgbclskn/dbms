<?php
	session_start();
	
	if(!isset($_SESSION['user']))
		{
			echo 'You are not logged in.';
			echo '<br><a href="index.php">go back</a>';
			exit();
		}
		
	$db = new SQLite3('../db.sqlite', SQLITE3_OPEN_READONLY);

	$q = '
		SELECT O.file 
		FROM Orders O,
			 Users U
		WHERE O.id = ' . $_GET['orderid'] . ' AND 
			  O.buyerid = U.id AND 
			  U.name = "' . $_SESSION['user'] . '"'
		;
	

	$result = $db->query($q)->fetchArray();
	
	if($result == false)
	{
		echo 'No such order file.';
		exit();
	}
	
	header('Content-Description: File Transfer');
	header('Content-Type: application/octet-stream');
	header('Content-Disposition: attachment; filename="' . $result['file'] . '"');
	header('Content-Length: ' . filesize('../orderfiles/' . $result['file']));
	readfile('../orderfiles/' . $result['file']);

	exit();
	
?>
