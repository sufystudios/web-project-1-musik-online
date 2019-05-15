<?php
include_once("mysql/mysql.php");
include_once("mysql/func_music.php");
$songarray=array();

$count=0;
$query="select track_id from track";
$run = mysql_query($query);
while($row=mysql_fetch_array($run)) {
	array_push($songarray,$count,get_song_details($row[0]));
}
$output=json_encode($songarray);
echo $output;
?>
