<?php
include($_SERVER['DOCUMENT_ROOT'].'/visitor/connect.php');
include($_SERVER['DOCUMENT_ROOT'].'session.php');
include($_SERVER['DOCUMENT_ROOT'].'/visitor/includes/links.php');
require($_SERVER['DOCUMENT_ROOT'].'/visitor/fpdf/fpdf.php');
$rpttype=$_POST['rpttype'];
$reportmonth=$_POST['month'];
$reportyear=$_POST['year'];


include ($_SERVER['DOCUMENT_ROOT'].'/visitor/includes/date_today.php');

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

if ($rpttype=='m') {
$pdf = new FPDF('P','mm','Letter');
$pdf->AliasNbPages();
$pdf->SetFont('Arial','B',12);

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

$z=0;
foreach ($who as $rec) {

//See if there's information //  if not... move on

$q3=<<<SQL
select CONCAT(first_name,' ',last_name) as full_name, family_grp, user_id from people
where family_grp = $rec
SQL;
if(!$r3 = $conn->query($q3)){
die('There was an error running the query [' . $conn->error . ']');
}
$d_who1=array();
$d_who2=array();
$d_who1=array();
while ($m3 = $r3->fetch_array()){
$d_who[]=$m3['full_name'];

}

$pdf->AddPage();
$pdf->Image('../images/logo.png',80,3,30);
$pdf->SetXY (5,15);
$pdf->SetFontSize(8);
$pdf->Write(5,'Volunteer information for:  ');
$pdf->Write(5,$rec);
$pdf->Write(5,$full_name);
$pdf->SetXY (5,25);

$pdf->SetFontSize(8);
$pdf->Write(5, 'Individual Volunteer Class Totals');
$y1=0;
$pb='      ';
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
$pdf->SetXY (110,25);
$pdf->SetFontSize(8);
$pdf->Write(5,'Group Volunteer Class Totals');
$pdf->SetXY (110,32);
$pdf->SetFontSize(8);
$grp_data=0;
while($row_ttl=$result_ttl->fetch_array()) {
  $clock1=$row_ttl['time'];
  $clock1=substr($clock1,0,-3);
$p6=$row_ttl['v_class_name'].' --  '.$clock1;
$pdf->SetDrawColor(50,60,100);
$pdf->Cell(40,4,$p6,1,0,'C',0);
$grp_data++;
  }
  if ($grp_data==0) {
$pdf->Write(5,'No data available for this group');
  }
//write month Activity

$sql8=<<<SQL
select r.vol_date, r.vol_subject, TIME_FORMAT(r.vol_time_ttl, "%H:%i") as time, v.v_class_name,  r.entered_by from
  vol_log as r
  inner join volunteer_classes as v on
  r.vol_class = v.id
  where r.family_grp = $rec and STR_TO_DATE(r.vol_date ,'%m/%d/%Y') BETWEEN '$start_date' and '$end_date' order by r.vol_date DESC
SQL;
if(!$result8 = $conn->query($sql8)){
    die();
}
$x=0;
$p7='Activity Report for '.$monthName.' '.$reportyear;
$pdf->SetXY (60,40);
$pdf->SetFontSize(8);
$pdf->Write(5,$p7);
$spa=50;
$spc='                    ';
$spc2='                              ';
while($row8=$result8->fetch_array()){
    if ($x==0) {
      $sp1='                                ';
        $p8='Date'.$sp1.'Time'.$sp1.'Reason'.$sp1.'Volunteer Class';
        $pdf->SetXY (35,45);
      $pdf->SetFontSize(8);
      $pdf->Cell(140,4,$p8,1,1,'C',0);
      }
$x++;
$ttl_time=$row8['time'];
$btime = $row8['vol_date'];
$time= strtotime($btime);
$monthcode = date( 'M-d-Y', $time );
$p9=$monthcode.$spc.$ttl_time.$spc2.$row8['vol_subject'].$spc2.$row8['v_class_name'];
$pdf->SetXY(43,$spa);
$pdf->Write(5,$p9);
$spa=$spa+5;
}

//echo '</table></div></div>';
    if ($x==0) {
$pdf->Write(5,'$No Activity for this month');
}
}
$pdf->Output();
} elseif ($rpttype=='q') {
//quarterly reports

} else if ($rpttype=='eof'){
//end of year reports

} else {
  echo 'Error from input';
  echo $rpttype.' '.$reportmonth.' '.$reportyear.' ';
}


?>
