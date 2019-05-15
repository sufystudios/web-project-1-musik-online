<?
############################
## php stuff first #########
############################


if (!isset($_SESSION)) { session_start(); }


include_once("mysql/func_account.php");
include_once("mysql/func_music.php");
include_once("getaccountdetails.php");
## now run a fuction from func_account to return a basket id for the user (if not an admin).. the function will find an unfinished basket or create a new basket.

$basket_id = 0 ;   ##for guest users or admin users there is no basket.

if(!is_user_admin($account_id))

        {

        $basket_id = get_basket_id($account_id);

        }



############################
## end php prelude #########
############################

?>

<!DOCTYPE html>
<!-- hello world javascript -->
<?php
include("mysql/mysql.php");
?>
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
 

<?include('header_checkout.php');?>


   <main>


<div class="searchbox">
<?include('searchbox.php');?>
</div>




<div id="basket" class="listbox">
<? $_GET['basket_id']=$basket_id;
include("basket_summary_inner.php");?>
</div>










   </main>    



<div class="footer"> 
<?include('footer.php');?>
</div>


  </body>
</html>
