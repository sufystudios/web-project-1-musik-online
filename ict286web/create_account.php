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
     <script type="text/javascript" src="./js/forms.js"></script>
     <script type="text/javascript" src="./js/ajax.js"></script>


  </head>
  <body>

<?include('header.php');



if (isset($_GET['email'])) 
	{
	$entered_email = $_GET['email'];

	if(!isset($_GET['state']))	## this means we have just arrive.. no state set

		{

		if(email_exists($entered_email))
		
			{
			?>
			<script language="javascript">
			alert("Your email is already in our system, please login");
			window.document.location.replace('index.php');
			</script>
			<?
			}


		else			## we have landed here. email does not exist so we ask to confirm email.
			{
			?>
			<!-- create account form at top -->
	
			<strong> Please confirm your email address.</strong><br /><br />
			<form name="create" method="get" action="create_account.php" onsubmit="return checkEmailNew();">
			<input type="hidden" name="state" value="confirm">
			<input type="hidden" name="emailFirst" value="<?=$entered_email?>">

			<input title="email" type="text" onfocus="window.document.create.email.value='';" class="textBoxEdit" name="email" value="" /><br /><br />
			<input type="submit" class="clickButtonEdit" value="CREATE ACCOUNT" />
			</form>
			<div  class="warning" id="javascriptResponseNew"></div>
			<?
			}

		}

		
	else	## this means the var state is set, so we have submitted the confirmation email.. if they match then create an account.. if not return to index.

		{


		if (isset($_GET['emailFirst'])  &&   $entered_email == $_GET['emailFirst'] )


			{

			if (is_user_admin($account_id)){$admin=1;}else{$admin=0;}

			$new_password = create_customer_account($entered_email,$admin);
			send_email($entered_email,$new_password);

			?>
			<script language="javascript">
			alert("Your account has been created with the password <?=$new_password?>, this password has been emailed to you (please check your spam),  then login on the home page.");
			window.document.location.replace('index.php');


			</script>
			<?
			}



		else
			{
			?>
			<script language="javascript">
			alert("Your email address entered does not match, please try again");
			window.document.location.replace('index.php');
			</script>
			<?
			}



		}


	}  # end if and email is set

else

	{
	?>
	<script type="javascript">
	window.document.location.replace('index.php');
	</script>
	<?
	}

?>

<div class="footer"> 
<?include('footer.php');?>
</div>


  </body>
</html>


<?


function send_email($entered_email,$new_password)

	{

	$from_add = "fred.bertram@murdoch.edu.au"; 

	$to_add = "$entered_email"; //<-- put your yahoo/gmail email address here

	$subject = "Musi Konline New Account";
	$message = "<html><body>Welcome to Musi Konline !<br /><br /><br />Your password is <strong>$new_password</strong></body></html>";

	$headers  = 'MIME-Version: 1.0' . "\r\n";
	$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
	$headers .= "From: Musi Konline \r\n" . 'Reply-To: '.$from_add."\r\n" . 'X-Mailer: PHP/' . phpversion();

	
	mail($to_add,$subject,$message,$headers);

	}





