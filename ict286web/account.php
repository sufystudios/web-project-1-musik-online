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




   <main>
<?php
	        if(isset($_GET['admlog']))
                unset($_SESSION['admin']);

	if(isset($_SESSION['admin'])) {
		echo "<a href=\"account.php?admlog=true\">Logout of admin</a>";
		echo "<br /><a href=\"insert.php\">Insert Music</a>";
	}
	if(isset($_GET['logout']))
		unset($_SESSION['username']);
	if(isset($_SESSION['username']) && $_SESSION['username']!="") {
		echo "WELCOME " . $_SESSION['username'];
	

?>
<form method="POST" action="account.php">
	<br /><label>Enter name<input type="text" name="name" id="name" /></label>
	<br /><label>Enter address<input type="text" name="address" id="address" /></label>
	<br /><label>Enter phone<input type="text" name="phone" id="phone" /></label>
	<br /><label>Enter Email<input type="text" name="email" id="email" /></label>
	<br /><input type="submit">
</form>
<?php 
	require("php/mysql.php");

		
	if(isset($_POST['name']) && $_POST['name']!="") {
	$query="UPDATE users SET name='" .$_POST['name'] . "' WHERE username='" . $_SESSION['username'] . "'";
	if(mysql_query($query)) {
	}
	else 
		echo "error";
}        if(isset($_POST['address']) && $_POST['address']!= "") {
        $query="UPDATE users SET address='" .$_POST['address'] . "' WHERE username='" . $_SESSION['username'] . "'";
        if(mysql_query($query)) {
        }
        else
                echo "error";
}
        if(isset($_POST['phone'] ) && $_POST['phone']!="") {
        $query="UPDATE users SET phone='" .$_POST['phone'] . "' WHERE username='" . $_SESSION['username'] . "'";
        if(mysql_query($query)) {
        }
        else
                echo "error";
}
        if(isset($_POST['email']) && $_POST['email']!="") {
        $query="UPDATE users SET email='" .$_POST['email'] . "' WHERE username='" . $_SESSION['username'] . "'";
        if(mysql_query($query)) {
        }
        else
                echo "error";
}

        echo "current info<br />";
        $query="SELECT * FROM users WHERE username='" . $_SESSION['username'] . "'";
        $run=mysql_query($query);
        $row=mysql_fetch_array($run);
        echo "Name =" . $row[2];
        echo "<br />Address =" . $row[3];
        echo "<br />Phone =" . $row[4];
        echo "<br />Email =" .$row[5];
	echo "<br /><a href=\"account.php?logout=true\">Logout</a>";
	}
	else {
?>

	<form onsubmit="return valcreate();" method="POST" action="createuser.php">
		<label>Create Account Username:<input type="text" name="user" id="user" /></label>
		<br /><label>Create Account Password:<input type="text" name="password" id="password"></label>
		<br /><input type="submit" />
	</form>
	
	<form onsubmit="return vallogin();" method="POST" action="login.php">
		<label>Login: Username<input type="text" name="userli" id="userli" />
		<br /><label>Login: Password<input type="text" name="passli" id="passli" />
		<br /><input type="submit" />
	</form>
	<form onsubmit="return valadmin();" method="POST" action="adminlogin.php">
		<label><br/>Superuser Username: <input type="text" name="admin" id="admin" /></label>
		<br /><label>Admin password<input type="password" name="adminpassword" id="adminpassword" /></label>
		<br /><input type="submit" />
	</form>
<?php
}
?>
   </main>    


<div class="footer"> 
<?include('footer.php');?>
</div>



  </body>
</html>
