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
	<meta name = "viewport" content = "width=device-width, initial-scale = 1.0">
	<title>Lancr.</title>
	<link href="../styles/test.css" rel="stylesheet" type="text/css">
</head>

<body>
<header>
		<img class="logo" src="../logo.svg" alt="logo" width=100 height=100/>
		<nav>
			<ul class="nav__links">
				<li><a href="mainpage.php">Home&nbsp;</a></li>
				<li><a href="profile.php">Profile&nbsp;</a></li>
				<li><a href="message.php">Messages&nbsp;</a></li>
				<li><a href="gigs.php">Gigs&nbsp;</a></li>
				<li><a href="orders.php">Buys&nbsp;</a></li>
				<li><a href="pendingorders.php">Sells&nbsp;</a></li>
			</ul>
		</nav>
		<a href="../func/logout.php">Log out&nbsp;</a>
	</header>
	<div class="container"> 
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
  </div>
</form>



