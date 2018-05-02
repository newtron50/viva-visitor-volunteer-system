<?php
include('connect.php');
include("./includes/data.php");

$barcode = $_GET['barcode'];
$admin_c=$_GET['admin'];
$barcode =preg_replace('/\D/', '', $barcode);
include (dirname(__FILE__).'/includes/guest_header.php');

//check barcode validity
if ($bctype==1){
$chk_st=<<<SQL
  SELECT count(barcode) as count
  from barcodes
  where barcode = $barcode
SQL;
if(!$st6 = $conn->query($chk_st)){
    die();
}
while ($st1 = $st6->fetch_row()){
$valid_code=$st1[0];
}
if ($valid_code!=NULL) {
  $valid_tag=1;
}
} else {
$valid_code=1;
////  check to see if barcode is in the same date, if not...error
$tag_date=date('m/d/Y',$barcode);
$tdaa=date('m/d/Y');
//echo '<center><br>'.$tag_date.' :: tag_date<br>';
//echo '<br>'.$tdaa.' :: today<br></center>';
if ($tag_date!=$tdaa) {
$valid_tag=0;
} else {
  $valid_tag=1;
}


}

if ($valid_code==0 OR $valid_tag==0) {


  echo '<meta http-equiv="refresh" content="4;url=./main.php">';

  echo '<br><center><h3>There was an barcode error.<br>Please advise your administrator of this error.</h3></center><br>';
  echo  '<center><div style="width:90%;height:100px;background:#d6020c;"></div></center>';
  if ($valid_tag==0 && $bctype==2) {
    echo '<br><center><h1>Your Visitor label has expired.<br>Please check in with the office.</h1></center>';
  }
} else {
//set status to unused

$status = '0';
//$loc=$_SESSION['sta_location'];
$sql=<<<SQL
 SELECT * FROM record_log
 WHERE code_in is NULL
 and barcode_assign = $barcode
SQL;


// set variable for time hack
unset ($date);
$datein = date('Y-m-d H:i:s');
// clear other variables **
unset ($time_a);
unset ($time_b);
unset ($diff);

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

// *** time functions for setting volunteer hours
$time = date('h:i:s');
$fulltime = date('Y-m-d H:i:s');
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


if (isset($admin_c)){
  echo '<meta http-equiv="refresh" content="2;url=./admin/admintest.php">';
} else {

echo '<meta http-equiv="refresh" content="1;url=./main.php">';
}
//get family grp

if ($user_id == '') {
  echo "<br><br><br><p style='text-align:center;font-size:2em;font-family:Arial;background-color:#E60909;color:white;'>Barcode ".$barcode." is NOT in use </p><br><br>";
} else {
  include (dirname(__FILE__).'/functions/fam.php');
  $insert_row = "UPDATE record_log SET code_in = '$datein' where code_in is NULL and barcode_assign = '$barcode' ";
if ($bctype==1){
  $insert_row1 = "UPDATE barcodes SET status=$status where barcode = '$barcode' ";
}
  // *** record entry for VOLUNTEER PROGRAM
  $create_record = "INSERT into vol_log (user_id, last_name, first_name, vol_date, vol_time_ttl, vol_class, vol_subject, entered_by, entry_date,family_grp) VALUES ($user_id,'$lname','$fname','$today_date','$diff_2','$vol_class','$reason','VIVA-visitor','$today_date',$family_grp)";
  echo  '<br><center><div style="width:90%;height:100px;background:#2fc436;"></div></center><br>';
  if(($conn->query($insert_row)=== TRUE) ){
    echo "<p style='text-align:center;font-size:2em;font-family:Arial;'>Record log is updated<br>Logged out at: <br>".$time."</p><br>";
    } else {
      echo "Error record abc log: " . $sql . "<br>" . $conn->error;
    }
if ($bctype==1){
    if(($conn->query($insert_row1)=== TRUE) ){
      echo "<p style='text-align:center;font-size:2em;font-family:Arial;'>Barcode ".$barcode." has been checked in. </p><br><br>";
      echo "<p style='text-align:center;font-size:2em;font-family:Arial;color:#22728C'>Thank you ".$fname.' '.$lname."</p><br><br>";
      echo "<p style='text-align:center;font-size:1em;font-family:Arial;'>Please return the badge to the ".$location."</p><br><br>";
    } else {
      echo "Error record AAA log: " . $sql . "<br>" . $conn->error;
    }
    }
    if ($user_id != '888888') {
      ////  volunteer
        if(($conn->query($create_record)=== TRUE) ){
            echo "<p style='text-align:center;font-size:2em;font-family:Arial;'>Your Volunteer time has been updated ****</p><br><br>";
              //** error checking and Family group update
//              echo $diff_1.'&nbsp&nbsp&nbsp'.$diff_2.'&nbsp&nbsp&nbsp'.($difference/60).'&nbsp&nbsp'.$today_date.'<br>'.$vol_class.'<br>';

            }

    }
}
}
?>
