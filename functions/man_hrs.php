<?php
include('../connect.php');
include('../functions/session.php');
include('../functions/header.php');
if ($login_lvl>=5){
$eh=$_SESSION['edit_hrs'];
$dt = new DateTime();
$today=$dt->format('m/d/Y');

$uid =$eh[0];
$grp=$eh[1];
$lname =$eh[3];
$fname = $eh[2];
$v_date=$eh[4];
$v_time=$eh[5];
$v_class=$eh[8];
$v_sub=$eh[6];
$grp=$eh[9];
$ent=$_SESSION['login_name'];
$man_hrs= "INSERT INTO vol_log (user_id,last_name,first_name,vol_date,vol_time_ttl,vol_class,vol_subject,entered_by,entry_date,family_grp) VALUES ($uid,'$lname','$fname','$v_date','$v_time','$v_class','$v_sub','$ent','$today',$grp)";
$name=$fname.' '.$lname;
  if(($conn->query($man_hrs)=== TRUE) ){
      echo "<br><p style='text-align:center;font-family:Arial;'>Record Entered for ".$fname." ".$lname."<br></p><br><br>";
      echo '<center><a href="../admin/edit_hrs.php" class="g_bubble">Enter another record</a>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp<a href="../admin/edit_hrs.php?u='.$uid.'&grp='.$grp.'&n='.$name.'" class="g_bubble">Another entry<br>for '.$name.'</a><span style="position:relative;margin-left:50px;"><a href="../admin/settings.php" class="g_bubble">Functions Menu</span></a></center>';
unset($_SESSION['edit_hrs']);
      }

} else {
//back to home page
header("location: admintest.php");
}

?>
