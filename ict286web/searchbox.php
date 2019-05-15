<?php
include("mysql/mysql.php");


### look for any previous search info to display

if(isset($_GET['search'])) { $search_string = $_GET['search']; }
else {$search_string = ""; }

?>

<br />

	<script>
	function valsearch() { 
	if(document.getElementById("search").value=="") {
		return false;
	}
	return true;
	}
	</script>
	<form  method="get" onsubmit="return valsearch(); search();" action="#">
		<label>Search for artist or song name<br /><br />
		<input type="text"  class="textBox" name="search" id="search" value="<?=$search_string?>" /></label><br /><br />
		<input type="submit" value="FIND SONGS" class="clickButton" />
	</form>

<br />


<?php


	$query = mysql_query("SELECT artist_id, artist_name FROM artist where artist_id>0 order by artist_name");
	echo "<br /><br /><strong>Artists</strong><br />";
	while($row=mysql_fetch_row($query))
		{
		echo "<input type=\"button\" class=\"clickButton\" value='$row[1]' id='_$row[0]' onclick=\"artist(this.id)\" /><br />";
		}



	$query = mysql_query("SELECT genre_id, genre_name from genre where genre_id > 0 order by genre_name");
	echo "<br /><strong>Genres</strong><br />";
	while($row=mysql_fetch_row($query)) 
		{
		echo "<input type=\"button\" class=\"clickButton\" value='$row[1]' id='_$row[0]' onclick=\"genre(this.id)\" /><br />";

		}


?>


<br /><br />



