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



