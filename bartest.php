<?php
session_start();
$l_name= $_SESSION['l_name'];
$f_name= $_SESSION['f_name'];
$phone= $_SESSION['phone'];
$u_id = $_SESSION['user_id'];
$v_type=$_SESSION['v_type'];
$bubba1=$_GET['t'];
/*require('./fpdf/fpdf.php');

$pdf = new FPDF('L','mm',array(76.2,50.8));
$pdf->AddPage();
$pdf->SetFont('Arial');
$pdf->SetFontSize(16);
$pdf->SetXY(3,5);
$pdf->Write(0,"SJA Catholic School");
$pdf->SetXY(3,10);
$pdf->Write(0,$f_name);
$pdf->Write(0," ");
$pdf->Write(0,$l_name);
$pdf->SetXY(3,20);
$pdf->Write(0,$bubba1);
$pdf->AddFont('code39','','code39.php');
$pdf->SetFont('code39');
$pdf->SetFontSize(32);
$pdf->SetXY(3,30);
$bubba4='*'.$bubba1.'*';
$pdf->Write(0,$bubba4);
$pdf->Output();*/


require('./fpdf/pdf_js.php');

class PDF_AutoPrint extends PDF_JavaScript
{
    function AutoPrint($printer='')
    {
        // Open the print dialog
        if($printer)
        {
            $printer = str_replace('\\', '\\\\', $printer);
            $script = "var pp = getPrintParams();";
            $script .= "pp.interactive = pp.constants.interactionLevel.full;";
            $script .= "pp.printerName = '$printer'";
            $script .= "print(pp);";
        }
        else
            $script = 'print(true);';
        $this->IncludeJS($script);
    }
}
if ($v_type =='VIS') {
  $vname='VISITOR';
} else {
  $vname = 'VOLUNTEER';
}
$pdf = new PDF_AutoPrint('L','mm',array(76.2,50.8));
$pdf->AddPage();
$pdf->SetMargins(0,0);
$pdf->SetFont('Arial','B');
$pdf->SetFontSize(16);
$pdf->SetXY(17,6);
$pdf->Write(0,"SJA - ");
$pdf->Write(0,$vname);
$pdf->SetXY(10,14);
$full_name=$f_name.' '.$l_name;
$pdf->Cell(0, 0, $full_name, 0, 0, 'C');
$pdf->SetXY(15,20);
$pdf->SetFont('Arial');

$pdf->AddFont('code39','','code39.php');
$pdf->SetFont('code39');
$pdf->SetFontSize(25);
$pdf->SetXY(15,28);
$bubba4='*'.$bubba1.'*';

$pdf->Write(0,$bubba4);
$pdf->SetFont('Arial','I');
$pdf->SetXY(15,20);
$pdf->SetFontSize(10);
$bubba5=date('M/d/y',$bubba1);
$dday='Valid for '.$bubba5;
$pdf->Cell(0, 0, $dday, 0, 0, 'C');
//$pdf->Write(0,"Valid for ");

//$pdf->Write(0,$bubba5);
//Open the print dialog
$pdf->AutoPrint(true);
$pdf->Output();

?>
