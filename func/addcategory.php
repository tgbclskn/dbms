<?php
	$q = '
		INSERT INTO Categories(name)
		values("' . $_POST['cat'] . '")
		';
	$db = new SQLite3('../db.sqlite');
	$db->query($q);
	$db->close();
	header('Location: ../page/admin.php');
?>
