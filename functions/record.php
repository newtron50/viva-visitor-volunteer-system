<?php
include('../connect.php');
include('../functions/session.php');
include('../functions/header.php');

$status=$_GET['t'];
$record=$_GET['r'];

if ($status=='d'){
$reas='deleted by:'.$login_name;
$delr = "UPDATE vol_log set user_id = 0, entered_by = '$reas', vol_time_ttl='00:00:00',entry_date=DATE_FORMAT(NOW(),'%m/%d/%Y'), family_grp=0 where record = $record";
echo '<br><br><br><div class="centered"><center>';
  if(($conn->query($delr)=== TRUE) ){
  echo 'The Requested Record has been Deleted<br>';
} else {
    echo 'There was an error in deleting the requested record<br>';
}
echo '<br><br><br><a href="../admin/settings.php" class="g_bubble">Return to Menu</a>';



} else {
  $reas='time modified:'.$login_name;
  echo'<br><br><div class="centered"><center>';

$record=$_POST['record'];
$name=$_POST['name'];
$hours=$_POST['hrs'];
// correct for leading 0000's
if($hours=='') {
  $hrs='00';
}
$min=$_POST['min'];
$colon=':';
$trailtime='00';

$htime=$hours.$colon.$min.$colon.$trailtime;
$dtime=$hours.$colon.$min;

  $updr = "UPDATE vol_log set vol_time_ttl = '$htime', entered_by = '$reas',entry_date=DATE_FORMAT(NOW(),'%m/%d/%Y') where record = $record";
  echo '<br><br><br><div class="centered"><center>';
    if(($conn->query($updr)=== TRUE) ){
    echo 'The Record for '.$name.' has been updated to show a total time of '.$dtime.'<br>';
  } else {
    echo 'Error modifying the records';
  }
  echo '<br><br><br><a href="../admin/settings.php" class="g_bubble">Return to Menu</a>';

}




?>
