<?php
$dbhost = "localhost";
$dbuser = "X32760263";
$dbpass = "X32760263";
$dbname = "X32760263";
$conn = mysql_pconnect($dbhost,$dbuser,$dbpass) or

	die("connection failed");
mysql_select_db($dbname) or die("couldn't select db");

?>
