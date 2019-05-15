<?
## turn caching off
header("Cache-Control: no-cache, no-store, must-revalidate"); // HTTP 1.1.
header("Pragma: no-cache"); // HTTP 1.0.
header("Expires: 0"); // Proxies.

?>
<div class="centered">
<img class="mainLogo" src="./images/logo.gif" alt="logo" />

<div id="menu-outer">
<ul id="horizontal-list">

<li><button class="menuButton"
	onClick="window.document.location.replace('./index.php');" 
		>Main Page</button></li>


<li><button class="menuButton"
		onclick="window.document.location.replace('./music.php');" 
		>Music</button></li>


<li><button class="menuButton"
		onclick="window.document.location.replace('./about.php');" 
		>About Us</button></li>
 

<li><button class="menuButton"
		onclick="window.document.location.replace('./help.php');" 
		>Site Map</button></li>



<li><button class="menuButton"
		onclick="window.document.location.replace('./account_details.php');" 
		>My Account</button></li>







</ul>


</div>
</div>
