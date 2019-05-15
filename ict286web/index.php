<?
############################
## php stuff first #########
############################
session_start();
require('mysql/func_account.php');
require('getaccountdetails.php');


## now run a fuction from func_account to return a basket id for the user (if not an admin).. the function will find an unfinished basket or create a new basket.

/*$basket_id = 0 ;   ##for guest users or admin users there is no basket.

if(!is_user_admin($account_id) && $account_id > 0)  ## only if someone logged in.
	
	{

	$basket_id = get_basket_id($account_id);

	}

if(isset($_GET['add_song']) && $basket_id > 0)  #this means we are refreshing the page with an add song clieck request.

	{

	add_song_to_basket($basket_id, $_GET['song_id']);

	}
if(isset($_GET['delete_song']) && isset($_GET['song_id']))
{	
delete_song($_GET['song_id']);
*/
?>
<?
//}
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

<h1>&nbsp;</h1>

<?include('header.php');?>

<main>

<div class="searchbox">
<?include('searchbox.php');?>
</div>





<div id="listbox" class="listbox">
<? 
if (!isset($_GET['search']) && !isset($_GET['artist']) && !isset($_GET['genre']) )   $_GET['search']='featured-music';  # if nothing searched for just list feature rtracks
include("listbox.php");?>
</div>







<div id="basket" class="basket">
<?include('basket.php');?>
</div>





</main>   
 




<div class="footer"> 
<?include('footer.php');?>
</div>


</body>
</html>
