<? 
$connect = odbc_connect("SageLine50v8", "manager", "");


$query = " select MAX(INVOICE_NUMBER) AS max_num FROM INVOICE ";


# perform the query
$result= odbc_exec($connect, $query);

# fetch the data from the database
while(odbc_fetch_row($result)){
  $max_num = odbc_result($result, 1);

}


$max_num = $max_num - 45;  # get last 25


$query = "SELECT INVOICE_NUMBER,INVOICE_DATE,NAME,ADDRESS_1,ACCOUNT_REF ";
$query.= " FROM INVOICE WHERE INVOICE_NUMBER>'$max_num'  AND PRINTED_CODE='1' AND POSTED_CODE='0' ORDER BY INVOICE_DATE ";

##print "$query";


print '<body bgcolor="#E9E9FF" >';

print "<table border='0'>";

print "last 20 invoices<br>";

# perform the query
$result = odbc_exec($connect, $query);


# fetch the data from the database
while(odbc_fetch_row($result)){
  $accountno = odbc_result($result, 5);
  $invoice_number = odbc_result($result, 1);
  $invoice_date = odbc_result($result, 2);


	?>
	<tr ><td><?=$accountno?></td><td
		onClick="document.getElementById('refreshme').click();parent.right_frame.window.document.location.replace('invoice.php?invoice_number=<?=$invoice_number?>')";
	><b><?=$invoice_number?></b></td><td><?=$invoice_date?></td></tr>
	<?
}


print "</table>";

print "<br />";
print "<br />";




# close the connection
odbc_close($connect);
?>



<a href="invoice.php" id="refreshme" target="right_frame">Refresh</a>
