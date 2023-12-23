<?php
	session_start();
	
	/* Save a handler to fetch category names */
	$db = new SQLite3('db.sqlite');
	$handler = $db->query('SELECT name FROM Categories');
?>

<!DOCTYPE html>

<form method="post">
	
  <label for="desc">Description:</label><br>
  <input type="text" id="desc" name="desc"><br><br>
  
  <label for="category">Category:</label><br>
  <select name="category" id="category">
	<option value="">--Please choose one--</option>
		<?php listCategoryNames($handler);?>
  </select><br><br>
  
  <label for="price">Price:</label><br>
  <input type="number" id="price" name="price"><br><br>
  
  <input type="submit" formaction="addgig.php" value="Add"><br>
</form>


<?php
	function listCategoryNames($handler)
	{
		/* Fetch category names */
			while(true)
			{
					$nextresult = $handler->fetchArray();
				
					if($nextresult == false)
						break;
				
					$name = $nextresult['name'];
					echo 
					'
					<option value="' 
						. $name . '">' 
							. $name 
								. '</option>
					';
			}	
		
	}
	?>
