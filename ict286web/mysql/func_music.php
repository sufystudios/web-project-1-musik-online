<?





function set_track_to_not_active($track_id) {
	
	$sql = "update track set track_active='0' where track_id='$track_id'";
	mysql_query($sql);
}





function update_track_details($track_id, $name, $description, $artist, $genre,  $track_active)

	{

	$SQL = " UPDATE track SET track_name='$name', track_description='$description', track_artist_id='$artist', ";
	$SQL.= " track_genre_id='$genre',track_active='$track_active' WHERE track_id='$track_id'  ";
	$result=mysql_query($SQL);


	}



function update_tracK_file($track_id,$target_file)

	{

	$SQL = " UPDATE track SET track_filename='$target_file' WHERE track_id='$track_id' ";
	$result=mysql_query($SQL);
	}



function track_in_basket($track_id,$basket_id)

	{
	$track_in_basket = 0;


	$SQL = " SELECT * from basket_items where basket_id='$basket_id' and track_id='$track_id' ";
	$result=mysql_query($SQL);
	while($row=mysql_fetch_array($result))

		{
		$track_in_basket=1;
		}

	return $track_in_basket;

	}



function get_genre_array()
	{

	$genres = array();


	## first make sure teh default genre_id 0 is at the top of the list.
	$SQL = " SELECT genre_id, genre_name FROM genre WHERE genre_id=0  ";
	$result=mysql_query($SQL);
	while($row=mysql_fetch_array($result))

		{
		$genre_id = $row[0];
		$genres{"$genre_id"}="$row[1]";
		}

	$SQL = " SELECT genre_id, genre_name FROM genre WHERE genre_id>0 ORDER by genre_name  ";
	$result=mysql_query($SQL);
	while($row=mysql_fetch_array($result))

		{
		$genre_id = $row[0];
		$genres{"$genre_id"}="$row[1]";
		}

	return $genres;
	}



function get_artist_array()
	{

	$artists = array();

	## first make sure teh default artist_id 0 is at the top of the list.
	$SQL = " SELECT artist_id, artist_name FROM artist WHERE artist_id=0  ";
	$result=mysql_query($SQL);
	while($row=mysql_fetch_array($result))

		{
		$artists[$row[0]]="$row[1]";
		}


	$SQL = " SELECT artist_id, artist_name FROM artist WHERE artist_id>0 ORDER by artist_name  ";
	$result=mysql_query($SQL);
	while($row=mysql_fetch_array($result))

		{
		$artists[$row[0]]="$row[1]";
		}

	return $artists;
	}







function list_matched_track_list($searchString)	
	{

	$match_string = "";

	include('mysql.php');
	$SQL = " SELECT track_name FROM track WHERE track_name LIKE '%$searchString%' OR  track_name LIKE '$searchString%' ORDER BY track_name LIMIT 0,15";
	$chkadm=mysql_query($SQL);
	while($row=mysql_fetch_array($chkadm))

		{
		$match_string.="$row[0]<br />";
		}

	if(strlen($match_string)>1)

		{
		echo "Similar existing tracks in the store<br /><br />$match_string";


		}


	}



function add_track_to_database($track_name)

	{
	include('mysql.php');
	$genrename="INSERT INTO track (track_name,track_artist_id,track_genre_id,track_active,track_soh) VALUES ('$track_name',0,0,0,0)";
        $run=mysql_query($genrename);

	## now we should return the id
	
	$SQL = " SELECT track_id FROM track WHERE track_name = '$track_name' ;  ";
	$chkadm=mysql_query($SQL);
	while($row=mysql_fetch_array($chkadm))

		{
		$track_id=$row[0];
		}

       return $track_id;

	}
	









function get_track_name($songid)

	{
	$query= "   SELECT track.track_name 	FROM track
	WHERE track_id = '$songid' ";
	$run=mysql_query($query);

	$row=mysql_fetch_array($run);
	$trackname = $row[0];	# track_name
	return $trackname;

	}




function get_song_details($songid)

	{
	$query= "
	SELECT track.track_name, track.track_filename, genre.genre_name, artist.artist_name, track.track_description, track.track_active, genre.genre_id, artist.artist_id, track_soh
	FROM track
	INNER JOIN artist ON track.track_artist_id = artist.artist_id
	INNER JOIN genre ON track.track_genre_id = genre.genre_id
	WHERE track_id = '$songid' ";
	$runsong=mysql_query($query);
	$rowsong=mysql_fetch_array($runsong);


	$songdetails[0] = $rowsong[0];	# track_name
	$songdetails[1] = $rowsong[1];	# track_file_name
	$songdetails[2] = $rowsong[2];	# genre_genre_name
	$songdetails[3] = $rowsong[3];	# artist_name
	$songdetails[4] = $rowsong[4];	# track_description
	$songdetails[5] = $rowsong[5];	# track_active

	$songdetails[6] = $rowsong[6];	# genre_id
	$songdetails[7] = $rowsong[7];	# artist_id
	$songdetails[8] = $rowsong[8];	# track_soh



	return $songdetails;

	}

?>
