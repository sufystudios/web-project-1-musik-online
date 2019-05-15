<?
include('./fpdf.php');
require('./fpdi.php');

$basket_id = 3;

$date_today_long=date("j F Y",time());
$date_today=date("d/m/y",time());


if(isset($_GET['basket_id'])) $basket_id = $_GET['basket_id'];
else $basket_id = "";



define('FPDF_FONTPATH','./font/');
$pdf=new fpdi();
$pdf->Open();
$pdf->SetTopMargin(10);
$pdf->SetAutoPageBreak(1,10);

$pageno = 1;

if(1)
{


	$pagecount = $pdf->setSourceFile("bg.pdf");
	$pdf->AddPage("P");
	$tplidx = $pdf->ImportPage(1);
	$pdf->useTemplate($tplidx,1,1);


	print_header($pdf, $basket_id, $pageno);

	print_lines($pdf, $basket_id);


	print_footer($pdf, $basket_id);


	$filename = "$basket_id" . ".pdf";

	## use D for download



	$pdf->Output("$filename", 'I');
	$pdf->closeParsers();



}  #end if set basket Id


else
{

print '<body bgcolor="#E9E9FF" >';

}







function print_header($pdf, $basket_id, $pageno)
	{


	##print company details
	##$company_details= get_company_details();


	$pdf->SetY(13);
	$pdf->SetX(20);
	$pdf->SetFont('Arial','B',22);
	$pdf->Cell(50,5,"Musi Konline Pty Ltd",0,0,'L',0,"");


	$pdf->SetY(20);
	$pdf->SetX(20);
	$pdf->SetFont('Arial','',11);
	$pdf->Cell(50,5,"100 Scarborouh Beach Rd",0,0,'L',0,"");

	$pdf->SetY(25);
	$pdf->SetX(20);
	$pdf->SetFont('Arial','',11);
	$pdf->Cell(50,5,"OSBORNE PARK     WA    6017",0,0,'L',0,"");

	$pdf->SetY(30);
	$pdf->SetX(20);
	$pdf->SetFont('Arial','',9);
	$pdf->Cell(50,5,"ABN:  36 222 000 111",0,0,'L',0,"");


	## blurb

	$pdf->SetY(39);
	$pdf->SetX(127);
	$pdf->SetFont('Arial','I',8);
	$pdf->Cell(50,5,"Tidak Banyak Waktu Pty Ltd ACN 123 123 123 as trustee for",0,0,'L',0,"");

	$pdf->SetY(42);
	$pdf->SetX(127);
	$pdf->Cell(50,5,"the Alpine Family Trust T/As Musi Konline",0,0,'L',0,"");


	$header_details=get_header_details($basket_id);

	$y=$pdf->GetY();
	if($y<40){$y=40;}



	$pdf->SetY(31);
	$pdf->SetX(132);
	$pdf->SetFont('Arial','B',15);
	$pdf->Cell(50,5,"Tax Invoice",0,0,'L',0,"");


	$pdf->SetX(176);
	$pdf->SetFont('Arial','',11);
	$pdf->Cell(50,5,"Page $pageno",0,0,'L',0,"");


	$pdf->SetY(66);
	$pdf->SetX(28);
	$pdf->SetFont('Arial','B',14);
	$pdf->Cell(50,5,"$header_details[2]",0,0,'L',0,"");
	$pdf->SetY(72);
	$pdf->SetX(28);
	$pdf->SetFont('Arial','',11);
	$pdf->Cell(50,5,"$header_details[4]",0,0,'L',0,"");

	$pdf->SetY(78);
	$pdf->SetX(28);
	$pdf->SetFont('Arial','',11);
	$pdf->Cell(50,5,"$header_details[5]",0,0,'L',0,"");


	$pdf->SetY(84);
	$pdf->SetX(28);
	$pdf->SetFont('Arial','',11);
	$pdf->Cell(50,5,"$header_details[6]       $header_details[7]          $header_details[8]",0,0,'L',0,"");


	#invocie number
	$paddedinv = sprintf("%07d",$header_details[0]);
	$pdf->SetY(64);
	$pdf->SetX(165);
	$pdf->SetFont('Arial','',11);
	$pdf->Cell(40,5,"$paddedinv",0,0,'L',0,"");


	#date
	$pdf->SetY(73);
	$pdf->SetX(165);
	$pdf->SetFont('Arial','',11);
	$pdf->Cell(40,5,"$header_details[1]",0,0,'L',0,"");


	#basket_id ( for order id)
	$padded_id = sprintf("%07d",$basket_id);
	$pdf->SetY(82);
	$pdf->SetX(165);
	$pdf->SetFont('Arial','',11);
	$pdf->Cell(40,5,"$padded_id",0,0,'L',0,"");




	$padded_custid = sprintf("%07d",$header_details);
	$pdf->SetY(90);
	$pdf->SetX(165);
	$pdf->SetFont('Arial','',11);
	$pdf->Cell(40,5,"$padded_custid",0,0,'L',0,"");


	## column headings

		$pdf->SetY(105);
		$pdf->SetFont('Arial','B',12);
		$pdf->Cell(15,1,"Qty",0,0,'R',0,"");
		$pdf->SetX(30);
		$pdf->Cell(30,1,"Track Name",0,0,'L',0,"");
		$pdf->SetX(80);
		$pdf->Cell(30,1,"Artist",0,0,'L',0,"");	#artist


		$pdf->SetX(115);
		$pdf->Cell(30,1,"Item Ex",0,0,'R',0,"");
		$pdf->SetX(137);
		$pdf->Cell(30,1,"Line Tot Ex",0,0,'R',0,"");
		$pdf->SetX(163);
		$pdf->Cell(30,1,"Line GST",0,0,'R',0,"");

}






function print_lines($pdf,$basket_id)
	{

	require("../mysql/mysql.php");
	unset($totals);
	$mytotal=0;

	$pdf->SetY(98);

	$pdf->SetX(25);
	$pdf->SetFont('Arial','',14);


	$yval=112;

	$backorders_exist = 0;  ## we look for backorders in this section and print sorry if so.
	

	$SQL = " SELECT basket_item_id from basket_items where basket_id='$basket_id' ; ";

	$run=mysql_query($SQL);


	while($row=mysql_fetch_array($run)) 
		{
		$basket_item_id	= $row[0];

 		$line_details = get_line_details($basket_item_id);


		$backorder_asterisk = "";

		if($line_details[7] > 0 ) {$backorders_exist = 1;$backorder_asterisk="*";}	## if any line is a backorder we display a warning at the bott


		$pdf->SetY($yval);
		$pdf->SetFont('Arial','',12);
		$pdf->SetX(10);
		$pdf->Cell(15,1,"$backorder_asterisk $line_details[1]",0,0,'R',0,"");



		$pdf->SetX(30);
		$pdf->Cell(30,1,"$line_details[2]",0,0,'L',0,"");
	

		$pdf->SetX(80);
		$pdf->Cell(30,1,"$line_details[3]",0,0,'L',0,"");	#artist


		$pdf->SetX(115);
		$pdf->Cell(30,1,"$line_details[4]",0,0,'R',0,"");
		$pdf->SetX(137);
		$pdf->Cell(30,1,"$line_details[5]",0,0,'R',0,"");
		$pdf->SetX(163);
		$pdf->Cell(30,1,"$line_details[6]",0,0,'R',0,"");


	$yval=$yval+6;

		if($yval>227)
			{
			$pdf->AddPage("P");
			$tplidx = $pdf->ImportPage(1);
			$pdf->useTemplate($tplidx,1,1);
			$pageno++;
			print_header($pdf, $invoice_number, $pageno);
			$yval=112;
			}

		}

	$yval=$pdf->getY();



	if($backorders_exist)

		{
		$yval= $yval + 10;
		$pdf->SetY($yval);
		$pdf->SetFont('Arial','',11);
		$pdf->SetX(18);
		$pdf->Cell(20,1,"* We are sorry that we could not provide you with all your requested tracks.",0,0,'L',0,"");
		$yval= $yval + 8;
		$pdf->SetY($yval);
		$pdf->SetX(18);
		$pdf->Cell(20,1," Please note that once the stock arrives we will contact you and arrange a freight free",0,0,'L',0,"");
		$yval= $yval + 5;
		$pdf->SetY($yval);
		$pdf->SetX(18);
		$pdf->Cell(20,1," backorder release option.",0,0,'L',0,"");
		}



	}  ## end function to print lines..




function print_footer($pdf, $basket_id)
	{

	$footer_details= get_footer_details($basket_id);


	$pdf->SetY(252);
	$pdf->SetX(125);
	$pdf->SetFont('Arial','B',9);
	$pdf->Cell(50,5,"GST Exclusive Amount $",0,0,'L',0,"");

	#first total
	$pdf->SetY(252);
	$pdf->SetX(172);
	$pdf->SetFont('Arial','',11);
	$pdf->Cell(20,5,"$footer_details[3]",0,0,'R',0,"");




	$pdf->SetY(262);
	$pdf->SetX(125);
	$pdf->SetFont('Arial','B',9);
	$pdf->Cell(50,5,"GST Amount $",0,0,'L',0,"");

	#2nd total
	$pdf->SetY(262);
	$pdf->SetX(172);
	$pdf->SetFont('Arial','',11);
	$pdf->Cell(20,5,"$footer_details[2]",0,0,'R',0,"");




	$pdf->SetY(270);
	$pdf->SetX(125);
	$pdf->SetFont('Arial','B',9);
	$pdf->Cell(50,5,"Freight $",0,0,'L',0,"");

	#3rd total
	$pdf->SetY(270);
	$pdf->SetX(172);
	$pdf->SetFont('Arial','',11);
	$pdf->Cell(20,5,"$footer_details[1]",0,0,'R',0,"");





	$pdf->SetY(279);
	$pdf->SetX(125);
	$pdf->SetFont('Arial','B',9);
	$pdf->Cell(50,5,"GST Inclusive Total $",0,0,'L',0,"");


	#4th total
	$pdf->SetY(279);
	$pdf->SetX(172);
	$pdf->SetFont('Arial','',11);
	$pdf->Cell(20,5,"$footer_details[4]",0,0,'R',0,"");

	}




## generic mysql functions used by the above functions.







function get_header_details($basket_id)
	{
	require("../mysql/mysql.php");
	$invoice_no = "";
	$SQL = " SELECT invoice_no,DATE_FORMAT(basket.complete_date, \"%d %b %Y\"),customer.customer_name,basket.customer_id,  ";
	$SQL.= " customer.customer_add1,customer.customer_add2,customer.customer_add3,customer.customer_state,customer.customer_pc ";
	$SQL.= " from basket ";
	$SQL.= " inner join customer on basket.customer_id=customer.customer_id ";
	$SQL.= " where basket_id='$basket_id' ; ";
	$run=mysql_query($SQL);
	while($row=mysql_fetch_array($run)) 
		{
		$header_details[] = $row[0];
		$header_details[] = $row[1];
		$header_details[] = $row[2];
		$header_details[] = $row[3];
		$header_details[] = $row[4];
		$header_details[] = $row[5];
		$header_details[] = $row[6];
		$header_details[] = $row[7];
		$header_details[] = $row[8];
		}
	return $header_details;

	}



function get_line_details($basket_item_id)
	{
	require("../mysql/mysql.php");

	$SQL = " SELECT basket_items.track_id,basket_items.track_quantity,track_name,artist.artist_name,track.track_value,basket_items.track_backorder ";
	$SQL.= " from basket_items inner join track on basket_items.track_id=track.track_id ";
	$SQL.= " inner join artist on track.track_artist_id = artist.artist_id ";
	$SQL.= " where basket_item_id='$basket_item_id' ; ";

	$run=mysql_query($SQL);
	while($row=mysql_fetch_array($run)) 
		{

		$qtyord = $row[1];#track_quantity (ordered)
		$qtybackord = $row[5];#backorder
		$qtyshipped = $qtyord - $qtybackord;


		$line_details[] = $row[0];#track_id
		$line_details[] = $qtyshipped;			## this is what is shipped.
		$line_details[] = $row[2];#track_name
		$line_details[] = $row[3];#artist_name
		$line_details[] = sprintf("%.2f",$row[4]);#track_value
		$line_details[] = sprintf("%.2f",$qtyshipped * $row[4]);	#line total ex
		$line_details[] = sprintf("%.2f",$qtyshipped * $row[4] * 0.1);	#line total gst
		$line_details[] = $qtybackord;  ## if above zero on ANY track we say sorry on the invoice


		}
	return $line_details;

	}





function get_footer_details($basket_id)
	{
	require("../mysql/mysql.php");
	$invoice_no = "";
	$SQL = " SELECT basket_postage,basket_total ";
	$SQL.= " FROM basket where basket_id='$basket_id' ; ";
	$run=mysql_query($SQL);
	while($row=mysql_fetch_array($run)) 
		{
		$footer_details[] = sprintf("%.2f",$row[0]);	## fright ex
		$footer_details[] =  sprintf("%.2f",$row[0] * 1.1 );  ## freight inc


		$footer_details[] = sprintf("%.2f",$row[1] * 0.1);	## gst

		$footer_details[] = sprintf("%.2f",$row[1]);	## total ex
		$footer_details[] = sprintf("%.2f",$row[1] + $row[0] * 1.1);		## total inc


		}
	return $footer_details;

	}

