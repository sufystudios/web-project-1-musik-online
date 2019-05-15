<?
include('./fpdf.php');
require("settings.php");
require("func_inc.php");
require('fpdi.php');

$cid = odbc_connect($dsn,$db_user,$db_passwd);  
if (!$cid) { echo("ERROR CONNECTING::  $dsn,$db_user,$db_passwd \n"); }  



$date_today_long=date("j F Y",time());
$date_today=date("d/m/y",time());

$currm=date("m",time());
$currd=date("d",time());

$curry=date("y",time())+2000;


if($currd>25){$currm=$currm+1;}  #THIS IS SO THAT NEAR THE END OF THE MONTH WE CAN SEE THE NEW STATEMENT.

$sql_month=$currm;
if($sql_month==1){$sql_month=13;}

$startdate="$curry-$currm-01 00:00:00";



define('FPDF_FONTPATH','./font/');
$pdf=new fpdi();
$pdf->Open();
$pdf->SetTopMargin(10);
$pdf->SetAutoPageBreak(1,10);

$pageno = 1;

if(isset($invoice_number))
{


$pagecount = $pdf->setSourceFile("bg.pdf");
$pdf->AddPage("P");
$tplidx = $pdf->ImportPage(1);
$pdf->useTemplate($tplidx,1,1);


print_header($pdf, $invoice_number, $pageno);




##transaction lines due now...

unset($totals);
$mytotal=0;

$pdf->SetY(98);

$pdf->SetX(25);
$pdf->SetFont('Arial','',14);


$yval=112;

$SQL= "select SERVICE_FLAG,STOCK_CODE,DESCRIPTION,TEXT,COMMENT_1,COMMENT_2,QUANTITY,UNIT_PRICE,NET_AMOUNT,TAX_AMOUNT ";
$SQL.=" FROM INVOICE_ITEM WHERE INVOICE_NUMBER='$invoice_number' ORDER BY ITEM_NUMBER ";


$result=odbc_exec($cid,"$SQL");

while($row=odbc_fetch_row($result))
	{
	$service_flag=odbc_result($result, 1);


	$stock_code=odbc_result($result, 2);
	$description=odbc_result($result, 3);
	$text=odbc_result($result, 4);
	$comment1=odbc_result($result, 5);
	$comment2=odbc_result($result, 6);

	$qty=odbc_result($result, 7);
	$unit_price=odbc_result($result, 8);
	$net_amount=odbc_result($result, 9);
	$tax_amount=odbc_result($result, 10);

	if($service_flag==2.00)  # if an s3 item
		{

$description=$text;
		$qty="";
	$unit_price="";
	$net_amount="";
	$tax_amount="";

		}


	$pdf->SetY($yval);
	$pdf->SetFont('Arial','',9);
	$pdf->SetX(12);
	$pdf->Cell(15,1,"$qty",0,0,'R',0,"");


	if($service_flag<>2.00)  # normal line not s3
		{
		$pdf->SetX(30);
		$pdf->Cell(30,1,"$description",0,0,'L',0,"");
		$yval=$yval+4;
		}
	else
		{
		$yval=$yval-2;
		$pdf->SetY($yval);
		$pdf->SetX(30);

		
		#$description = preg_replace("/\n/","",$description);
		#$description = preg_replace("/-\s/","\n-",$description);


		$pdf->MultiCell(130,4, "$description",0,'L',0);
		$yval=$yval+2;

		$yval=$pdf->GetY()+4;
		}

	$pdf->SetX(115);
	$pdf->Cell(30,1,"$unit_price",0,0,'R',0,"");
	$pdf->SetX(137);
	$pdf->Cell(30,1,"$net_amount",0,0,'R',0,"");
	$pdf->SetX(163);
	$pdf->Cell(30,1,"$tax_amount",0,0,'R',0,"");





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




print_footer($pdf, $invoice_number);




#####################################
#####################################
## now print fotter
#####################################
#####################################


$filename = "$invoice_number" . ".pdf";

## use D for download


$pdf->Output("$filename", 'I');
$pdf->closeParsers();


}  #end if set invoice_number


else
{

print '<body bgcolor="#E9E9FF" >';

}





function print_footer($pdf, $invoice_number)
	{

	$footer_details= get_footer_details($invoice_number);


	$pdf->SetY(252);
	$pdf->SetX(125);
	$pdf->SetFont('Arial','B',9);
	$pdf->Cell(50,5,"GST Exclusive Amount $",0,0,'L',0,"");

	#first total
	$pdf->SetY(252);
	$pdf->SetX(172);
	$pdf->SetFont('Arial','',11);
	$pdf->Cell(20,5,"$footer_details[0]",0,0,'R',0,"");




	$pdf->SetY(262);
	$pdf->SetX(125);
	$pdf->SetFont('Arial','B',9);
	$pdf->Cell(50,5,"GST Amount $",0,0,'L',0,"");

	#2nd total
	$pdf->SetY(262);
	$pdf->SetX(172);
	$pdf->SetFont('Arial','',11);
	$pdf->Cell(20,5,"$footer_details[1]",0,0,'R',0,"");




	$pdf->SetY(270);
	$pdf->SetX(125);
	$pdf->SetFont('Arial','B',9);
	$pdf->Cell(50,5,"Freight $",0,0,'L',0,"");

	#3rd total
	$pdf->SetY(270);
	$pdf->SetX(172);
	$pdf->SetFont('Arial','',11);
	$pdf->Cell(20,5,"$footer_details[2]",0,0,'R',0,"");





	$pdf->SetY(279);
	$pdf->SetX(125);
	$pdf->SetFont('Arial','B',9);
	$pdf->Cell(50,5,"GST Inclusive Total $",0,0,'L',0,"");


	#4th total
	$pdf->SetY(279);
	$pdf->SetX(172);
	$pdf->SetFont('Arial','',11);
	$pdf->Cell(20,5,"$footer_details[3]",0,0,'R',0,"");



	}



function print_header($pdf, $invoice_number, $pageno)
	{


	##print company details
	$company_details= get_company_details();


	$pdf->SetY(13);
	$pdf->SetX(20);
	$pdf->SetFont('Arial','B',22);
	$pdf->Cell(50,5,"Comteque",0,0,'L',0,"");


	$pdf->SetY(20);
	$pdf->SetX(20);
	$pdf->SetFont('Arial','',11);
	$pdf->Cell(50,5,"$company_details[0]",0,0,'L',0,"");

	$pdf->SetY(25);
	$pdf->SetX(20);
	$pdf->SetFont('Arial','',11);
	$pdf->Cell(50,5,"$company_details[1]     $company_details[2]    $company_details[3]",0,0,'L',0,"");

	$pdf->SetY(30);
	$pdf->SetX(20);
	$pdf->SetFont('Arial','',9);
	$pdf->Cell(50,5,"ABN:  $company_details[4]",0,0,'L',0,"");


	## blurb

	$pdf->SetY(39);
	$pdf->SetX(127);
	$pdf->SetFont('Arial','I',8);
	$pdf->Cell(50,5,"Sho Pho Nonimees Pty Ltd ACN 109 597 292 as trustee for",0,0,'L',0,"");

	$pdf->SetY(42);
	$pdf->SetX(127);
	$pdf->Cell(50,5,"the Phoebe Family Trust T/As Comteque",0,0,'L',0,"");


	$header_details=get_header_details($invoice_number);

	$y=$pdf->GetY();
	if($y<40){$y=40;}



	$pdf->SetY(31);
	$pdf->SetX(132);
	$pdf->SetFont('Arial','B',15);
	$pdf->Cell(50,5,"Tax $header_details[5]",0,0,'L',0,"");


	$pdf->SetX(176);
	$pdf->SetFont('Arial','',11);
	$pdf->Cell(50,5,"Page $pageno",0,0,'L',0,"");


	$pdf->SetY(66);
	$pdf->SetX(28);
	$pdf->SetFont('Arial','B',14);
	$pdf->Cell(50,5,"$header_details[0]",0,0,'L',0,"");
	$pdf->SetY(72);
	$pdf->SetX(28);
	$pdf->SetFont('Arial','',11);
	$pdf->Cell(50,5,"$header_details[1]",0,0,'L',0,"");
	$pdf->SetY(77);
	$pdf->SetX(28);
	$pdf->SetFont('Arial','',11);
	$pdf->Cell(50,5,"$header_details[2]       $header_details[3]    $header_details[4]",0,0,'L',0,"");


	#invocie number
	$pdf->SetY(64);
	$pdf->SetX(165);
	$pdf->SetFont('Arial','',11);
	$pdf->Cell(40,5,"$header_details[6]",0,0,'L',0,"");


	#date
	$pdf->SetY(73);
	$pdf->SetX(165);
	$pdf->SetFont('Arial','',11);
	$pdf->Cell(40,5,"$header_details[7]",0,0,'L',0,"");


	## account ref
	$pdf->SetY(90);
	$pdf->SetX(165);
	$pdf->SetFont('Arial','',11);
	$pdf->Cell(40,5,"$header_details[8]",0,0,'L',0,"");


	## column headings



	## account ref
	$pdf->SetY(101);
	$pdf->SetFont('Arial','B',9);

	$pdf->SetX(15);
	$pdf->Cell(40,5,"Quantity",0,0,'L',0,"");
	$pdf->SetX(30);
	$pdf->Cell(40,5,"Description",0,0,'L',0,"");
	$pdf->SetX(115);
	$pdf->Cell(30,5,"Rate",0,0,'R',0,"");
	$pdf->SetX(137);
	$pdf->Cell(30,5,"Net Amount",0,0,'R',0,"");
	$pdf->SetX(163);
	$pdf->Cell(30,5,"GST Amount",0,0,'R',0,"");





	## this info is on the footer left bottom



	## name
	$pdf->SetY(252);
	$pdf->SetX(20);
	$pdf->SetFont('Arial','',14);
	$pdf->Cell(40,5,"$header_details[9]",0,0,'L',0,"");


	## phone
	$pdf->SetY(259);
	$pdf->SetX(20);
	$pdf->SetFont('Arial','',11);
	$pdf->Cell(40,5,"Mobile: $header_details[10]",0,0,'L',0,"");


	## email
	$pdf->SetY(264);
	$pdf->SetX(20);
	$pdf->SetFont('Arial','',11);
	$pdf->Cell(40,5,"E-Mail: $header_details[11]",0,0,'L',0,"");


	#bank

	$pdf->SetY(276);
	$pdf->SetX(10);
	$pdf->SetFont('Arial','',8);
	$pdf->Cell(40,5,"EFT DETAILS: AccName: SHOPHO NOMINEES PL",0,0,'L',0,"");
	$pdf->SetY(279);
	$pdf->SetX(10);
	$pdf->SetFont('Arial','',9);
	$pdf->Cell(40,5,"Bank:   CBA    BSB: 066-156   Acc#:  10168354",0,0,'L',0,"");

	#terms
	$pdf->SetY(282);
	$pdf->SetX(10);
	$pdf->SetFont('Arial','B',9);
	$pdf->Cell(40,5,"Terms:   30 days from Invoice Date ",0,0,'L',0,"");




	}


















	