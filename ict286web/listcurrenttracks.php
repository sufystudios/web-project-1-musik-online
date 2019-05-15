<?
############################
## php stuff first #########
############################
session_start();
include('mysql/func_music.php');

############################
## end php prelude #########
############################

?>

<!DOCTYPE html>
<html lang="en" xmlns="http://www.w3.org/1999/xhtml">
  <head>
    <title> DigitalTracks</title>
    <meta charset="utf-8" />
   <link rel="stylesheet" type="text/css" href="css/iframe.css?version=521"></link>

     <script type="text/javascript" src="./js/forms.js"></script>

  </head>
  <body>
<main>




<?


if(isset($_GET['searchString'])) 
	
	{
	$searchString =  $_GET['searchString'];

	if(strlen($searchString)>0) list_matched_track_list($searchString);

	}
