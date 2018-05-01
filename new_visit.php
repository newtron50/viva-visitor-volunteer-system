<?php
include (dirname(__FILE__).'/includes/guest_header.php');

$lname = $_POST['lname'];
$fname = $_POST['fname'];
$reason = $_POST['reason'];
$phone = $_POST['cell'];
$v_type='VIS';
$user_id='888888';
if ($reason!='') {
// set numbers for phone
$justNums = preg_replace('/[^0-9]/', '', $phone);
//eliminate leading 1 if its there
if (strlen($justNums) == 11) {
$justNums = preg_replace("/^1/", '',$justNums);
}
$phone = $justNums;
if ((strlen($phone) != 10)or(empty($lname))or(empty($fname))){
  echo '<meta http-equiv="refresh" content="0;url=./visit.php?check=y">';

}
session_unset();

$_SESSION['l_name'] = $lname;
$_SESSION['f_name'] = $fname;
$_SESSION['reason'] = $reason;
$_SESSION['phone'] = $phone;
$_SESSION['user_id'] = $user_id;
$_SESSION['v_type']=$v_type;
$_SESSION['cell']=$phone;
$area=substr($phone,-10,3);
$pre=substr($phone,-7,3);
$last4=substr($phone,-4,4);




echo  '<h3 style=text-align:center>Please Verify your Information</h3>
      <div style=color:black;font-size:18px;text-align:center;>
      <p>Your Name: <b>'.$fname.' '.$lname.'</b></p>';
echo '<p>Your contact phone number: <br><b>('.$area.') '.$pre.'-'.$last4.'</b></p>';
echo '<p>Reason for today\'s visit: <br><b>'.$reason.'</b></p><br></div>';
echo '<div><center><br><a href="barcode.php" class="badgeY">YES</a><span style="space"></span>
  <a href="visit_class.php" class="badgeN">NO</a></div>';
echo '<p style="background-color:#B8DAE6;font-size:18px;color:#3D423C;text-align:center;font-weight:bold"><u>Please don\'t forget to SCAN & RETURN your badge before you leave the building.</u></p>
</div>';
} else {
// reason is blank

  $ln=$lname;
  $fn=$fname;
  $ph=$phone;
  echo '<center><br><br>';
  echo '<br>';
  echo '<br><h3>You must enter a reason why you are visiting</h3><br>';
  echo '<form action="new_visit.php" method="post"><input type=hidden name=k value="n"><input type=hidden name=lname value="'.$ln.'"><input type=hidden name=fname value="'.$fn.'"><input type=hidden name=cell value="'.$ph.'">';
  echo '<input name="reason" type="text" placeholder="reason for visit" autofocus/>';
  echo '<br><br>  <input type="submit" class="n_bubble" ><br><br><a href="./main.php" style="font-family:arial;font-size:18px;text-align:center;">Return to Main Page</a></center><br><br>';


}
?>
