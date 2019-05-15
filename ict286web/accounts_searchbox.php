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
	<form  method="GET" onsubmit="return valsearch(); search_accounts();" action="">
		<label>Search for customer record<br /><br />
		<input type="text"  class="textBox" name="search" id="search" value="<?=$search_string?>"/><br /><br />
		<input type="submit" value="FIND USERS" class="clickButton" />
	</form>

<br />
<br />
<br />

	<input type="button"  class="clickButton" value="CLEAR SEARCH" onClick="window.document.location.replace('accounts.php');" />

<br /><br />
<br />


	<?  	if (is_user_admin($account_id))	
		{
		?>

		<form  method="GET" onsubmit="list_admins();" action="">
			<input type="submit" value="SHOW ADMINS" class="clickButton" />
		</form>
		<?
	}
	?>

<br /><br />



  </body>
</html>
