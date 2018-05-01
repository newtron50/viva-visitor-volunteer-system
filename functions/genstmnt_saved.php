<?php
include($_SERVER['DOCUMENT_ROOT'].'/visitor/connect.php');
include($_SERVER['DOCUMENT_ROOT'].'/visitor/functions/session.php');
include($_SERVER['DOCUMENT_ROOT'].'/visitor/includes/links.php');
require($_SERVER['DOCUMENT_ROOT'].'/visitor/fpdf/fpdf.php');
// for testing

//
$reportmonth=$_POST['month'];
$reportyear=$_POST['year'];


include ($_SERVER['DOCUMENT_ROOT'].'/visitor/includes/date_today.php');
//create year display
$ppyear=$tyear-1;
$chopyear=substr($tyear,2);
$displayyear=$ppyear.' / '.$chopyear;
//  ****
$month=$reportmonth;
$year=$reportyear;
//$date_value="$month/$dt/$year";
//echo "mm/dd/yyyy format :$date_value<br>";
$date_value="$year-$month";
//echo "YYYY-mm-dd format :$date_value<br>";
$today=$date_value;
//get today's date for auto form fill
$start_date= $today.'-01';
$end_date=$today.'-31';
$bobo=$month.'/31/'.$year;
//month # into readable format
$monthNum  = $month;
$dateObj   = DateTime::createFromFormat('!m', $monthNum);
$monthName = $dateObj->format('F');
/// set record number for testing


//Generate statements for individuals
$q1=<<<SQL
select max(record_num)
as tops from people
SQL;
if(!$max1 = $conn->query($q1)){
die ();
}
while ($max = $max1->fetch_row()){
$max_user=$max[0];
}
// set array for users with info ordered by last name
$who=array();
$see=<<<SQL
  SELECT distinct family_grp
  from people
  order by last_name
SQL;
  //get name
  if(!$see1 = $conn->query($see)){
  die();
}
  while ($list = $see1->fetch_array()){
    $who[]=$list['family_grp'];
}
// $who[0]=1;
/// repeat for each group
$z=0;/// count for odd // even
foreach ($who as $rec) {
    $pdf = new FPDF('P','mm','Letter');
  if ($z !=0) {
    $pdf->AddPage();
  }
    $pdf->SetFont('Arial');
    $pdf->SetAutoPageBreak(false,0);
//See if there's information //  if not... move on


//*********************
$q3=<<<SQL
select CONCAT(first_name,' ',last_name) as full_name, last_name from people
where family_grp = $rec
SQL;
if(!$r3 = $conn->query($q3)){
die('There was an error running the query [' . $conn->error . ']');
}
$c1=0;

$d_who1=array();
while ($m3 = $r3->fetch_array()){
$d_who1[]=$m3;
$c1++;
}
if ($z% 2 == 0) {  /// Add Page Stuff
$pdf->AddPage();
}
$pdf->Image('../images/logo2.jpg',15,15,50);
$pdf->SetFont('Arial','B');
  $pdf->SetTextColor(1,43,140);
$pdf->SetFontSize(18);
$pdf->SetXY (85,30);
$pdf->Write(0,$displayyear);

$pdf->Write(0,' Volunteer Hours Statement');

  $pdf->SetTextColor(0,0,0);
$pdf->Line(75,39,210,39);
$pdf->SetXY (105,46);
$pdf->SetFontSize(16);
$pdf->Write(0,'For the ');
$pdf->Write(0,$d_who1[0][1]);
// save name to variable for file name
$full_name=$d_who1[0][1];
$pdf->Write(0,' Family*');
$pdf->SetFont('Arial');

$pdf->SetXY (15,180);
$pdf->SetFontSize(14);
$pdf->SetFont('Arial','B');
$pdf->Write(5, '*Group Members:');
$pdf->SetFont('Arial');
$pdf->SetFontSize(12);
$pdf->SetXY (9,51);

$space=180;

$zz=0;
foreach ($d_who1 as $nm) {
if ($zz% 2 == 0) {
  $pdf->SetXY (60,$space);
} else {
  $pdf->SetXY (100,$space);
  $space=$space+5;
}
$zz++;
  $pdf->Write(5,$nm[0]);

}
$pdf->Line(20,170,200,170);
$pdf->SetXY (10,32);

// group Totals
$fam_ttl=<<<SQL
SELECT  SEC_TO_TIME(sum(TIME_TO_SEC(v.vol_time_ttl)))as time, vs.v_class_name,v.vol_class, vs.level
from vol_log as v
inner join volunteer_classes as vs
on v.vol_class = vs.id
where family_grp = $rec group by v.vol_class
SQL;

if(!$result_ttl = $conn->query($fam_ttl)){
    die;
  }
$today_d=$monthName.' '.$tday.' '.$year;
$pdf->SetXY (80,70);
$pdf->SetFontSize(16);
$pdf->SetFont('Arial','B');
  $pdf->SetTextColor(1,43,140);
$pdf->Write(0,'TOTAL Volunteer Hours Completed:');
$pdf->SetTextColor (0,0,0);
$pdf->SetFont('Arial');
$pdf->SetFontSize(11);
$pdf->SetXY (85,77);
$pdf->Write(0,'as of ');
$rptrundate=$nmonth.' '.$tday.' '.$tyear;
$pdf->Write(0,$rptrundate);
$pdf->SetFontSize(12);
$grp_data=0;
while($row_ttl=$result_ttl->fetch_array()) {
  $clock1=$row_ttl['time'];
  $clock1=substr($clock1,0,-3);
$clock1 = preg_replace('/:/', ' hr ', $clock1);
$p6=$row_ttl['v_class_name'];
$p66=$clock1.' mins';
if ($grp_data%2 ==0){
$pdf->SetXY (120,88);
} else {
$pdf->SetXY (165,88);
}
    $pdf->SetFont('Arial','B');
$pdf->Write(0,$p6);
    $pdf->SetFont('Arial');
if ($grp_data%2 ==0){
$pdf->SetXY (120,94);
} else {
$pdf->SetXY (165,94);
}
$pdf->Write(0,$p66);
$grp_data++;
  }
  if ($grp_data==0) {
    $pdf->SetFont('Arial','B');
    $p6='No Hours Recorded for this group';
$pdf->SetXY (120,80);
$pdf->Write(0,$p6);
$pdf->SetFont('Arial');
  }
$pdf->Line(20,100,200,100);
  //Qtr activity
  $pdf->SetFontSize(14);
    $pdf->SetXY(15,110);
      $pdf->SetTextColor(1,43,140);
    $pdf->SetFont('Arial','B');
  $pdf->Write(0,'QUARTERLY Volunteer Hours Completed:');
  $pdf->SetFont('Arial');
  $pdf->SetTextColor (0,0,0);
// Quarterly Activity
include($_SERVER['DOCUMENT_ROOT'].'/visitor/includes/quarter.php');
$act=0;
//   ******** first Month Qtr
$pdf->SetXY (30,123);
$pdf->SetTextColor (0,0,0);

  $pdf->SetFontSize(14);
// convert # to month
$dateObj   = DateTime::createFromFormat('!m', $mcm);
$mcm = $dateObj->format('F');
$pdf->Write(0,$mcm);
$pdf->SetTextColor (0,0,0);
$pdf->SetFontSize(12);

while ($mt1 = $mh1->fetch_array()){
$r1=$mt1['v_class_name'];
$r2=$mt1['time'];
$r2 = preg_replace('/:/', ' hr ', $r2);
if ($act % 2 ==0){
$pdf->SetXY (70,120);
$pdf->SetFont('Arial','B');
$pdf->Write (0,$r1);
$pdf->SetFont('Arial');
$pdf->SetXY (70,125);
$pdf->Write(0,$r2);
$pdf->Write(0,' mins');
}
if (($act% 2) == 1){
$pdf->SetXY (110,120);
$pdf->SetFont('Arial','B');
$pdf->Write (0,$r1);
$pdf->SetFont('Arial');
$pdf->SetXY (110,125);
$pdf->Write (0,$r2);
$pdf->Write (0,' mins');
}
$act++;
}
if ($act==0) {
$pdf->SetXY (70,122);
  $pdf->Write(0,'No Activity for this Month');
}
//**************** 2nd Month
$pdf->SetXY (30,140);

$pdf->SetFontSize(14);

// convert # to month
$dateObj   = DateTime::createFromFormat('!m', $mpm);
$mpm = $dateObj->format('F');
$pdf->Write(0,$mpm);

$pdf->SetFontSize(12);
$act=0;
while ($mt2 = $mh2->fetch_array()){
$ro1=$mt2['v_class_name'];
$ro2=$mt2['time'];
$ro2 = preg_replace('/:/', ' hr ', $ro2);
if ($act % 2 ==0){
$pdf->SetXY (70,138);
$pdf->SetFont('Arial','B');
$pdf->Write (0,$ro1);
$pdf->SetFont('Arial');
$pdf->SetXY (70,143);
$pdf->Write(0,$ro2);
$pdf->Write(0,' mins');
}
if (($act% 2) == 1){
$pdf->SetXY (110,138);
$pdf->SetFont('Arial','B');
$pdf->Write (0,$ro1);
$pdf->SetFont('Arial');
$pdf->SetXY (110,143);
$pdf->Write (0,$ro2);
$pdf->Write (0,' mins');
}
$act++;
}
if ($act==0) {
$pdf->SetXY (70,140);
  $pdf->Write(0,'No Activity for this Month');
}
//**************** 3nd Month
$pdf->SetXY (30,157);

$pdf->SetFontSize(10);
$pdf->SetFontSize(14);
// convert # to month
$dateObj= DateTime::createFromFormat('!m', $mtm);
$mtm = $dateObj->format('F');
$pdf->Write(0,$mtm);
$pdf->SetTextColor (0,0,0);
$pdf->SetFontSize(12);
$act=0;
while ($mt3 = $mh3->fetch_array()){
$rq1=$mt3['v_class_name'];
$rq2=$mt3['time'];
$rq2 = preg_replace('/:/', ' hr ', $rq2);
  if ($act % 2 ==0){
  $pdf->SetXY (70,155);
  $pdf->SetFont('Arial','B');
  $pdf->Write (0,$rq1);
  $pdf->SetFont('Arial');
  $pdf->SetXY (70,160);
  $pdf->Write(0,$rq2);
  $pdf->Write(0,' mins');
}
if (($act% 2) == 1){
  $pdf->SetXY (110,155);
  $pdf->SetFont('Arial','B');
  $pdf->Write (0,$rq1);
  $pdf->SetFont('Arial');
  $pdf->SetXY (110,160);
  $pdf->Write (0,$rq2);
  $pdf->Write (0,' mins');
}
  $act++;
}
  if ($act==0) {
  $pdf->SetXY (70,157);
    $pdf->Write(0,'No Activity for this Month');
  }
// ******************* end of quarter section
//*************** end of Quarter



$pdf->Line(20,220,200,220);
$pdf->SetXY (80,225);
  $pdf->SetFont('Arial','u');
$pdf->Write(0,'Service Hour Requirements');
  $pdf->SetFont('Arial');
$pdf->SetXY (66,230);
$pdf->SetFontSize(10);
  $pdf->SetFont('Arial','i');
$pdf->Write(0,'**Two Parent Families: 20 Development, 15 Fair Share');
$pdf->SetXY (65,235);
$pdf->Write(0,'Single Parent Families: 10 Development, 7.5 Fair Share');
$pdf->SetXY (68,240);
$pdf->Write(0,'Preschool Families: 5 Development, 10 Fair Share');
$pdf->SetFont('Arial');

$pdf->SetXY (46,253);
$pdf->Write(0,'Service hours need to be completed and documented by May 31, ');
$pdf->Write(0,$year);

$pdf->SetXY(55,260);
$pdf->SetFontSize(16);
$pdf->Write(0,'Thank you for your service hours at SJA');
$z++;

$ptt='/var/www/html/visitor/files/';
$mcm1=substr($mcm,0,3);
$mpm1=substr($mpm,0,3);
$mtm1=substr($mtm,0,3);
$savepath=$ptt.$full_name.'_'.$mcm1.'_'.$mpm1.'_'.$mtm1.'.pdf';
$pdf->Output($savepath,'F');
}// foreach repeat
header("location: ../admin/a_set.php");
?>
