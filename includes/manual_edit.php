<?php
include('../connect.php');
include('../functions/session.php');
include('../functions/header.php');
// Pull info from previous form
$outtime = $_GET['ot'];
$bout = $_GET['bc'];

$vol_code = $_GET['vc'];
$ckout= $_GET['ck'];
$uid= $_GET['u'];
//
//Get users family group if a volunteer
if ($vol_code != 'VIS') {
$sql_fam=<<<SQL
 SELECT family_grp from people
 where user_id = $uid;
SQL;
if(!$result_fam = $conn->query($sql_fam)){
    die;
}
while($row_fam=$result_fam->fetch_assoc()){
$family_grp = $row_fam['family_grp'];
  }
}
// Get info for volunteer log
$sql=<<<SQL
 SELECT * FROM record_log
 WHERE code_in is NULL
 and barcode_assign = $bout
SQL;
if(!$result = $conn->query($sql)){
    die('There was an barcode checkout error running the query [' . $conn->error . ']<br>Please advise your administrator of this error.');
}
while($row=$result->fetch_assoc()){
$recd=$row['record_num'];
$user_id = $row['user_id'];
$fname = $row['first_name'];
$lname= $row['last_name'];
// for volunteer traciking  *******
$reason = $row['reason'];
$vol_class= $row['vol_class'];
$time_out = $row['code_out'];
}

//echo '<center><br><br>'.$outtime.'<br>'.$bout.'<br>'.$vol_code.'<br>'.$ckout.'<br>'.$uid.'</center>';
$final_date = substr("$outtime",0,10).' '.$ckout;
//Update record_log
$sql_rec="UPDATE record_log SET code_in = '$final_date' where code_in is NULL and code_out = '$outtime'";

if(($conn->query($sql_rec)=== TRUE) ){
  echo "<br><p style='text-align:center;font-size:1em;font-family:Arial;'>Record log is updated<br>Logged out at: <br>".$ckout."</p><br><br>";
  } else {
    echo "Error record log: " . $sql . "<br>" . $conn->error;
  }
// update barcode status
$insert_row1 = "UPDATE barcodes SET status=0 where barcode = '$bout' ";
if(($conn->query($insert_row1)=== TRUE) ){
  echo "<p style='text-align:center;font-size:1em;font-family:Arial;'>Barcode status updated. </p><br><br>";
} else {
  echo "Error record log: " . $sql . "<br>" . $conn->error;
}

// Get info for volunteer log
// Modify Dates --
$yr_mtime =substr("$outtime",0,4);
$mon_mtime=substr("$outtime",5,2);
$day_mtime=substr("$outtime",8,2);
$back_date= $mon_mtime.'-'.$day_mtime.'-'.$yr_mtime;

//***************************************
// *** time functions for setting volunteer hours
$time = $ckout;
$fulltime = substr("$outtime",0,10).' '.$ckout;
$time_a = $time_out;
$time_b = $fulltime;
$time_aa = strtotime($time_a);
$time_bb = strtotime($time_b);
$difference = $time_bb - $time_aa;
$diff_1 = ($difference/60);
$diff_1 = number_format($diff_1,2);
$today_date = date("m/d/Y");

//***** convert time for correct entry_date
function convertToHoursMins($time, $format = '%d:%s') {
    settype($time, 'integer');
    if ($time < 0 || $time >= 1440) {
        return;
    }
    $hours = floor($time/60);
    $minutes = $time%60;
    if ($minutes < 10) {
        $minutes = '0' . $minutes;
    }
    return sprintf($format, $hours, $minutes);
}
// ** end of function
$diff_2 = convertToHoursMins($diff_1, '%02d:%02d');

//echo $back_date.','.$diff_2.','.$vol_class.','.$reason.','.$today_date.','.$family_grp;
//*****************************************/

if ($vol_code != 'VIS') {
  // *** record entry for VOLUNTEER PROGRAM
$create_record = "INSERT into vol_log (user_id, last_name, first_name, vol_date, vol_time_ttl, vol_class, vol_subject, entered_by, entry_date,family_grp) VALUES ($uid,'$lname','$fname','$back_date','$diff_2','$vol_class','$reason','Manual Logout','$today_date',$family_grp)";
if(($conn->query($create_record)=== TRUE) ){
      echo "<br><p style='text-align:center;font-size:1em;font-family:Arial;'>Volunteer time has been updated </p><br><br>";
}
}

?>
