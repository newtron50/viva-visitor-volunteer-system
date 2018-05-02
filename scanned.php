<?php

include('connect.php');
//scanned and read into database
include("./includes/data.php");
include (dirname(__FILE__).'/includes/guest_header.php');
//set $type variable for testing to VOL
unset ($log_phone);
$last_name=$_SESSION['l_name'];
$first_name=$_SESSION['f_name'];
$user_id=$_SESSION['user_id'];
$reason=$_SESSION['reason'];

if ($bctype==1){
$barcode=$_GET['barcode'];
}
$phone=$_SESSION['phone'];
$cell=$_SESSION['cell'];
$v_type=$_SESSION['v_type'];
if ($fc!=2) {
$vol_sub=$_SESSION['vol_sub'];
$vol_class=$_SESSION['v_class'];
} else {
$vol_class='Visitor';
}
$bctype=$_SESSION['bctype'];
$flxcode=$_SESSION['flxcode'];
//set barcode status variable
$status = '1';
if ($bctype==1) {  // check if fixed barcodes
$dateout = date('Y-m-d H:i:s');
} else {
$dateout =date('Y-m-d H:i:s',$flxcode);
}


if ($bctype==1) {  // check if fixed barcodes
//check barcode validity
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
} else {   // bypass valid_code check because of bctype 2
  $valid_code=1;
}///// ----------- end of bctype

if ($valid_code==0) {
echo '<br> '.$reason.' '.$v_type.' '.$vol_sub;
  echo '<meta http-equiv="refresh" content="5;url=barcode.php?vol_sub='.$reason.'&vol_class='.$vol_class.'">';
  echo '<br><center><h3>There was an barcode error.<br>Please advise your administrator of this error.</h3></center>';
} else {
if ($bctype==1) {  // check if fixed barcodes
//  check if barcode status
$sql3=<<<SQL
  select * from barcodes
  where barcode = $barcode
SQL;

if(!$result = $conn->query($sql3)){
    die('There was an error running the query [' . $conn->error . ']');
}
while($row5=$result->fetch_assoc()){
$bcode=$row5['barcode'];

$status_chk = $row5['status'];
}
} else { /// bctype = 2  ..... labels
  $status_chk=2;
  $barcode = $flxcode;
}// end of bctype
if ($status_chk == 1 && $bctype==1) {   ///modified for bctype
  echo "barcode in use - try another badge";
  echo "<meta http-equiv='refresh' content='0;url=./barcode.php?check=\"used\"'>";
} else {
// if barcode not is use
if ($cell !='') {
  $log_phone=$cell;
}elseif ($phone!=''){
  $log_phone=$phone;
}else{
  $log_phone="no phone";
}
//else update the barcode, record log and other settings
echo "<meta http-equiv='refresh' content='3;url=./main.php'>";
//echo '<center>'.$flxcode.'<br>';
if ($bctype==1) {  // check if fixed barcodes
$insert_row1 = "UPDATE barcodes SET status=$status where barcode = $barcode";
}
$insert_row = "INSERT INTO record_log (user_id, type, first_name, last_name, reason, phone, barcode_assign, code_out, vol_class)
VALUES($user_id, '$v_type', '$first_name', '$last_name', '$reason', '$log_phone', $barcode,'$dateout','$vol_class')";

/*   update the volunteer count for the day  ** NOT SURE WE NEED THIS
$update_count ="UPDATE vol_count_list SET vol_count= vol_count + '1' WHERE user_id = '$user_id' ";
  if(($conn->query($update_count)=== TRUE) ){
//success
  } else {
echo "Volunteer count status not updated ";
}*/
if(($conn->query($insert_row)=== TRUE) ){
echo "<br><p style='font-family:Arial;font-size:16px;text-align:center;'>Scanned and Recorded Successfully</p><br><br>";
} else {
echo "Error Record entry: ";
}
if ($bctype==1) {  // check if fixed barcodes
if(($conn->query($insert_row1)=== TRUE) ){
echo "<br><p style='text-align:center'> Barcode ".$barcode." status has been updated<br><br>";
} else {
echo "Error barcode entry: ";
}
}
/*    *** PART OF COUNT UPDATE if(($conn->query($update_count)=== TRUE) ){
//success
} else {
echo "Volunteer count status not updated ";
}*/

if ($v_type == 'VOL') {
echo "<br><p style='font-family:Arial;font-size:26px;text-align:center;'>Thanks for volunteering at SJA - You're all set!</p>";
} else {
  echo "<br><p style='font-family:Arial;font-size:26px;text-align:center;'>Thanks for visiting at SJA - You're all set!</p>";
}
// testing echo '<br>'.$reason;
}
}
?>
