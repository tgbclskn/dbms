<!DOCTYPE html>


<?php 
	session_start();
	
	if(!isset($_SESSION['user']))
		{
			echo 'You are not logged in.';
			echo '<br><a href="mainpage.php">go back</a>';
			exit();
		}
			
?>

<a href="mainpage.php">Mainpage&nbsp;</a>
<a href="profile.php">Profile&nbsp;</a>
<a href="message.php">Message&nbsp;</a>
<a href="gigs.php">Gigs&nbsp;</a>
<a href="orders.php">Buys&nbsp;</a>
<a href="pendingorders.php">Sells&nbsp;</a>
<a href="../func/logout.php">Log out&nbsp;</a><br><br>
<a href="message.php?clear">Clear Messages</a><br><br>

<?php
	if(isset($_GET['send']))
		send();
	elseif(isset($_GET['clear']))
		clear();
	elseif(isset($_GET['to']))
		type();
	else
		read();
		
	exit();
?>

<?php

/* Message typing screen */
function type() : void 
{
	echo '<h4>Message To: ' . $_GET['to'] . '</h4><br>';
	
	/* Get user id of sender/receiver */

	$db = new SQLite3('../db.sqlite', SQLITE3_OPEN_READONLY);
	
	$q = '
		SELECT sender.id as sender,
			   receiver.id as receiver
		FROM Users sender,
			 Users receiver
		WHERE sender.name = "' . $_SESSION['user'] . '" AND 
			  receiver.name = "' . $_GET['to'] . '"
	';
	
	$result = $db->query($q)->fetchArray();
	$sender = $result['sender'];
	$receiver = $result['receiver'];

	echo '
		<form method="post">
			<textarea id="mes" name="mes" rows="5" cols="50"></textarea><br>
			<input type="submit" formaction="message.php?send&to=' . $_GET['to'] . '" 
								 value="send">
		</form>
	';
	$db->close();
	exit();
		
}

function send() : void
{
	/* Get user id of sender/receiver */

	$db = new SQLite3('../db.sqlite', SQLITE3_OPEN_READWRITE);
	
	$q = '
		SELECT sender.id as sender,
			   receiver.id as receiver
		FROM Users sender,
			 Users receiver
		WHERE sender.name = "' . $_SESSION['user'] . '" AND 
			  receiver.name = "' . $_GET['to'] . '"
	';
	
	$result = $db->query($q)->fetchArray();
	$sender = $result['sender'];
	$receiver = $result['receiver'];

	$text = $_POST['mes'];
	$date = date("Y-m-d H:i:s");
	
		
	/* Insert message into DB */
	
	$q = '
		INSERT INTO Messages(senderid,receiverid,text,date)
		Values(' . $sender . ',' . $receiver . ',"' . $text . '","' . $date . '")'
		;

	$db->exec($q);
	$db->close();
	header('Location: message.php');
	exit();
}

function read() : void
{
	/* List messages */
	
	$db = new SQLite3('../db.sqlite', SQLITE3_OPEN_READONLY);

	$q = '
		SELECT sender.name 		as sender,
			   receiver.name	as receiver,
			   M.text	   		as text,
			   M.date	   		as date
		FROM   Users sender,
			   Users receiver,
			   Messages M
		WHERE M.receiverid = receiver.id AND
			  M.senderid = sender.id AND 
			  (sender.name = "' . $_SESSION['user'] . '" OR 
			   receiver.name = "' . $_SESSION['user'] . '") 
		ORDER BY date DESC
	';
	

	$handler = $db->query($q);
	
	while(true)
	{
		$result = $handler->fetchArray();
		if($result == false)
			break;

		
		$receiver = $result['receiver'];
		$sender = $result['sender'];
		$text = $result['text'];
		$date = $result['date'];
		
		echo 'FROM: <a href="message.php?to=' . $sender . '">' . $sender . '</a>' 
		   . ' TO: <a href="message.php?to=' . $receiver . '">' . $receiver . '</a>' 
		   . ' DATE: ' . $date 
		   . '<br>' . $text . 
		   '<br><br>';
		
	}
	
	$db->close();
	exit();
}

function clear() : void
{
	$q = '
		DELETE FROM Messages
	';
	
	$db = new SQLite3('../db.sqlite', SQLITE3_OPEN_READWRITE);

	$db->exec($q);
	$db->close();
	header('Location: message.php');

}

?>



