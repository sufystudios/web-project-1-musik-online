<?
############################
## php stuff first #########
############################
session_start();
include('mysql/func_account.php');
include('mysql/func_music.php');
include('getaccountdetails.php');
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

<?include('header.php');?>


   <main>
 
<h1>&nbsp;</h1>

	<p class="about">We specialize in selling Single Cd's by Local Artists. From classical to electronica our music will have you dancing or soothing in no time. <br /><br />
	We are based in Perth Australia and provide a connection to Local West Australian Artists. <br /><br />
	We sell CD's instead of MP3's because we like retro and we want you to feel like you are shopping 20 years ago.<br /><br />
	Buy your favorite single one or multiple times to show support for your favorite artists and rememeber your support helps them to make more tracks.<br /><br />
	Our tracks come royalty free so if you want to reuse in any manner you see fit, projects, publications feel free that is part of the deal we provide.<br /><br />
	We started our business in 2017 and due to low operating costs we will continue to provide our services until we can no longer do so.<br /><br />
</p>

   </main>    



<div class="footer"> 
<?include('footer.php');?>
</div>


  </body>
</html>
