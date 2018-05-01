<?php
include('../connect.php');
include('../functions/session.php');
include('../functions/header.php');
if (isset($_GET['now']) or isset($_POST['now'])) {
///  write the time to the logs
//echo '<br><br><center>This function is not yet implemented<br>';
//testing code_
$sm_hand=$_POST['min'];
$big_hand=$_POST['hour'];
$barcode=$_POST['barc'];
$rec_num=$_POST['rnum'];
$sign_out=$big_hand.':'.$sm_hand.':00';
echo '<br>'.$sm_hand.' '.$big_hand.' '.$barc.' '.$sign_out.' '.$rec_num;

//set status to unused
$status = '0';
//$loc=$_SESSION['sta_location'];
$sql=<<<SQL
 SELECT * FROM record_log
 WHERE record_num =$rec_num
SQL;


// set variable for time hack
unset ($date);
$datein = date('Y-m-d');
// clear other variables **
echo $datein;
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
$fulltime = $datein.' '.$sign_out;
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

include (dirname(__FILE__).'/includes/guest_header.php');

$logged_msg='MSO:'.$login_name;

  $insert_row = "UPDATE record_log SET code_in = '$fulltime' where record_num = '$rec_num' ";
  $insert_row1 = "UPDATE barcodes SET status=$status where barcode = '$barcode' ";



  if(($conn->query($insert_row)=== TRUE) ){
    echo "<br><p style='text-align:center;font-size:2em;font-family:Arial;'>Record log is updated<br>".$fname.' '.$lname." is now logged out at : ".$fulltime."</p><br><br>";
    } else {
      echo "Error record log: " . $sql . "<br>" . $conn->error;
    }
    if(($conn->query($insert_row1)=== TRUE) ){
  //badge updated
    } else {
      echo "Error record log: " . $sql . "<br>" . $conn->error;
    }
if ($vol_class!=0) {
      ////  volunteer
      include ('../functions/fam.php');
      // *** record entry for VOLUNTEER PROGRAM
      $create_record = "INSERT into vol_log (user_id, last_name, first_name, vol_date, vol_time_ttl, vol_class, vol_subject, entered_by, entry_date,family_grp) VALUES ($user_id,'$lname','$fname','$today_date','$diff_2','$vol_class','$reason','$logged_msg','$today_date',$family_grp)";

      if(($conn->query($create_record)=== TRUE) ){
            echo "<br><p style='text-align:center;font-size:2em;font-family:Arial;'>Your Volunteer time has been updated ****</p><br><br>";

            }

    }

} else {
$barc=$_GET['bc'];
$rnum=$_GET['r'];
$fname=$_GET['f'];
$lname=$_GET['l'];
$t_in=$_GET['t'];
include('../functions/time.php');
echo '<br><br><br>';

$tnow = date("g:i a");
//echo '<br><a href="../includes/edit_time.php?now='.$tnow.'&r='.$rnum.'&bc='.$barc.'">Click Here </a>to log them out at the current time:  '.$tnow;
echo '<br><br>'.$barc.'<center>';
}





?>
