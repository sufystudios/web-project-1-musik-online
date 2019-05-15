<?

include("mysql/mysql.php");
include("mysql/func_music.php");



$search = "";
$listAdmins = "";
$calling_page = "";
$pageno = "0";		## sets default in case we are on the first listed page in pagination. (from music.php)


if(isset($_GET['search'])   && $_GET['search']!="" )  $search=$_GET['search'];


if(isset($_GET['listAdmins'])   && $_GET['listAdmins']!="" )  $listAdmins=1;





if(isset($_GET['pageno']))  $pageno=$_GET['pageno'];




elseif (strlen($search) > 0 )  ### if we come from teh search box in accoutns.		  

	{

	$pageno = 0;

	$query="SELECT * from customer WHERE customer_isadmin = 0 ";

   	$query.= "    AND ( customer_name LIKE '%$search%' or customer_email LIKE '%$search%'   or customer_username LIKE '%$search%' )  ";

	## do some page number fun..
	if(!isset($_GET['pageno']))  $pageno=0;			## 0 is first page
	else $pageno = $_GET['pageno'];

	$result_from = $pageno * 5 ;		## 1,6,11,15 etc
	$result_to = $pageno * 5 + 5;		## 5,11,15,19 etc

	
	$query.=" LIMIT $result_from ,$result_to ";


	$run=mysql_query($query);

	$result_number_this_page = 1;

	$last_page = 1; ## our marker looking for last pages.. gets set to zero if there is at least one more record.
	
	while($row=mysql_fetch_array($run)) 
		{


		if($result_number_this_page > 5)

			{

			$page_display = "  <div style=\"float:right;\">   ";  	# we clear this page display value each page

			if($pageno)		## if we are NOT in the fist page, show a last page link too..
				{
			
				$thispage = $pageno + 1;  ## for display only.
				$lastpage = $pageno - 1;  ## for display only.
				$page_display .= "<a href=\"music.php?pageno=$lastpage\">Last Page</a>"; 
				}


			$page_display .= "&nbsp; | &nbsp;";

			$nextpage = $pageno+1;		## we start at 0, so display 1 at first page etc
			?>
			<a style="float:left;">Page <?=$nextpage?>...</a>
			<?
			$page_display.="<a href=\"music.php?pageno=$nextpage\">Next Page</a> ";
			
			echo "$page_display</div>";

			$last_page = 0;	## there is at least one more record.. set this to zero

			break;		## breaks teh while loop at line 112
			
			}


		else

			{

		$_GET['customer_id']=$row[0];
		$_GET['search']=$search;


		include('customerdetails.php');
			echo"<br />";
			$result_number_this_page ++;

			}

		}		## end for each resulst raow











	if($pageno && $last_page)	## if we have been paginating.. and we are finished.. pritn the last back number with a back butt..
	
		{
			
		$thispage = $pageno + 1;  ## for display only.
		$lastpage = $pageno - 1;  ## for display only.
		?>
		<a style="float:left;">...Page <?=$thispage?></a>

		<div style="float:right;"><a href="music.php?pageno=<?=$lastpage?>" >Last Page</a> &nbsp; | &nbsp;</div>
		<?
		}


	}		# end if calling from music page (might be a search from music page)







elseif ($listAdmins==1)

	{	
include("mysql/func_account.php");
require('getaccountdetails.php');

	$query = " SELECT customer_id FROM customer WHERE customer_isadmin='1' ";
	$query.="  ORDER BY customer_name  ";
	$query.=" LIMIT 0,5";

	$run=mysql_query($query);
	$result_number_this_page = 1;
	while($row=mysql_fetch_array($run)) 
		{
		$_GET['customer_id']=$row[0];
		include('customerdetails.php');
		echo"<br />";
		$result_number_this_page ++;
		}

	}






else	## we are just listing the customers..	

	{	

	
	$query = " SELECT customer_id FROM customer WHERE customer_isadmin='0' ";
	$query.="  ORDER BY customer_name  ";
	$query.=" LIMIT 0,5";



	$run=mysql_query($query);

	$result_number_this_page = 1;
	
	while($row=mysql_fetch_array($run)) 
		{

		$_GET['customer_id']=$row[0];

		include('customerdetails.php');
		echo"<br />";
		$result_number_this_page ++;

		}



	}















