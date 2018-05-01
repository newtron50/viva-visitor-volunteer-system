<?php
include('../connect.php');
include('../functions/session.php');
include('../functions/header.php');

if ($login_lvl>=2){

$bc=$_GET['bc'];
$tc=$_GET['tc'];
$uid=$_GET['uid'];



$sql_edit="select * from record_log where code_out = '$tc'";
if(!$result5 = $conn->query($sql_edit)){
  die('There was an error running the query [' . $conn->error . ']');
}
    while($row5=$result5->fetch_array()){
echo '<br><center><span style="font-size:20px;"> '.$row5['first_name'].'&nbsp'.$row5['last_name'].'</span><br><br>Reason:'.$row5['reason'].'<br><br>Logged in at: '.$row5['code_out'].'<br><br><br><br>';
$bcode_co = $row5['barcode_assign'];
$date_in = $row5['code_out'];
$vol_code = $row5['type'];
$uid= $row5['user_id'];
}
$date_in_test = substr("$date_in",0,10);
$current_date = date('Y-m-d');
if ( $date_in_test == $current_date ){
echo '<div style="float:left;padding-left:300px;"><a href="../checkout.php?barcode='.$bcode_co.'&admin=1" class="menu_r">Check the Visitor<br> In Now</center></a></div>';
echo '<div style="float:left;padding-left:200px;"><br>';
}

echo '<span class="menu_r">Choose a check out time</span>';
$time_set=substr("$date_in",11,8);
$time_hr=substr("$date_in",11,2);
$time_min=substr("$date_in",14,2);
$time_hr_1=$time_hr;
if ($time_min <= 14) {
  $time_m_st = 15;
  $tcount=1;
} else if ($time_min <= 29) {
  $tcount=2;
    $time_m_st = 30;
} else if ($time_min <= 44) {
    $time_m_st = 45;
    $tcount=3;
} else if ($time_min <= 59) {
    $tcount=0;
    $time_m_st = 00;
}
$increment = 15;
echo '<table class="time">';
while ($time_hr_1 <= 23){
  echo '<tr>';
while  ($tcount <= 3) {
if ($tcount == 0) {
echo '<td><a href="../includes/manual_edit.php?ot='.$date_in.'&bc='.$bcode_co.'&vc='.$vol_code.'&ck='.$time_hr_1.':00:00&u='.$uid.'">'.$time_hr_1.':00</a></td>';
} else {
echo '<td><a href="../includes/manual_edit.php?ot='.$date_in.'&bc='.$bcode_co.'&vc='.$vol_code.'&ck='.$time_hr_1.':'.($increment*$tcount).':00&u='.$uid.'">'.$time_hr_1.':'.($increment*$tcount).'</td><input type=hidden name=ckout value="'.$time_hr_1.':'.($increment*$tcount).':00">';
}
$tcount++;
}
if ($tcount > 3) {
  $tcount =0;;
  echo '</tr>';
}
$time_hr_1++;
}
echo '</table><br></center></div>';


} else {
header("location: admintest.php");
}
?>
