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
   <link rel="stylesheet" type="text/css" href="css/assg2.css?version=52"></link>
   <link rel="stylesheet" type="text/css" href="css/header.css?version=521"></link>
   <link rel="stylesheet" type="text/css" href="css/pagedivs.css?version=521"></link>

     <script type="text/javascript" src="./js/forms.js"></script>

     <script type="text/javascript" src="./js/ajax.js"></script>

  </head>


  <body>


<?include('header.php');?>

<main>




<div class="searchbox">
<?include('add_searchbox.php');?>
</div>




<div class="listbox" style="height:350px;">
<?
include('addbox.php');
?>
<br />
</div>


<div class="basket">
<?include('basket.php');?>
</div>
  
</main>  

<div class="footer"> 
<?include('footer.php');?>
</div>






</body>
</html>
