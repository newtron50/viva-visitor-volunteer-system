<?php
include($_SERVER['DOCUMENT_ROOT'].'/visitor/connect.php');
include($_SERVER['DOCUMENT_ROOT'].'/visitor/functions/session.php');
include($_SERVER['DOCUMENT_ROOT'].'/visitor/includes/links.php');
require($_SERVER['DOCUMENT_ROOT'].'/visitor/fpdf/fpdf.php');

$reportmonth=$_POST['month'];
$reportyear=$_POST['year'];


include ($_SERVER['DOCUMENT_ROOT'].'/visitor/includes/date_today.php');
//create year display
if ($tmonth > 7) {
$ppyear=$tyear;
$tyear=$tyear+1;
$chopyear=substr($tyear,2);
} else {
$ppyear=$tyear-1;
$chopyear=substr($tyear,2);
}
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


$pdf = new FPDF('L','mm','Letter');
$pdf->AliasNbPages();
$pdf->SetFont('Arial');
$pdf->SetAutoPageBreak(false,0);

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

/// repeat for each group
$z=0;/// count for odd // even
foreach ($who as $rec) {
if ($z% 2 == 0) {
//See if there's information //  if not... move on
//   *** initialize arrays for quarter reports

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
$pdf->Image('../images/logo2.jpg',10,10,35);
$pdf->SetFont('Arial','B');
  $pdf->SetTextColor(1,43,140);
$pdf->SetFontSize(18);
$pdf->SetXY (72,18);
$pdf->Write(0,$displayyear);
$pdf->SetXY (60,25);
$pdf->Write(0,'Volunteer Hours');
$pdf->SetXY (70,33);
$pdf->Write(0,'Statement');
  $pdf->SetTextColor(0,0,0);
$pdf->Line(55,39,120,39);
$pdf->SetXY (68,46);
$pdf->SetFontSize(16);

$pdf->Write(0,$d_who1[0][1]);
$pdf->Write(0,' Family*');
$pdf->SetFont('Arial');

$pdf->SetXY (12,164);
$pdf->SetFontSize(12);
$pdf->SetFont('Arial','B');
$pdf->Write(5, '*Group Members:');
$pdf->SetFont('Arial');
$pdf->SetFontSize(10);
$pdf->SetXY (9,51);

$space=164;

$zz=0;
foreach ($d_who1 as $nm) {
if ($zz% 2 == 0) {
  $pdf->SetXY (49,$space);
} else {
  $pdf->SetXY (85,$space);
  $space=$space+4;
}
$zz++;
  $pdf->Write(5,$nm[0]);

}

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
$pdf->SetXY (9,60);
$pdf->SetFontSize(12);
$pdf->SetFont('Arial','B');
  $pdf->SetTextColor(1,43,140);
$pdf->Write(0,'TOTAL Volunteer Hours Completed:');
$pdf->SetTextColor (0,0,0);
$pdf->SetFont('Arial');
$pdf->SetFontSize(9);
$pdf->SetXY (9,65);
$pdf->Write(0,'as of ');
$rptrundate=$nmonth.' '.$tday.' '.$tyear;
$pdf->Write(0,$rptrundate);
$pdf->SetFontSize(10);
$grp_data=0;
while($row_ttl=$result_ttl->fetch_array()) {
  $clock1=$row_ttl['time'];
  $clock1=substr($clock1,0,-3);
$clock1 = preg_replace('/:/', ' hr ', $clock1);
$p6=$row_ttl['v_class_name'];
$p66=$clock1.' mins';
if ($grp_data%2 ==0){
$pdf->SetXY (45,75);
} else {
$pdf->SetXY (85,75);
}
    $pdf->SetFont('Arial','B');
$pdf->Write(0,$p6);
    $pdf->SetFont('Arial');
if ($grp_data%2 ==0){
$pdf->SetXY (45,81);
} else {
$pdf->SetXY (85,81);
}
$pdf->Write(0,$p66);
$grp_data++;
  }
  if ($grp_data==0) {
    $pdf->SetFont('Arial','B');
    $p6='No Hours Recorded for this group';
$pdf->SetXY(40,75);
$pdf->Write(0,$p6);
$pdf->SetFont('Arial');
  }
$pdf->Line(15,88,125,88);
  //Qtr activity
  $pdf->SetFontSize(12);
    $pdf->SetXY(9,95);
      $pdf->SetTextColor(1,43,140);
    $pdf->SetFont('Arial','B');
  $pdf->Write(0,'QUARTERLY Volunteer Hours Completed:');
  $pdf->SetFont('Arial');
  $pdf->SetTextColor (0,0,0);
// Quarterly Activity
include($_SERVER['DOCUMENT_ROOT'].'/visitor/includes/quarter.php');
$act=0;
//   ******** first Month Qtr
$pdf->SetXY (15,105);
$pdf->SetTextColor (0,0,0);
$pdf->SetFontSize(10);

// convert # to month
$dateObj   = DateTime::createFromFormat('!m', $mcm);
$mcm = $dateObj->format('F');
$pdf->Write(0,$mcm);
$pdf->SetTextColor (0,0,0);


while ($mt1 = $mh1->fetch_array()){
$r1=$mt1['v_class_name'];
$r2=$mt1['time'];
$r2 = preg_replace('/:/', ' hr ', $r2);
if ($act % 2 ==0){
$pdf->SetXY (45,105);
$pdf->SetFont('Arial','B');
$pdf->Write (0,$r1);
$pdf->SetFont('Arial');
$pdf->SetXY (45,111);
$pdf->Write(0,$r2);
$pdf->Write(0,' mins');
}
if (($act% 2) == 1){
$pdf->SetXY (85,105);
$pdf->SetFont('Arial','B');
$pdf->Write (0,$r1);
$pdf->SetFont('Arial');
$pdf->SetXY (85,111);
$pdf->Write (0,$r2);
$pdf->Write (0,' mins');
}
$act++;
}
if ($act==0) {
$pdf->SetXY (50,105);
  $pdf->Write(0,'No Activity for this Month');
}
//**************** 2nd Month
$pdf->SetXY (15,123);

$pdf->SetFontSize(10);

// convert # to month
$dateObj   = DateTime::createFromFormat('!m', $mpm);
$mpm = $dateObj->format('F');
$pdf->Write(0,$mpm);


$act=0;
while ($mt2 = $mh2->fetch_array()){
$ro1=$mt2['v_class_name'];
$ro2=$mt2['time'];
$ro2 = preg_replace('/:/', ' hr ', $ro2);
if ($act % 2 ==0){
$pdf->SetXY (45,123);
$pdf->SetFont('Arial','B');
$pdf->Write (0,$ro1);
$pdf->SetFont('Arial');
$pdf->SetXY (45,129);
$pdf->Write(0,$ro2);
$pdf->Write(0,' mins');
}
if (($act% 2) == 1){
$pdf->SetXY (85,123);
$pdf->SetFont('Arial','B');
$pdf->Write (0,$ro1);
$pdf->SetFont('Arial');
$pdf->SetXY (85,129);
$pdf->Write (0,$ro2);
$pdf->Write (0,' mins');
}
$act++;
}
if ($act==0) {
$pdf->SetXY (50,123);
  $pdf->Write(0,'No Activity for this Month');
}
//**************** 3nd Month
$pdf->SetXY (15,141);

$pdf->SetFontSize(10);

// convert # to month
$dateObj= DateTime::createFromFormat('!m', $mtm);
$mtm = $dateObj->format('F');
$pdf->Write(0,$mtm);
$pdf->SetTextColor (0,0,0);

$act=0;
while ($mt3 = $mh3->fetch_array()){
$rq1=$mt3['v_class_name'];
$rq2=$mt3['time'];
$rq2 = preg_replace('/:/', ' hr ', $rq2);
  if ($act % 2 ==0){
  $pdf->SetXY (45,141);
  $pdf->SetFont('Arial','B');
  $pdf->Write (0,$rq1);
  $pdf->SetFont('Arial');
  $pdf->SetXY (45,147);
  $pdf->Write(0,$rq2);
  $pdf->Write(0,' mins');
}
if (($act% 2) == 1){
  $pdf->SetXY (85,141);
  $pdf->SetFont('Arial','B');
  $pdf->Write (0,$rq1);
  $pdf->SetFont('Arial');
  $pdf->SetXY (85,147);
  $pdf->Write (0,$rq2);
  $pdf->Write (0,' mins');
}
  $act++;
}
  if ($act==0) {
  $pdf->SetXY (50,141);
    $pdf->Write(0,'No Activity for this Month');
  }
// ******************* end of quarter section
//*************** end of Quarter
$pdf->SetFontSize(8);
$pdf->Line(15,160,125,160);
$pdf->SetXY (10,185);
  $pdf->SetFont('Arial','U');
//$pdf->Write(0,'Service Hour Requirements:');
  $pdf->SetFont('Arial');
//$pdf->Write(0,' Two Parent Families: 20 Development , 15 Fair Share');
$pdf->SetXY (46,188);

$pdf->SetXY (46,191);

$pdf->SetFontSize(9);
$pdf->SetXY (10,196);

$pdf->Write(0,$year);

$pdf->SetXY(10,203);
$pdf->SetFontSize(16);
$pdf->Write(0,'Thank you for your service hours');
$z++;
$pdf->Line(140,4,140,195);
} else {// odd/even repeat**************************************************************

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

$pdf->Image('../images/logo2.jpg',152,10,35);
$pdf->SetFont('Arial','B');
  $pdf->SetTextColor(1,43,140);
$pdf->SetXY (212,18);
$pdf->SetFontSize(18);
$pdf->Write(0,$displayyear);
$pdf->SetXY (200,25);
$pdf->Write(0,'Volunteer Hours');
$pdf->SetXY (210,33);
$pdf->Write(0,'Statement');
  $pdf->SetTextColor(0,0,0);
$pdf->Line(195,39,265,39);
$pdf->SetFontSize(16);
$pdf->SetXY (208,46);

$pdf->Write(0,$d_who1[0][1]);
$pdf->Write(0,' Family*');
$pdf->SetFont('Arial');
$pdf->SetXY (150,164);
$pdf->SetFontSize(12);
$pdf->SetFont('Arial','B');
$pdf->Write(5, '*Group Members:');
$pdf->SetFont('Arial');
$pdf->SetFontSize(10);


$space=164;
$zz=0;
foreach ($d_who1 as $nm) {
if ($zz% 2 == 0) {
  $pdf->SetXY (187,$space);
} else {
  $pdf->SetXY (230,$space);
  $space=$space+4;
}
$zz++;
  $pdf->Write(5,$nm[0]);

}

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
$today_d=$monthName.' '.$tday.', '.$year;
$pdf->SetXY (151,60);
$pdf->SetFontSize(12);
$pdf->SetFont('Arial','B');
  $pdf->SetTextColor(1,43,140);
$pdf->Write(0,'TOTAL Volunteer Hours Completed:');
$pdf->SetTextColor (0,0,0);
$pdf->SetFont('Arial');
$pdf->SetFontSize(9);
$pdf->SetXY (151,65);
$pdf->Write(0,'as of ');
$rptrundate=$nmonth.' '.$tday.' '.$tyear;
$pdf->Write(0,$rptrundate);
$pdf->SetFontSize(10);
$grp_data=0;
while($row_ttl=$result_ttl->fetch_array()) {
    $clock1=$row_ttl['time'];
    $clock1=substr($clock1,0,-3);
    $clock1 = preg_replace('/:/', ' hr ', $clock1);
  $p6=$row_ttl['v_class_name'];
  $p66=$clock1.' mins';
  if ($grp_data%2 ==0){
  $pdf->SetXY (190,75);
  } else {
  $pdf->SetXY (230,75);
  }
      $pdf->SetFont('Arial','B');
  $pdf->Write(0,$p6);
      $pdf->SetFont('Arial');
  if ($grp_data%2 ==0){
  $pdf->SetXY (190,81);
  } else {
  $pdf->SetXY (230,81);
  }
  $pdf->Write(0,$p66);
  $grp_data++;
    }
if ($grp_data==0) {
  $pdf->SetFont('Arial','B');
      $p6='No Hours Recorded for this group';
  $pdf->SetXY(180,75);
$pdf->Write(0,$p6);
$pdf->SetFont('Arial');
}
$pdf->Line(150,88,265,88);
//Qtr activity
$pdf->SetFontSize(12);
  $pdf->SetXY(151,95);
  $pdf->SetFont('Arial','B');
  $pdf->SetTextColor(1,43,140);
$pdf->Write(0,'QUARTERLY Volunteer Hours Completed:');
$pdf->SetTextColor (0,0,0);
$pdf->SetFont('Arial');
  // Quarterly Activity
include($_SERVER['DOCUMENT_ROOT'].'/visitor/includes/quarter.php');
  $act=0;
//   ******** first Month Qtr
$pdf->SetXY (156,104);
$pdf->SetTextColor (0,0,0);
$pdf->SetFontSize(10);

// convert # to month
$dateObj   = DateTime::createFromFormat('!m', $mcm);
$mcm = $dateObj->format('F');
$pdf->Write(0,$mcm);
$pdf->SetTextColor (0,0,0);


while ($mt1 = $mh1->fetch_array()){
$r1=$mt1['v_class_name'];
$r2=$mt1['time'];
$r2 = preg_replace('/:/', ' hr ', $r2);
  if ($act % 2 ==0){
  $pdf->SetXY (185,104);
  $pdf->SetFont('Arial','B');
  $pdf->Write (0,$r1);
  $pdf->SetFont('Arial');
  $pdf->SetXY (185,110);
  $pdf->Write(0,$r2);
  $pdf->Write(0,' mins');
}
if (($act% 2) == 1){
  $pdf->SetXY (230,104);
  $pdf->SetFont('Arial','B');
  $pdf->Write (0,$r1);
  $pdf->SetFont('Arial');
  $pdf->SetXY (230,110);
  $pdf->Write (0,$r2);
  $pdf->Write (0,' mins');
}
  $act++;
  }
  if ($act==0) {
  $pdf->SetXY (190,104);
    $pdf->Write(0,'No Activity for this Month');
  }
//**************** 2nd Month
$pdf->SetXY (156,123);

$pdf->SetFontSize(10);

// convert # to month
$dateObj   = DateTime::createFromFormat('!m', $mpm);
$mpm = $dateObj->format('F');
$pdf->Write(0,$mpm);


$act=0;
while ($mt2 = $mh2->fetch_array()){
$ro1=$mt2['v_class_name'];
$ro2=$mt2['time'];
$ro2 = preg_replace('/:/', ' hr ', $ro2);
  if ($act % 2 ==0){
  $pdf->SetXY (185,123);
  $pdf->SetFont('Arial','B');
  $pdf->Write (0,$ro1);
  $pdf->SetFont('Arial');
  $pdf->SetXY (185,129);
  $pdf->Write(0,$ro2);
  $pdf->Write(0,' mins');
}
if (($act% 2) == 1){
  $pdf->SetXY (230,123);
  $pdf->SetFont('Arial','B');
  $pdf->Write (0,$ro1);
  $pdf->SetFont('Arial');
  $pdf->SetXY (230,129);
  $pdf->Write (0,$ro2);
  $pdf->Write (0,' mins');
}
  $act++;
}
  if ($act==0) {
  $pdf->SetXY (190,123);
    $pdf->Write(0,'No Activity for this Month');
  }
  //**************** 3nd Month
  $pdf->SetXY (156,141);

  $pdf->SetFontSize(10);

  // convert # to month
$dateObj= DateTime::createFromFormat('!m', $mtm);
$mtm = $dateObj->format('F');
$pdf->Write(0,$mtm);


$act=0;
while ($mt3 = $mh3->fetch_array()){
  $rq1=$mt3['v_class_name'];
  $rq2=$mt3['time'];
  $rq2 = preg_replace('/:/', ' hr ', $rq2);
    if ($act % 2 ==0){
    $pdf->SetXY (185,141);
    $pdf->SetFont('Arial','B');
    $pdf->Write (0,$rq1);
    $pdf->SetFont('Arial');
    $pdf->SetXY (185,147);
    $pdf->Write(0,$rq2);
    $pdf->Write(0,' mins');
  }
  if (($act% 2) == 1){
    $pdf->SetXY (230,141);
    $pdf->SetFont('Arial','B');
    $pdf->Write (0,$rq1);
    $pdf->SetFont('Arial');
    $pdf->SetXY (230,147);
    $pdf->Write (0,$rq2);
    $pdf->Write (0,' mins');
  }
    $act++;
  }
    if ($act==0) {
    $pdf->SetXY (190,141);
      $pdf->Write(0,'No Activity for this Month');
    }
// ******************* end of quarter section
  $pdf->SetFontSize(9);
$pdf->Line(150,160,265,160);
$pdf->SetXY (148,185);
  $pdf->SetFont('Arial','U');
//$pdf->Write(0,'Service Hour Requirements:');
  $pdf->SetFont('Arial');
//$pdf->Write(0,' Two Parent Families: 20 Development , 15 Fair Share');
$pdf->SetXY (189,188);

$pdf->SetXY (189,191);

$pdf->SetFontSize(9);
  $pdf->SetXY (148,196);

$pdf->Write(0,$year);
$pdf->SetXY(150,203);
$pdf->SetFontSize(16);
$pdf->Write(0,'Thank you for your service hours');
$z++;
}//end of even repeat
}// foreach repeat

$pdf->Output();




?>
