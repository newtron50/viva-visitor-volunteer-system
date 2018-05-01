<?php
include($_SERVER['DOCUMENT_ROOT'].'/visitor/connect.php');
include($_SERVER['DOCUMENT_ROOT'].'/visitor/includes/date_today.php');
/********************************
Quarterly Report Settings
*********************************/
$year1=$tyear-1;
$year2=$tyear;
$choice=$reportmonth;

// Get today's date
$this_year=$tyear;
$cur_month=$tmonth;
if ($tmonth==1){
$prev_month=12;
$third_month=11;
$sec_year=$tyear-1;
  $third_year=$tyear-1;
} elseif ($tmonth==2) {
  $third_month=12;
  $prev_month=$cur_month-1;
  $sec_year=$tyear;
  $third_year=$tyear-1;
} else {
$prev_month=$cur_month-1;
$third_month=$cur_month-2;
$this_year=$tyear;
}
//echo 'y1 '.$year1.' y2 '.$year2.' cm '.$cur_month.' pm '.$prev_month.' tm '.$third_month;
$qtr_mth=array(6,7,8,9,10,11,12,1,2,3,4,5);

if ($choice == 1){ //chose Quarter 1
$mcy=$year1;
$mcm=$qtr_mth[0];
$mpy=$year1;
$mpm=$qtr_mth[1];
$mty=$year1;
$mtm=$qtr_mth[2];
}elseif ($choice==2) {  //chose Quarter 2
  $mcy=$year1;
  $mcm=$qtr_mth[3];
  $mpy=$year1;
  $mpm=$qtr_mth[4];
  $mty=$year1;
  $mtm=$qtr_mth[5];
} elseif ($choice==3) {  //chose Quater 3
  $mcy=$year1;
  $mcm=$qtr_mth[6];
  $mpy=$year2;
  $mpm=$qtr_mth[7];
  $mty=$year2;
  $mtm=$qtr_mth[8];
} elseif ($choice==4) {  //chose Quater 4
  $mcy=$year2;
  $mcm=$qtr_mth[9];
  $mpy=$year2;
  $mpm=$qtr_mth[10];
  $mty=$year2;
  $mtm=$qtr_mth[11];
} else {     //past 3 months
  $mcy=$tyear;
  $mcm=$cur_month;
  $mpy=$sec_year;
  $mpm=$prev_month;
  $mty=$third_year;
  $mtm=$third_month;
}
//echo '<br>mcy '.$mcy.' mcm '.$mcm.' mpy '.$mpy.' mpm '.$mpm.' mty '.$mty.' mtm '.$mtm;
//*********************************
// 1st month Query
$month_cur=<<<SQL
  SELECT vs.v_class_name, TIME_FORMAT(SEC_TO_TIME(sum(TIME_TO_SEC(v.vol_time_ttl))), "%H:%i")as time  from vol_log as v inner join
  volunteer_classes as vs on v.vol_class = vs.id
  where family_grp = $rec
  and YEAR(STR_TO_DATE(v.vol_date, '%m/%d/%Y')) = $mcy and MONTH(STR_TO_DATE(v.vol_date,'%m/%d/%Y')) = $mcm group by v.vol_class
SQL;

if(!$mh1 = $conn->query($month_cur)){
die();
}


//*********************************

// 2st month Query
$month_prev=<<<SQL
  SELECT vs.v_class_name, TIME_FORMAT(SEC_TO_TIME(sum(TIME_TO_SEC(v.vol_time_ttl))), "%H:%i")as time from vol_log as v inner join volunteer_classes as vs on v.vol_class = vs.id where family_grp = $rec and YEAR(STR_TO_DATE(v.vol_date, '%m/%d/%Y')) = $mpy and MONTH(STR_TO_DATE(v.vol_date,'%m/%d/%Y'))=$mpm group by v.vol_class
SQL;
if(!$mh2 = $conn->query($month_prev)){
die();
}



//3rd
$month_third=<<<SQL
  SELECT vs.v_class_name, TIME_FORMAT(SEC_TO_TIME(sum(TIME_TO_SEC(v.vol_time_ttl))), "%H:%i")as time from vol_log as v inner join volunteer_classes as vs on v.vol_class = vs.id where family_grp = $rec and YEAR(STR_TO_DATE(v.vol_date, '%m/%d/%Y')) = $mty and
  MONTH(STR_TO_DATE(v.vol_date,'%m/%d/%Y'))=$mtm group by v.vol_class
SQL;
if(!$mh3 = $conn->query($month_third)){
die();
}



?>
