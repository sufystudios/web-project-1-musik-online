<!DOCTYPE html>
<!-- hello world javascript -->
<html lang="en" xmlns="http://www.w3.org/1999/xhtml">
  <head>
    <title> DigitalTracks</title>
    <meta charset="utf-8" />
   <link rel="stylesheet" type="text/css" href="css/q1.css?version=51"></link>   
<link rel="stylesheet" type="text/css" href="css/header.css?version=521"></link>


  </head>
  <body>
   <header>
     <h1> Digital Tracks</h1>
   </header>
   <nav>
     <script type="text/javascript" src="jsnav.js"></script>
   </nav>
   <main>
	<?php
		require("php/mysql.php");
		$query = "SELECT  COUNT(*) FROM admins WHERE username='".$_POST['admin'] ."' AND password='" . $_POST['adminpassword'] . "'";
		$login = mysql_query($query);
		$row = mysql_fetch_array($login);
			if($row[0] == 0) {
				echo "login failed";
			}
		else if($row[0] == 1) {
				echo "Login success";
				session_start();
				$_SESSION['admin']=$_POST['admin'];
			}
	?>
		
   </main>    
    <footer>
      <script type="text/javascript" src="jsfoot.js"></script>
    </footer>  
  </body>
</html>
