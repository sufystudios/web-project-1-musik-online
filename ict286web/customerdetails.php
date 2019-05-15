<div class="songdetailsbox">
<?php



$customer_details = get_customer_details($_GET['customer_id']);
$customerid=$_GET['customer_id'];


if(isset($_GET['search'])) $search = $_GET['search'];	## used for bolding serached stuff
	else {$search = "ZZZZzxcvbnmZZ";}  ## to make sure our regex matches nothing.


## now replace the search stuff with <strong><strong>

$customer_details[2] = preg_replace("/$search/i","<a class=\"searchMatch\">$0</a>",$customer_details[2]);
$customer_details[1] = preg_replace("/$search/i","<a class=\"searchMatch\">$0</a>",$customer_details[1]);
$customer_details[10] = preg_replace("/$search/i","<a class=\"searchMatch\">$0</a>",$customer_details[10]);




echo '<div class="innersongdetaildiv" style="width:45%;position:relative; float:left;">';
echo "<strong>ID: </strong>$customer_details[0]<br />";
echo "<strong>Email Address: </strong>$customer_details[2]<br />";
echo "<strong>UserName: </strong>$customer_details[10]<br />";
echo "<strong>Full Name: </strong>$customer_details[1]<br />";
echo '</div>';



echo '<div class="innersongdetaildiv" style="width:45%;position:relative;display:inline-block; float:middle;">';
echo "<strong>Address1: </strong>$customer_details[5]<br />";
echo "<strong>Address1: </strong>$customer_details[6]<br />";
echo "<strong>Address1: </strong>$customer_details[7]<br />";
echo "<strong>State / PC: </strong>$customer_details[8]  $customer_details[9]<br />";
echo '</div>';





echo '<div class="innersongdetaildiv"  style="width:9%;position:relative;display:inline-block; float:right;">';

if(is_user_admin($account_id))		#admin user cannot purchase, but can edit song details..

	{

	?><br /><br /><a href="account_edit.php?customerid=<? echo $customerid; ?>">Edit</a><br/> <?

	}

echo '</div>';
 
?> 

</div>
