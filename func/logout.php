<?php
	session_start();
	session_destroy();
	session_start();
	$_SESSION = array("first_visit" => false);
	header('Location: ../page/index.php');

?>
