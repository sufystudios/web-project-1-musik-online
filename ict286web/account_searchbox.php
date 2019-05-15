<?php
include("mysql/mysql.php");


### look for any previous search info to display

if(isset($_GET['search'])) { $search_string = $_GET['search']; }
else {$search_string = ""; }

?>

<br />

	<script>
	function valsearch() { 
	if(document.getElementById("search").value=="") {
		return false;
	}
	return true;
	}
	</script>
	<!--<form  method="GET" onsubmit="return valsearch(); search();" action="">
		<label>Search for invoice number<br /><br />
		<input type="text"  class="textBox" name="search" id="search" value="<?=$search_string?>"/><br /><br />
		<input type="submit" value="Find Invoice No" class="clickButton" />
	</form>-->

<br />
<br />
<br />




<input type="button" class="clickButton" value='Recent Purchases' id='recent' onclick="window.document.location.replace('account_details.php');"><br /><br />

<input type="button" class="clickButton" value='Edit My Account' id='edit' onclick="window.document.location.replace('account_edit.php');"><br />



<br /><br />


 
  </body>
</html>
