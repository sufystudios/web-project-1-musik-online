<?php
############################
## php stuff first #########
############################
session_start();
include('mysql/func_account.php');
include('mysql/func_music.php');
include('getaccountdetails.php');

?>
<!DOCTYPE html>
<!-- hello world javascript -->
<html lang="en" xmlns="http://www.w3.org/1999/xhtml">
  <head>
    <title> DigitalTracks</title>
    <meta charset="utf-8" />
   <link rel="stylesheet" type="text/css" href="css/assg2.css?version=51"></link>
   <link rel="stylesheet" type="text/css" href="css/header.css?version=521"></link>
 <link rel="stylesheet" type="text/css" href="css/pagedivs.css?version=521"></link>


  </head>
  <body>
<? include("header.php");
?>
   <main>
	<?php
	if(true) {
	?>
	
	<?php
		print_song_form("insert.php");
		include("mysql/mysql.php");
		if(isset($_GET['description']) && isset($_GET['description']) && isset($_GET['name']) && isset($_GET['url']) && isset($_GET['artist'])) {
			$artistname="select * from artist where artist_name='" . $_GET['artist'] ."'";	        
			$run=mysql_query($artistname);
			$row=mysql_fetch_array($run);
			if(!isset($row[0]))
			{
				$query="insert into artist(artist_name) values('" .$_GET['artist'] ."')";
				if(mysql_query($query)) {
					echo "New artist created";
					$run=mysql_query($artistname);
					$row=mysql_fetch_array($run);
				} else {
					echo "Error artist error";
				}
			}
			$genrename="select * from genre where genre_name='" .$_GET['genre']. "'";
                        $run=mysql_query($genrename);
                        $row1=mysql_fetch_array($run);
                        if(!isset($row1[0]))
                        {
                                $query="insert into genre(genre_name) values('" .$_GET['genre'] ."')";
                                if(mysql_query($query)) {
                                        echo "New genre created";
                                        $run=mysql_query($genrename);
                                        $row1=mysql_fetch_array($run);
                                } else {
                                        echo "Error genre";
                                }
                        }



			$insertquery = "INSERT INTO track(track_name,track_artist_id,track_filename,track_genre_id,track_description,track_active) VALUES ('" . $_GET['name'] . "','" . $row[0] . "','" . $_GET['url'] . "',' " . $row1[0] . "','" . $_GET['description'] . "','1');";
				
		if (mysql_query($insertquery)) {
    echo "New record created successfully";
} else {
    echo "Error: track ";
}
}
}
else
	echo "You don't have priveledges";

	?>
	<script>
	function validate() {
		if(document.getElementById("name").value=="") {
			return false;
		}
		if(document.getElementById("url").value=="") {
			return false;
		}
		if(document.getElementById("artist").value=="") {
			return false;
		}
		if(document.getElementById("description").value="") {
			return false;
		}
		return true;
	}
	</script>
   </main>    
<?php
include("footer.php");
?>
  </body>
</html>
