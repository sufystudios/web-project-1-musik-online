<?
## turn caching off
header("Cache-Control: no-cache, no-store, must-revalidate"); // HTTP 1.1.
header("Pragma: no-cache"); // HTTP 1.0.
header("Expires: 0"); // Proxies.
?>
<div class="centered">
<img class="mainLogo" src="./images/logo.gif" alt="Musi Konline Logo" />

<div id="menu-outer">
<ul id="horizontal-list">

<li><button class="menuButton"
	onclick="window.document.location.replace('./index.php');" 
		>Main Page</button></li>


<li><button class="menuButton"
		onclick="window.document.location.replace('./music.php');" 
		>Music</button></li>



<? if (!check_admin($account_id))	## don't show about adn help for admin.
	{?>

<li><button class="menuButton"
		onclick="window.document.location.replace('./about.php');" 
		>About Us</button></li>
 


<li><button class="menuButton"
		onclick="window.document.location.replace('./help.php');" 
		>Site Map</button></li>

	<?
	}		## end check if admin adn hide help and about


if ($account_id > 0 && !check_admin($account_id))		## ie someone logged in
{
	?>

<li><button class="menuButton"
		onclick="window.document.location.replace('./account_details.php');" 
		>My Account</button></li>

<?
}




if( check_admin($account_id) )
{

?>

<li><button class="menuButton"
		onclick="window.document.location.replace('./accounts.php');" 
		>Accounts</button></li>



<li><button class="menuButton"
		onclick="window.document.location.replace('./add.php');"
		>Add Songs</button></li>
<?php
}
?>
</ul>


</div>
</div>
