<?php
$dbhost = "localhost";
$dbuser = "";
$dbpass = "";
$dbname = "";
$conn = mysql_pconnect($dbhost,$dbuser,$dbpass) or

	die("connection failed");
mysql_select_db($dbname) or die("couldn't select db");

?>
