<?

function check_admin($adminid) {
	include('mysql.php');
	$admin=0;
	$SQL = "SELECT customer_isadmin from customer where customer_id='$adminid'";
	$chkadm=mysql_query($SQL);
	while($row=mysql_fetch_array($chkadm)) {
	if($row[0] == 1)
		$admin=1;
	}

	return $admin;
}

function song_in_basket($basket_id,$songid) {
	include('mysql/mysql.php');
	$SQL = "SELECT count(*) from basket_items WHERE basket_id='$basket_id' AND track_id='$songid'";
	$run=mysql_query($SQL);
	while($row=mysql_fetch_array($run)) {
		if ($row[0]==0)
			return false;
		else
			return true;
	}
}



function create_customer_account($entered_email,$admin)
	{
	include('mysql.php');

	$myparts = explode("@", $entered_email);
	$username = $myparts[0];
	$username = preg_replace("/\./","",$username);	## get rid of the .


	$full_name = $username;		## this is just a good guess at a friendly name, customer can updaet


	$username = $username . substr(uniqid(), -3);  ## couple of random chars to make sure the username is unique, customer can change this too.


	$new_email = addslashes($entered_email);

	$new_password = substr(uniqid(), -6);

	$SQL = "INSERT INTO customer (customer_name,customer_username,customer_password,customer_isadmin,customer_active,customer_email_confirmed,customer_email)  ";
	$SQL.= " VALUES ( '$full_name','$username','$new_password',$admin,1,1,'$new_email');  ";
	mysql_query($SQL);

	return $new_password;
	}






function email_exists($entered_email)
	{
	$in_system = 0;
	$entered_email = trim($entered_email);

	$SQL = "Select customer_id from customer where customer_email='$entered_email'  ";
	$resource = mysql_query($SQL);
	while($row=mysql_fetch_row($resource))
		{
		$in_system = 1;
		}

	return $in_system ;
	}



function delete_from_basket($basket_id,$track_id) 
	{
	include('mysql.php');
	$SQL = "Delete from basket_items WHERE basket_id='$basket_id' AND track_id='$track_id'";
	mysql_query($SQL);
	}



function finalize_cart($basket_id)
	{

	################################################################################################################
	## this rubbish needs to be converted to a transaction.. probably with some escape chars function on the mysql##
	################################################################################################################

	include('mysql.php');

	$SQL = " SELECT  MAX(invoice_no)+1 FROM basket; ";
	$resource = mysql_query($SQL);
	while($row=mysql_fetch_row($resource))
		{
		$next_invoice_no = $row[0];
		}
	$SQL = "  UPDATE basket SET basket_complete = '1', complete_date=NOW(),invoice_no='$next_invoice_no' WHERE basket_id='$basket_id' ; ";
	mysql_query($SQL);

	## now reduce track_soh quantities for each track.. BUT DO NOT ALLOW negative SOH.  overwrite that just in case

	$SQL = " SELECT track_id, track_quantity-IFNULL(track_backorder,0) from basket_items WHERE basket_id='$basket_id' ; ";


	$resource = mysql_query($SQL);
	while($row=mysql_fetch_row($resource))
		{
		$track_id = $row[0];
		$quan = $row[1];

		$SQL2 =" UPDATE track set track_soh = track_soh - $quan WHERE track_id = '$track_id'  ;";
		mysql_query($SQL2);
		}


	$SQL = " UPDATE track SET track_soh = 0 WHERE track_soh < 0 ; ";		## just in case
	mysql_query($SQL);



	}








function print_last_five_purchases($account_id)		## actually it is seven of them..
	{

	include('mysql.php');
	$SQL = "SELECT MAX(DAY(complete_date)),MAX(MONTH(complete_date)),MAX(YEAR(complete_date)),";
	$SQL .= " COUNT(basket_items.basket_item_id),MAX(basket_total ), MAX(invoice_no), MAX(basket.basket_id) ";

	$SQL .= "FROM basket  ";

	$SQL .= "INNER JOIN basket_items ON basket.basket_id=basket_items.basket_id ";
	$SQL .= "WHERE basket_complete='1' ";
	$SQL .= " AND basket.customer_id = '$account_id' "; 
	$SQL .= "GROUP BY basket.basket_id ";
	$SQL .= "ORDER by basket.complete_date DESC, basket.basket_id DESC LIMIT 0,7 ";

	echo "<table>";

	echo "<tr><td>Date</td><td>&nbsp;</td><td># Tracks</td><td>Basket Total</td></tr>";

	$resource = mysql_query($SQL);
	while($row=mysql_fetch_row($resource))
		{
		$complete_dd = $row[0];
		$complete_mm = $row[1];
		$complete_yy = $row[2];


		$complete_date = "$complete_dd/$complete_mm/$complete_yy";



		$num_items= $row[3];
		$basket_total = sprintf("$ %.2f",$row[4]);

		$invoice_no = $row[5];


		$basket_id = $row[6];

		echo "<tr><td>$complete_date</td>";

		echo "<td><input type=\"button\" class=\"clickButtonTable\" value=\"View inv# $invoice_no\" onClick=\"print_invoice($basket_id);\"></td> ";

		echo "<td style=\"text-align:center;\">$num_items</td>";

		echo "<td style=\"text-align:right;\">$basket_total</td></tr>";
	
		echo "<tr style=\"font-size: 1px; line-height: 5px;\"><td colspan=\"4\">&nbsp;</td></tr>";

		}

	echo "</table>";

	}




function add_song_to_basket($basket_id, $track_id)

	{
	include('mysql.php');
	$track_in_cart=0; # default to not in cart


	## first look up the quantity available for this track
	$track_soh = 0;
	$track_backorder = 0;

	$SQL = "SELECT track_soh FROM track where track_id=' $track_id' ; ";	## returns the most recent uncoplete basket_id
	$resource = mysql_query($SQL);
       	while($row=mysql_fetch_row($resource))
		{
		$track_soh = $row[0];
		}
	if($track_soh < 1 ) { $track_backorder = 1;}
	

	$SQL =  "SELECT track_quantity from basket_items WHERE basket_id='$basket_id' and track_id='$track_id' ";
	$resource = mysql_query($SQL);
	echo "<script>alert(\"$SQL\");</script>";
	while($row=mysql_fetch_row($resource))
		{
		$track_in_cart = $row[0];

		echo "<script>alert(\"$track_in_cart\");</script>";
		}




		if($track_in_cart==0)		## ok .. so trac not in cart..
			{
	

			## check again the value in track_soh



			$SQL = "INSERT INTO basket_items (basket_id,track_id,track_quantity,track_backorder) VALUES ($basket_id,$track_id,1,$track_backorder); ";
			$resource = mysql_query($SQL);
			}
		else
			 {
			$SQL = "UPDATE basket_items set track_quantity=track_quantity+1 WHERE basket_id='$basket_id' AND track_id='$track_id'";
			$resource = mysql_query($SQL);
			}

	}




function print_basket_items($basket_id)
	{

	#just print all songs in basket.. print nothing if nothing.

	include('mysql.php');

	$num_items_in_basket = 0;

	echo"<table class=\"basketTable\"><tr><th>Track Name</th><th># required</th></tr>";

	## first look for an existing basket this user
	$SQL = "SELECT track.track_name,basket_items.track_id,track_quantity from basket_items INNER JOIN track on basket_items.track_id=track.track_id ";
	$SQL .= "where basket_id='$basket_id' ORDER BY track.track_name ";	## gets the names of songs in the basket.
	$resource = mysql_query($SQL);
        while($row=mysql_fetch_row($resource))
		{

		$track_id = $row[1];
	
		echo "<tr><td>$row[0]</td><td>";


		echo "<form name=\"update\" method=\"GET\" > ";

		echo "<select onchange=\"update_cart($basket_id, $track_id)\" name=\"quantity$track_id\" id=\"quantity$track_id\" class=\"selectBoxBasket\"    >";

		echo "</form>";

		for($x=1;$x<11;$x++)
			{
			echo"<option ";
				if ($row[2] == $x){echo " selected ";}
			echo " value='$x'>$x</option>";
			}
			
		echo "</select></td>";

		## now a logo to remove from basket..

		echo"<td><input type=\"button\" class=\"removeButtonSmall\" onclick=\"remove_cart($track_id);\"></td>";


		echo "</tr>";

		$num_items_in_basket++;

		}

	echo "</table>";

	return $num_items_in_basket;

	}



function update_basket_totals($basket_id,$basket_postage_ex,$basket_total_ex)
	{
	include('mysql.php');
	$SQL = "UPDATE basket set basket_postage='$basket_postage_ex',basket_total='$basket_total_ex' WHERE basket_id='$basket_id' ";
	$resource = mysql_query($SQL);
	}



function print_basket_details_for_checkout($basket_id)

	{

	$total_num_items_in_basket = 0;
	$basket_postage_ex = 0;
	$basket_total_ex = 0;
	$line_total_ex = 0;

	echo"<p style=\"font-size:8pt;font-style: italic;\">All prices are ex gst except where indicated:</p><br />";

	echo"<table style=\"cellpadding:7px;cellspacing:7px;\"><tr><th>Track Name</th><th>Qty Ord.</th><th>B/Ord</th><th>To Ship</th><th>Price ea</th><th>Line Total</th></tr>";

	$SQL =  " SELECT track.track_name,basket_items.track_id,track_quantity,track_value,track_backorder ";
	$SQL .= " from basket_items ";
	$SQL .= " INNER JOIN track on basket_items.track_id=track.track_id ";
	$SQL .= " where basket_id='$basket_id' ORDER BY track.track_name ";	## gets the names of songs in the basket.
	$run=mysql_query($SQL);
	while($row=mysql_fetch_array($run))
		{

		$track_name = $row[0];
		$track_id = $row[1];
		$track_quantity_requested = $row[2];  ## this is what is REQUESTED.. not what will be shiped
		$track_value = $row[3];  ## per item from the main track table..
		$track_backorder = $row[4];  ## this is an extra value for what the customer actually wants to what is on hand


		$track_quantity = $track_quantity_requested - $track_backorder;

		$total_num_items_in_basket += $track_quantity ;

		$line_total_ex = $track_value * $track_quantity;

		$basket_total_ex += $line_total_ex;	

		$track_value_display = sprintf("$ %.2f",$track_value);
		$line_total_ex_display = sprintf("$ %.2f",$line_total_ex);
	
		echo "<tr><td>$track_name</td>";

		echo "<td style=\"text-align:right\">";
		echo "<form name=\"update\" method=\"GET\" > ";
		echo "<input type=\"hidden\" name=\"basket_id\" value =\"$basket_id\" > ";

		echo "<select onchange=\"update_cart_summary($basket_id, $track_id)\" name=\"quantity$track_id\" id=\"quantity$track_id\" class=\"selectBoxBasket\"    >";


		for($x=1;$x<11;$x++)
			{
			echo"<option ";
				if ($track_quantity_requested == $x){echo " selected ";}
			echo " value='$x'>$x</option>";
			}
		echo "</select></td>";
		echo "</form>";

		## .. now we don't want to dispaly a read zero for a zero b/o.. so squash it.

		if($track_backorder<1){$track_backorder="&nbsp;";$bowarning='' ;}else{$bowarning=' &nbsp; &nbsp; insufficient stock for qty requested..';}

		print "<td style=\"text-align:right;color:red;\">$track_backorder</td>";
		print "<td style=\"text-align:right;\">$track_quantity</td>";



		print "<td style=\"text-align:right;\">$track_value_display</td>";
		print "<td style=\"text-align:right;\">$line_total_ex_display</td>";

		print "<td style=\"text-align:right;color:red;\">$bowarning</td>";



		print "</tr>";

		}
	print "</table>";
	
	$basket_postage_ex = round(($total_num_items_in_basket* 0.8),1);
	if($basket_postage_ex>15) {$basket_postage_ex =  round(15 + (($basket_postage_ex - 15) / 2),1);}


	$basket_total_ex = $basket_postage_ex + $basket_total_ex;

	## update the basket postage total
	update_basket_totals($basket_id,$basket_postage_ex,$basket_total_ex);


	## do the gst stuff

	$basket_total_gst = round(($basket_total_ex * 0.1),2);
	$basket_total_inc = $basket_total_ex + $basket_total_gst;


	## now round and display the totals

	$basket_postage_ex_display = sprintf("$ %.2f",$basket_postage_ex);
	$basket_total_inc_display = sprintf("$ %.2f",$basket_total_inc);
	$basket_total_gst_keep = $basket_total_gst ; 
	$basket_total_gst = sprintf("$ %.2f",$basket_total_gst);


	print "<br /><br />";
	print "Postage for $total_num_items_in_basket items: $basket_postage_ex_display <br /><br />";	


	print "Total (inc gst) for basket: <strong>$basket_total_inc_display</strong> &nbsp; &nbsp; &nbsp; ";
	print "(inc gst of $basket_total_gst) <br /><br />";	


	return $basket_total_gst_keep;   ## this goes back to teh calling function so we know if there is something to buy.

	}




function update_basket_quantities($basket_id, $track_id, $quantity)

		{
		## used when updating a track quantitiy in teh basket

		
		## check again the value in track_soh


		$SQL = "SELECT track_soh FROM track where track_id=' $track_id' ; ";	## returns the most recent uncoplete basket_id
		$resource = mysql_query($SQL);
       		 while($row=mysql_fetch_row($resource))
			{
			$track_soh = $row[0];
			}

		## now .. in the basket_items, teh amount in track_backorder = quantity - track_soh IF the soh is LESS than the order quan
		$track_backorder = 0;	## so we have a default
		$track_backorder = $quantity - $track_soh;
		if($track_backorder<0) { $track_backorder = 0;} ## this make sure we only EVER have +ve values in backorder..
		


		include('mysql.php');
		$SQL = "UPDATE basket_items set track_quantity='$quantity',track_backorder = '$track_backorder' WHERE basket_id='$basket_id' AND track_id='$track_id' ";
		$resource = mysql_query($SQL);
		}







function get_basket_id($account_id){


	include('mysql.php');
	$basket_id=0; # default to invalid basket


	## first look for an existing basket this user
	$SQL = "SELECT MAX(basket_id)  AS basket_id from basket where basket_complete='0' AND customer_id='$account_id' ; ";	## returns the most recent uncoplete basket_id
	$resource = mysql_query($SQL);
        while($row=mysql_fetch_row($resource))
		{
		$basket_id = $row[0];
		}


	if($basket_id == 0 )	## no existing basket then creat one and return the new basket_id

		{

		$SQL = "INSERT INTO basket (customer_id, basket_complete) VALUES ($account_id,0); ";
		$resource = mysql_query($SQL);

		## now get the id for hte newly created basket this account

		$SQL = "SELECT MAX(basket_id) AS basket_id from basket where customer_id='$account_id' AND basket_complete='0' ";
		$resource = mysql_query($SQL);
      		while($row=mysql_fetch_row($resource))
			{
			$basket_id = $row[0];
			}

		}
		
	return $basket_id;
}









function print_number_of_items_in_basket($basket_id)

	{

	include('mysql.php');
	$num_items=0; # default to zero


	## first look for an existing basket this user
	$SQL = "SELECT COUNT(*) FROM basket_items where basket_id='$basket_id' ";	
	$resource = mysql_query($SQL);
        while($row=mysql_fetch_row($resource))
		{
		$num_items = $row[0];
		}
	if($num_items==0){$num_items="no";}

	echo $num_items;
	}









function check_login($email_address,$password)
	{
	include('mysql.php');
	$acountid=0;  #initialize return value


        $SQL="SELECT  customer_id FROM customer WHERE ( customer_username='$email_address' OR customer_email='$email_address') and customer_password='$password' ";
	$resource = mysql_query($SQL);


        while($row=mysql_fetch_row($resource))
		{
		$acountid=$row[0];
		$admin=check_admin($row[0]);
		if($admin) {
			$SESSION['admin']=1;
			
		}
		}
	return $acountid;

	}

 





function is_user_admin($account_id)
	{

	include('mysql.php');
	$user_id_admin=0;

        $SQL="SELECT customer_isadmin FROM customer WHERE customer_id='$account_id' ";
	$resource = mysql_query($SQL);


        while($row=mysql_fetch_row($resource))
		{
		$user_id_admin = $row[0];
		}
	return $user_id_admin;

	}









function  get_user_name($account_id)

	{
	include('mysql.php');
	$username="Guest";

        $SQL="SELECT  customer_username FROM customer WHERE customer_id='$account_id' ";
	$resource = mysql_query($SQL);


        while($row=mysql_fetch_row($resource))
		{
		$username=$row[0];
		}
	return $username;
	}





function get_full_name($account_id)
	{
	include('mysql.php');
	$fullname="Guest User";

        $SQL="SELECT  customer_name FROM customer WHERE customer_id='$account_id' ";
	$resource = mysql_query($SQL);


        while($row=mysql_fetch_row($resource))
		{
		$fullname=$row[0];
		}
	return $fullname;
	}






function get_customer_details($customer_id)

	{
	$query  = "  SELECT customer_id,customer_name,customer_email,customer_active,customer_email_confirmed,";
	$query .= " customer_add1,customer_add2,customer_add3,customer_state,customer_pc,customer_username ";
	$query .= " FROM customer WHERE customer_id = '$customer_id' ";


	$run=mysql_query($query);
	$row=mysql_fetch_array($run);


	$customerdetails[] = $row[0];	# customer_id
	$customerdetails[] = $row[1];	# customer_name
	$customerdetails[] = $row[2];	# customer_email
	$customerdetails[] = $row[3];	# customer_active
	$customerdetails[] = $row[4];	# customer_email_confirmed
	$customerdetails[] = $row[5];	# customer_aad1
	$customerdetails[] = $row[6];	# customer_add2
	$customerdetails[] = $row[7];	# customer_add3
	$customerdetails[] = $row[8];	# customer_state
	$customerdetails[] = $row[9];	# customer_pc
	$customerdetails[] = $row[10];	# customer_username
	return $customerdetails;

	}


function update_customer_account($customer_id,$customer_name,$customer_username,$customer_email,$customer_add1,$customer_add2,$customer_add3,$customer_state,$customer_pc,$current_username)

	{
	## first make sure the chosen username is not already in use
	$existing_username = 0;

        $SQL="SELECT customer_id FROM customer WHERE customer_username='$customer_username' and customer_id<>'$customer_id' "; ## so we dont match ourselves..
	$resource = mysql_query($SQL);


        while($row=mysql_fetch_row($resource))
		{
		$existing_username=1;
		$customer_username = $current_username; ## revert username back .. and return advisory to form
		}
	

	$query = " UPDATE customer SET ";
	$query .= " customer_name='$customer_name',customer_username='$customer_username',customer_email='$customer_email',customer_add1='$customer_add1',   ";
	$query .= " customer_add2='$customer_add2',customer_add3='$customer_add3',customer_state='$customer_state',customer_pc='$customer_pc'   ";
	$query .= " WHERE customer_id = '$customer_id' ";
	#$query = addslashes($query);	
	$run=mysql_query($query);


	return $existing_username;

	}





?>
