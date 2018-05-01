<?php
include('../connect.php');
include('../functions/session.php');
include('../includes/links.php');
if ($login_lvl>=6){
$activity=$_GET['a'];
echo '<div class="centered" style="width:80%;"><center>';
echo '<br><br><h4>In Depth Information for '.$activity.'</h4>';
$sql99=<<<SQL
SELECT distinct CONCAT(v.first_name,' ',v.last_name) as name, v.vol_subject,
SEC_TO_TIME(sum(TIME_TO_SEC(v.vol_time_ttl)))as time, count(user_id) as count
from vol_log as v
where vol_subject='$activity'
group by name order by time DESC
SQL;
if(!$subj19 = $conn->query($sql99)){
    die('Problem with data');
  }
  echo '<table><th>Name</th><th>Hours</th><th>Entry #</th>';
  $x=0;
  $y=0;
  $subc=array();
  $subt=array();
  $subn=array();
  while($deep=$subj19->fetch_array()){
      $dt2=$deep['time'];
      $d_time=substr($dt2,-0,-3);
      $subt[$x]=substr($dt2,-0,-6);
      $subn[$x]=$deep['name'];
      $subc[$x]=$deep['count'];
  if ($x & 1) {
    echo '<tr style="background-color:#DFE6E8;">';
  } else {
      echo '<tr>';
  }
    echo '<td style="font-size:18px;">'.$subn[$x].'</td><td style="font-size:18px;">'.$d_time.'</td><td style="font-size:18px;">'.$subc[$x].'</td></tr>';
    $x++;
    $y++;
  }
  echo '</table></center></div>';




} else {
//back to home page
header("location: /admin/admintest.php");
}
?>
