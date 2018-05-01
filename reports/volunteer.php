<?php
include('../connect.php');
include('../functions/session.php');
include ('../includes/links.php');

if ($login_lvl>=6){

$usr_id = $_GET['u'];
$full_name=$_GET['n'];


echo '<br><div style="width:60%;"><br><center>Volunteer information for:&nbsp<span style="font-size:18px;font-family:arial;">'.$full_name.'</span>';
echo '<br><a href="../admin/reports.php">Return to Menu</a>';

$get_totals=<<<SQL
SELECT  SEC_TO_TIME(sum(TIME_TO_SEC(v.vol_time_ttl)))as time, vs.v_class_name, v.vol_class
from vol_log as v
inner join volunteer_classes as vs
on v.vol_class = vs.id
where user_id = $usr_id group by v.vol_class
SQL;
if(!$stuff = $conn->query($get_totals)){
    die();
}
echo '<div style="width:60%;"><table class="rpt_table_sm" style="width:300px;margin-left:50px;">';
echo '<thead><th colspan="2">Individual Volunteer Class Totals</th></thead>';
$no_data=0;
while($stuff1=$stuff->fetch_array()){
  //modify time to show correctly
$clock=$stuff1['time'];
$clock=substr($clock,-0,-3);
//$hrs=substr($clock,0,-4);
  echo '<tr><td>'.$stuff1['v_class_name'].'</td><td>'.$clock.'</td>';
  $no_data++;
}
if ($no_data ==0) {
  echo '<tr><td colspan="2">No data totals entered for '.$full_name.'</td></tr>';
}
echo '</table></div>';

$sql8=<<<SQL
select r.vol_date, r.vol_subject, TIME_FORMAT(r.vol_time_ttl, "%H:%i") as time, v.v_class_name,  r.entered_by from
  vol_log as r
  inner join volunteer_classes as v on
  r.vol_class = v.id
  where r.user_id =$usr_id
SQL;
if(!$result8 = $conn->query($sql8)){
    die('There was an error running the query 1 query[' . $conn->error . ']');
}
echo '<br><div style="margin-left:10px;">Individual Volunteer Times:';

while($row8=$result8->fetch_array()){
    if ($x==0) {
echo '<table class="rpt_table_2" style="margin-left:100px">';
echo '<thead><th>Date</th><th>Time</th><th>Reason</th><th>Volunteer Class</th><th>Entered by</thead>';
      }
$x++;
$ttl_time=$row8['time'];
$btime = $row8['vol_date'];
$time= strtotime($btime);
$monthcode = date( 'M-d-Y', $time );
echo '<tr><td>'.$monthcode.'</td><td>'.$ttl_time.'</td><td>'.$row8['vol_subject'].'</td><td>'.$row8['v_class_name'].'</td><td>'.$row8['entered_by'].'</td></tr>';
}
echo '</table></div>';





} else {
//back to home page
header("location: admintest.php");
}
?>
