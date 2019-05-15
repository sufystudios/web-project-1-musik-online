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


<!--  https://bootstrapcreative.com/pattern/chronological-site-map-template/ -->



   <main>

<div class="container">
  <h1>Musi Konline Site Map</h1>

  <ul class="nav nav-pills">
    <li ><a href="index.php">Main Page with Featured Songs</a></li>
    <li><a href="music.php">All Music Listed and Searchable</a></li>
    <li><a href="about.php">About Us</a></li>
    <li><a href="help.php">Site Map (this)</a></li>
  </ul>





   <?if($account_id > 0)  ## only if someone logged in.
	
	{
	?>	
	<h2>Features Available to Registered Users</h2>
    	<div class="row">
      	<div class="col-md-3">
        <ul>
          <li><a href="account_details.php">Purchase History</a></li>
          <li><a href="account_edit.php">Edit Account Details</a></li>
         </ul>
        </div>
       </div>
	<?
	}


else

	{
	?>	
	<h2>More information is available once you register and login</h2>
    	<div class="row">
      	<div class="col-md-3">

        </div>
       </div>
	<?
	}
	?>

</div>

<br /><br />
<div class="container">

<h1>Company Information</h1>
<br />
<pre>
MusiKonline est. 2017

Name: MusiKonline
Address: 100 Scarborough Beach Road, OSBORNE PARK WA, 6017
Phone: 94331000
Email: admin@musikonline.com

Tidak Banyak Waktu Pty Ltd ACN 123 123 123 as trustee for
the Alpine Family Trust T/As Musi Konline.

ABN: 36 222 000 111

Key employees: Craig Phoebe Frederick Bertram

</pre>

</div> 

   </main>   
 




<div class="footer"> 
<?include('footer.php');?>
</div>


  </body>
</html>
