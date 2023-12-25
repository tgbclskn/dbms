<?php
function listCategoryNames()
{
	$db = new SQLite3('../db.sqlite');
	$handler = $db->query('SELECT name FROM Categories');
	$s = "";
	/* Fetch category names */
		while(true)
		{
				$nextresult = $handler->fetchArray();
			
				if($nextresult == false)
					break;
			
				$name = $nextresult['name'];
				$s = $s . '
				<option value="' 
					. $name . '">' 
						. $name 
							. '</option>
				';
		}	
	return $s;
}
?>

