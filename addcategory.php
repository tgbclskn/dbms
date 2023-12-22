<?php
	$q = '
		INSERT INTO "Category"(name)
		values("' . $_POST['cat'] . '")
		';
	$db = new SQLite3('db.sqlite');
	$db->query($q);
	$db->close();
	header('Location: admin.php');
?>
