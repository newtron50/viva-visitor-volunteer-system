<?php
include('../connect.php');
include('../functions/session.php');
include('../functions/header.php');
if ($login_lvl>=8){
if (isset($_GET['r'])){
$record=$_GET['r'];
$func=$_GET['e'];

$check=<<<SQL
  select * from vol_log
  where record = $record
SQL;
if(!$chk1 = $conn->query($check)){
    die('There was an error running the query 1 query[' . $conn->error . ']');
}


if ($func==0) {
  echo '<center><br><br><div style="width:60%;">Verify you want to <span style="color:red;">DELETE</span> this record?<div style="200px;text-align:left;font-size:24px;position:relative;margin-top:50px;margin-left:220px;">';
  while($chk=$chk1->fetch_array()){
  $short_time=substr($chk['vol_time_ttl'],0,-3);
  echo $chk['first_name'].' '.$chk['last_name'].'<br>Volunteer Date: '.$chk['vol_date'].'<br>';
  echo 'Volunteer time of: '.$short_time.'<br>';
  echo 'Entered by: '.$chk['entered_by'];
}
echo '</div><div style="margin-top:50px;"><b><a href="../functions/record.php?t=d&r='.$record.'" style="font-size:20px;color:#E60000;-webkit-appearance:button;">Click to Delete this Record of this Activity</b></a><br><span style="color:gray;font-size:14px;"><i>This cannot be undone</i></span>';
echo '</div>';
echo '<br><br><br><a href="../admin/settings.php" class="g_bubble">Cancel this Action</a>';
} elseif ($func==1) {
$name=$_GET['n'];

  echo'<br><br><div class="centered"><center>';
  echo 'Change the amount of hours for '.$name;


  echo '<form method=post name=f5 action="record.php" method="post"><input type=hidden name=record value='.$record.'><input type=hidden name=name value="'.$name.'">';
  echo 'Hours: (between 1 and 40):<br><br><br><input type="number" name="hrs" min="1" max="40">';
  echo '<br><br><br>Minutes: <br><table border="0" cellspacing="0" ><tr><td  align=left  ><select name=min value=""></option>';
  echo '<option value="00">00</option><option value="15">15</option><option value="30">30</option>
  <option value="45">45</option></table></select>';
  echo '<br><br><input type=submit value=Update class="g_bubble">';
  echo '</form>';
  echo '</div>';





} else {

  echo 'ERROR';
}



}
}
 else {
//back to home page
header("location: admintest.php");
}
?>
