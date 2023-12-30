<?php
	session_start();
	
	if(!isset($_SESSION['user']))
		{
			echo 'You are not logged in.';
			echo '<br><a href="index.php">go back</a>';
			exit();
		}
	
	include '../include/listCatNames.php';
?>

<!DOCTYPE html>

<head>
	<link href="../styles/style.css" rel="stylesheet" type="text/css">
</head>

<a href="mainpage.php">Mainpage&nbsp;</a>
<a href="profile.php">Profile&nbsp;</a>
<a href="message.php">Message&nbsp;</a>
<a href="gigs.php">Gigs&nbsp;</a>
<a href="orders.php">Buys&nbsp;</a>
<a href="pendingorders.php">Sells&nbsp;</a>
<a href="../func/logout.php">Log out&nbsp;</a><br><br>

<form method="post">
	
  <label for="desc">Description:</label><br>
  <input type="text" id="desc" name="desc"><br><br>
  
  <label for="category">Category:</label><br>
  <select name="category" id="category">
	<option value="">--Please choose one--</option>
		<?php 
			echo listCategoryNames();
		?>
  </select><br><br>
  
  <label for="price">Price:</label><br>
  <input type="number" id="price" name="price"><br><br>
  
  <input type="submit" formaction="../func/addgig.php" value="Add"><br>
</form>



