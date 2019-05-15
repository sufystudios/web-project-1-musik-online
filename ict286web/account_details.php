<?
############################
## php stuff first #########
############################
session_start();
require('mysql/func_account.php');
require('getaccountdetails.php');


## now run a fuction from func_account to return a basket id for the user (if not an admin).. the function will find an unfinished basket or create a new basket.

$basket_id = 0 ;   ##for guest users or admin users there is no basket.

if(!is_user_admin($account_id) && $account_id > 0)
	
	{

	$basket_id = get_basket_id($account_id);

	}


if(isset($_GET['finalize_cart'])) {$finalize_cart = $_GET['finalize_cart'];}  else {$finalize_cart ="";}


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



<?include('header.php');?>

<main>

<div class="searchbox">
<?include('account_searchbox.php');?>
</div>


<div class="accountsLeft">

<?
##########################################
### finalize cart and print a thankyou..
########################################

if($finalize_cart == "yes" )
	{

	finalize_cart($basket_id);
	print "<div style=\"text-align:center;font-size:16px;\">";
	print "<br /> ";
	print "Thankyou for your purchase today!. Click on the link below to view and print your invoice.</div><br /><br /><br /> ";
	}

else
	{
	?>

	<div style="text-align:center;font-size:16px;">
	<br /> 
	Recent <a style="font-family: Helvetica Neue,Helvetica,Arial,sans-serif;color:#F9D0F9;font-size: 1.8em;">Musi kOnline</a> Purchases</div><br /><br /><br /> 
	<?
	}


print_last_five_purchases($account_id);

?>
</div>




<div class="accountsRight" id="invoiceDiv">
<iframe id="invoiceFrame" class="invoiceFrame" />
</div>



























