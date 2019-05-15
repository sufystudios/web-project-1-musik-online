<?
############################
## php stuff first #########
############################
session_start();

include("mysql/mysql.php");
include("mysql/func_music.php");
include('mysql/func_account.php');
include('getaccountdetails.php');

ini_set('upload_tmp_dir','./Audio'); 
if(isset($_POST['song_id'])) $song_id=$_POST['song_id'];

$track_name = get_track_name($song_id);




############################
## end php prelude #########
############################

?>

<!DOCTYPE html>
<!-- hello world javascript -->
<html lang="en" xmlns="http://www.w3.org/1999/xhtml">
  <head>
    <title> DigitalTracks</title>
    <meta charset="utf-8" />
   <link rel="stylesheet" type="text/css" href="css/assg2.css?version=52"></link>
   <link rel="stylesheet" type="text/css" href="css/header.css?version=521"></link>
   <link rel="stylesheet" type="text/css" href="css/pagedivs.css?version=521"></link>


  </head>
  <body>
 
<?


$uploaddir = './Audio/';

$canUpload = 1;

$target_file = $uploaddir . $song_id  . strtolower(cleanUp($track_name) );

$track_file_name = $song_id  . strtolower(cleanUp($track_name) );		## this is for the db



$fileType = pathinfo($target_file,PATHINFO_EXTENSION);


// only mp3

if($fileType != "mp3" ) 
	{
    	echo "Sorry, only mp3 files here!";
    	$canUpload = 0;
	
}


// file size
if ($_FILES["newmp3"]["size"] > 58000000) {
    echo "Files must be less that 3MB";
    $uploadOk = 0;
 
}






if ($canUpload && move_uploaded_file($_FILES["newmp3"]["tmp_name"], $target_file)) {


	update_track_file($song_id,$track_file_name);


	?>
	<script type="text/javascript">window.document.location.replace("edit.php?song_id=<?=$song_id?>");</script></body>
	<?


    } else {
        echo "File Upload Error.";

    }




function cleanUp($string) {
   $string = str_replace(' ', '', $string); // Replaces all spaces with hyphens.

   $string = preg_replace('/\.mp3/i', '', $string); // deletes extension.
   $string =  preg_replace('/[\-]/', '', $string); // Removes hypens
   $string =  preg_replace('/[^A-Za-z\-]/', '', $string); // removes illegal start chars
   $string = $string . ".mp3";
	
   return $string;
}







