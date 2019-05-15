<?php
$dbhost = "localhost";
$dbuser = "X31550821";
$dbpass = "X31550821";
$dbname = "X31550821";
$conn = mysql_pconnect($dbhost,$dbuser,$dbpass) or

	die("connection failed");
mysql_select_db($dbname) or die("couldn't select db");

?>
