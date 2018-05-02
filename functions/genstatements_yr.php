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
  $pdf->Write(0,'Volunteer Hours Completed by Member:');
  $pdf->SetFont('Arial');
  $pdf->SetTextColor (0,0,0);
// Group members activity for the year
include($_SERVER['DOCUMENT_ROOT'].'/visitor/includes/yr_member.php');
$act=0;
//   ******** individual report
$pdf->SetXY (15,105);
$pdf->SetTextColor (0,0,0);
$pdf->SetFontSize(10);

// convert # to month
$mv_down=102;
$mv_dn1=106;
$mvd=103;
$lnm=109;
$pdf->SetTextColor (0,0,0);
$rn=0;
while ($ok = $ok1->fetch_array()){
$r4=$ok['user_id'];
$r3=$ok['name'];
$r1=$ok['v_class_name'];
$r2=$ok['time'];
if ($r4!=$rn) {
  $pdf->SetXY(10,$mvd);
  $pdf->SetFontSize(10);
  $pdf->Write(0,$r3);
  $mvd=$mvd+12;
}
$rn=$r4;
$pdf->SetFontSize(9);
$r2 = preg_replace('/:/', ' hr ', $r2);
if ($act % 2 ==0){
$pdf->SetXY (45,$mv_down);
$pdf->SetFont('Arial','B');
$pdf->Write (0,$r1);
$pdf->SetFont('Arial');
$pdf->SetXY (45,$mv_dn1);
$pdf->Write(0,$r2);
$pdf->Write(0,' mins');
}
if (($act% 2) == 1){
$pdf->SetXY (85,$mv_down);
$pdf->SetFont('Arial','B');
$pdf->Write (0,$r1);
$pdf->SetFont('Arial');
$pdf->SetXY (85,$mv_dn1);
$pdf->Write (0,$r2);
$pdf->Write (0,' mins');
$mv_down=$mv_down+10;
$mv_dn1=$mv_dn1+10;
$lnm=$lnm+10;
}
$pdf->SetLineWidth(.01);
$pdf->Line(40,$lnm,110,$lnm);
$act++;
}


$pdf->SetFontSize(9);
$pdf->Line(15,160,125,160);
$pdf->SetXY (20,189);

$pdf->SetXY (10,194);

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
$pdf->SetXY (145,51);

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
$pdf->Write(0,'Volunteer Hours Completed by Member:');
$pdf->SetTextColor (0,0,0);
$pdf->SetFont('Arial');
// Group members activity for the year
include($_SERVER['DOCUMENT_ROOT'].'/visitor/includes/yr_member.php');
$act=0;
//   ******** individual report
$pdf->SetXY (15,105);
$pdf->SetTextColor (0,0,0);
$pdf->SetFontSize(10);


$mv_down=102;
$mv_dn1=106;
$mvd=103;
$lnm=109;
$pdf->SetTextColor (0,0,0);
$rn=0;
while ($ok = $ok1->fetch_array()){
$r4=$ok['user_id'];
$r3=$ok['name'];
$r1=$ok['v_class_name'];
$r2=$ok['time'];
if ($r4!=$rn) {
  $pdf->SetXY(145,$mvd);
  $pdf->SetFontSize(10);
  $pdf->Write(0,$r3);
  $mvd=$mvd+12;
}
$rn=$r4;
$pdf->SetFontSize(9);
$r2 = preg_replace('/:/', ' hr ', $r2);
if ($act % 2 ==0){
$pdf->SetXY (185,$mv_down);
$pdf->SetFont('Arial','B');
$pdf->Write (0,$r1);
$pdf->SetFont('Arial');
$pdf->SetXY (185,$mv_dn1);
$pdf->Write(0,$r2);
$pdf->Write(0,' mins');
}
if (($act% 2) == 1){
$pdf->SetXY (230,$mv_down);
$pdf->SetFont('Arial','B');
$pdf->Write (0,$r1);
$pdf->SetFont('Arial');
$pdf->SetXY (230,$mv_dn1);
$pdf->Write (0,$r2);
$pdf->Write (0,' mins');
$mv_down=$mv_down+10;
$mv_dn1=$mv_dn1+10;
$lnm=$lnm+10;
}
$pdf->SetLineWidth(.01);
$pdf->Line(180,$lnm,255,$lnm);
$act++;
}
// ******************* end of quarter section
  $pdf->SetFontSize(9);
$pdf->Line(150,160,265,160);
  $pdf->SetXY (160,189);

  $pdf->SetXY (148,194);

$pdf->Write(0,$year);
$pdf->SetXY(150,203);
$pdf->SetFontSize(16);
$pdf->Write(0,'Thank you for your service hours');
$z++;
}//end of even repeat
}// foreach repeat

$pdf->Output();




?>
