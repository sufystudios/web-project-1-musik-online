<?php
$dbhost = "localhost";
$dbuser = "root";
$dbpass = "";
$dbname = "";
$conn = mysql_pconnect($dbhost,$dbuser,$dbpass) or
	die("connection failed");
$conn2 = mysql_pconnect($dbhost,$dbuser,$dbpass) or
	die("connection failed");


mysql_select_db($dbname) or die("couldn't select db");

?>
