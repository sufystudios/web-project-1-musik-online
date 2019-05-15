<?php
include_once("mysql/mysql.php");
include_once("mysql/func_music.php");
$songarray=array();

$count=0;
$query="select artist_name, artist_id from artist";
$run = mysql_query($query);
while($row=mysql_fetch_array($run)) {
	if($row[1]!=0) {	
	$artist=new \stdClass();	
	$artist->name=$row[0];
	$artist->id=$row[1];	
	array_push($songarray,$artist);
	}
}
$output=json_encode($songarray);
echo $_GET['callback'] . '('.json_encode($output).')';

?>
