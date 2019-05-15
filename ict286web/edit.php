<?
############################
## php stuff first #########
############################
session_start();
include('mysql/func_account.php');
include('mysql/func_music.php');
include('getaccountdetails.php');


## now run a fuction from func_account to return a basket id for the user (if not an admin).. the function will find an unfinished basket or create a new basket.

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
   <link rel="stylesheet" type="text/css" href="./css/assg2.css?version=52"></link>
   <link rel="stylesheet" type="text/css" href="./css/header.css?version=521"></link>
   <link rel="stylesheet" type="text/css" href="./css/pagedivs.css?version=521"></link>
   <script src="./js/ajax.js"></script>

    <link rel="stylesheet" href="./css/dropzone.css">


  </head>


  <script src="./js/dropzone.js"></script>


  <body>


<?include('header.php');?>

<main>




<div class="searchbox">
<?include('searchbox.php');?>
</div>




<div  id="listbox" class="listbox">
<?  ## $_GET['song_id']=$song_id;
include('songdetails.php');   ?>
<br />




<?
include('editbox.php');
?>
<br />
</div>



</main>   
 




<div class="footer"> 
<?include('footer.php');?>
</div>


  </body>
</html>
