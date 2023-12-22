<?php
	unlink("db.sqlite");
	session_start();
	session_destroy();
	header('Location: index.php');
?>
