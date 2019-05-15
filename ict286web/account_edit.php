<?
############################
## php stuff first #########
############################
session_start();
require('mysql/func_account.php');
require('getaccountdetails.php');


## now run a fuction from func_account to return a basket id for the user (if not an admin).. the function will find an unfinished basket or create a new basket.

$basket_id = 0 ;   ##for guest users or admin users there is no basket.

if(!is_user_admin($account_id) && $account_id > 0 )
	
	{

	$basket_id = get_basket_id($account_id);

	}



############################
## end php prelude #########
############################

$existing_username = 0; ## used to show warning if user attempts to set to an existing username


if(isset($_POST['update_account'])) 

	{
	## run something to update the account

	$customer_name = $_POST['customer_name'];
	$customer_name = preg_replace("/[;'&\"]/","",$customer_name);


	$customer_username = $_POST['customer_username'];
	$customer_username = preg_replace("/[;'&\"]/","",$customer_username);


	$customer_email = $_POST['customer_email'];
	$customer_email = preg_replace("/[;'&\"]/","",$customer_email);

	$customer_add1 = $_POST['customer_add1'];
	$customer_add1 = preg_replace("/['&\"]/","",$customer_add1);

	$customer_add2 = $_POST['customer_add2'];
	$customer_add2 = preg_replace("/['&\"]/","",$customer_add2);

	$customer_add3 = $_POST['customer_add3'];
	$customer_add3 = preg_replace("/['&\"]/","",$customer_add3);

	$customer_state = $_POST['customer_state'];
	$customer_state = preg_replace("/['&\"]/","",$customer_state);

	$customer_pc = $_POST['customer_pc'];
	$customer_pc = preg_replace("/['&\"]/","",$customer_pc);

	$current_username = $_POST['current_username'];	# this is sent to teh function, so if the chosen new username is already taken we draw back to this advise on the form.

	if(strlen($customer_username ) > 2 &&  strlen($customer_name ) > 2)
		{
		$existing_username = update_customer_account($account_id,$customer_name,$customer_username,$customer_email,$customer_add1,$customer_add2,$customer_add3,$customer_state,$customer_pc,$current_username);
		}


	}





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

<?
if(check_admin($account_id))
	{
	include('accounts_searchbox.php');
	}
else
	{
	include('account_searchbox.php');
	}

?>
</div>




<div class="listbox">

<?
##########################################
### print account edit form ##############
##########################################

$customer_details = get_customer_details($account_id);
?>
<br>
<form name="account_edit" class="centered" method="POST">

	<div id="left" style="width:49%;float: left; ">


	<input type="hidden" name="update_account" value="yes" />
	<input type="hidden" name="customer_email" value="<?=$customer_details[2];?>" />
	<input type="hidden" name="current_username" value="<?=$customer_details[10];?>" />



	<label><a  class="formLabels">Full Name:&nbsp;</a><input type="text" class="textBoxEditLong" name="customer_name" value="<?=$customer_details[1];?>"></label><br /><br />


	<label><a  class="formLabels">UserName:&nbsp;</a><input type="text" class="textBoxEditLong" name="customer_username" value="<?=$customer_details[10];?>"></label><br />


	<?if($existing_username > 0){echo "<a style=\"color:red;\">The username requested is already in use !  ";}?>

<br />
	<a  class="formLabels">Email: &nbsp; &nbsp; &nbsp;&nbsp;</a><?=$customer_details[2];?><br /><br />
	<br />

	<input type="submit" class="clickButtonUpdateCentered " value="Update Account" method="POST">
	</div>



	<div id="right" style="width:49%;postition:relative; float: right;    display: inline-block;">
	<label><a  class="formLabels">Address 1:</a><input type="text" class="textBoxEditLong" name="customer_add1" value="<?=$customer_details[5];?>"></label><br /><br />

	<label><a  class="formLabels">Address 2:</a><input type="text" class="textBoxEditLong" name="customer_add2" value="<?=$customer_details[6];?>"></label><br /><br />

	<label><a  class="formLabels">Address 3:</a><input type="text" class="textBoxEditLong" name="customer_add3" value="<?=$customer_details[7];?>"></label><br /><br />

	<label>	<a class="formLabels">State:</a>

	<select class="selectBoxEdit" name="customer_state" >

	<?print_state_select($customer_details[8]);?>

	</select>


</label>
	&nbsp; &nbsp; &nbsp; &nbsp; &nbsp;

	<label><a  class="formLabels">PC:</a><input type="text" class="textBoxEdit" name="customer_pc" value="<?=$customer_details[9];?>"></label><br /><br />

	<br />
	

	</div>



</form>

</div>

<div class="accountsRight" id="invoiceDiv">
</div>





<?

function print_state_select($current_state)  ## used for the select box above
	{

	echo "<option value = \"ACT\" "; if($current_state=="ACT"){print " selected ";}; echo ">ACT</option>\n";
	echo "<option value = \"NSW\" "; if($current_state=="NSW"){print " selected ";}; echo ">NSW</option>\n";
	echo "<option value = \"QLD\" "; if($current_state=="QLD"){print " selected ";}; echo ">QLD</option>\n";
	echo "<option value = \"TAS\" "; if($current_state=="TAS"){print " selected ";}; echo ">TAS</option>\n";
	echo "<option value = \"VIC\" "; if($current_state=="VIC"){print " selected ";}; echo ">VIC</option>\n";
	echo "<option value = \"NT\" "; if($current_state=="NT"){print " selected ";}; echo ">NT</option>\n";
	echo "<option value = \"WA\" "; if($current_state=="WA"){print " selected ";}; echo ">WA</option>\n";
	}


























