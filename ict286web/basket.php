<?


$num_items_in_basket = 0;

if(session_id() == '') {

session_start();
}
include_once("mysql/func_account.php");
include_once("mysql/func_music.php");
include_once("getaccountdetails.php");
## now run a fuction from func_account to return a basket id for the user (if not an admin).. the function will find an unfinished basket or create a new basket.

$basket_id = 0 ;   ##for guest users or admin users there is no basket.

if(!is_user_admin($account_id) && $account_id > 0 )  ### also if someone is logged in.. 

        {

        $basket_id = get_basket_id($account_id);

        }

if(isset($_GET['add_song']) && $basket_id > 0)  #this means we are refreshing the page with an add song clieck request.

        {

        add_song_to_basket($basket_id, $_GET['song_id']);

        }


if(isset($_GET['remove_song']) && $basket_id > 0)  #this means we are refreshing the page with an add song clieck request.

        {

        delete_from_basket($basket_id, $_GET['song_id']);

        }



if(isset($_GET['update_basket']) && $basket_id > 0)  #this means we are have chagned a quantity on one of the tracks

        {
        update_basket_quantities($basket_id, $_GET['songid'], $_GET['quantity']);
        }



?>

<div class="accountbox">
<br />

Welcome : <strong><?=$fullname?></strong>  <br /><br />


<?
### now IF there is a valid accountid show the basket details.. else show a create account system




if ($account_id > 0 )

	{ 

	if (!is_user_admin($account_id))		## we only show a basket for non admin users..

		{

		echo "You have <strong>"; print_number_of_items_in_basket($basket_id); echo "</strong> items in your basket<br /><br />";

		$num_items_in_basket = print_basket_items($basket_id);  
	

		}


	else 	## user is admin.. show a form to crate a new admin user

		{
		?>

		<!-- create account form at top -->
	
		<strong>Create new ADMIN account..<br /><br />

		<form name="create" method="get" action="create_account.php" onsubmit="return checkEmailNew();">

		<input title="email" type="text" onfocus="window.document.create.email.value='';" class="textBox" name="email" value="{email address}" /><br /><br />

		<input type="submit" class="clickButton" value="CREATE ACCOUNT" />

		</form>

		<div  class="warning" id="javascriptResponseNew"></div>

		<br /><br /><br /><br />

		<?

		}


	

	print "<br /><br /><br />";


	if($num_items_in_basket)
		{
		?>
		<input type="button" class="clickButton" value='Checkout !' onClick="window.document.location.replace('basket_summary.php');">
		<?
		}
	else
		{
		?>
		<br />
		<?
		}

		?>



	<br /><br /><br /><br />


	<form name="logout" method="get">
	<input type="hidden" name="logoutUser" value='yes'> 
	<input type="submit" class="clickButton" value='Logout'>
	</form>
	<br /><br />
	<?
	}





else
	## show login form as ther is no use logged in with a valid account
	{
	?>

	<!-- create account form at top -->
	
	<strong>Please note:</strong> You may browse our music, but to be able to purchase you will need an account.<br /><br />

	<form name="create" method="get" action="create_account.php" onsubmit="return checkEmailNew();">

	<input title="email" type="text" onfocus="window.document.create.email.value='';" class="textBox" name="email" value="{email address}" /><br /><br />

	<input type="submit" class="clickButton" value="CREATE ACCOUNT" />

	</form>

	<div  class="warning" id="javascriptResponseNew"></div>

	<br /><br /><br /><br />





	<!-- existing customer login form -->

	<form name="loginEmail" method="get" id="loginEmail" onsubmit="return checkEmailExisting(); login();">

	<strong>Allready a listener?</strong><br /><br />

	<input  title="email"  type="text" onfocus="window.document.loginEmail.email.value='';"  class="textBox" name="email" value="{username or email address}" /><br /><br />

	<input  title="password" type="password" class="textBox" name="password" /><br /><br />

	<input type="submit" class="clickButton" value="LOGIN" />

	</form>

	<div  class="warning" id="javascriptResponseExisting"></div>

	<? if(strlen($password)>0 && !$account_id){echo'<div class="warning">Incorrect login details!</div>';}   ?>


	<?
	}


?>
<br />
</div>


