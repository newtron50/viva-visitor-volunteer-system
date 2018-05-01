<?php
if(empty($_GET['print'])) {

include ('../functions/header.php');
$uid = $_GET['me'];

}
$lname = $_GET['l'];
$fname = $_GET['n'];
include ('../connect.php');

if(empty($_GET['print'])) {
echo '<br><center><span><a href="ind_rpt.php?print=y&u='.$uid.'&l='.$lname.'&n='.$fname.'" target="_blank">Create a printable report</a> </span></center>';
}else {
$uid=$_GET['u'];
echo '<div style="width:80%;margin-left:40px;"><br><link href="../css/multiColumnTemplate.css" rel="stylesheet" type="text/css">';
echo '<link href="../css/table-style.css" rel="stylesheet" type="text/css">';
}
//sql for total records
echo '<div class="rpt_hdr">Volunteer Report for: '.$fname.' '.$lname.'</div>';

$sql=<<<SQL
select vol_master_records.user_id, vol_master_records.vol_class, vol_master_records.time_calc, vol_master_records.fam_grp, vol_master_records.last_updated, people.last_name, people.first_name, volunteer_classes.v_class_name
from vol_master_records
inner join people ON vol_master_records.user_id=people.user_id
inner join volunteer_classes on volunteer_classes.id = vol_master_records.vol_class
where vol_master_records.user_id = '$uid'
SQL;
if(!$result = $conn->query($sql)){
    die('There was an error running the query [' . $conn->error . ']');
}
echo '<table class="tablesorter">';
echo '<th>Volunteer Class</th><th>Last Name</th><th>First Name</th><th>User ID</th><th>Total Volunteer Time</th><th>Group #</th><th>Date Last Updated</th><tr>';
while($row=$result->fetch_array()){
echo'<tr><td>'.$row['v_class_name'].'</td>'.'<td>'.$row['last_name'].'</td>'.'<td>'.$row['first_name'].'</td><td>'.$row['user_id'].'</td>'.'<td>'.$row['time_calc'].'</td><td>'.$row['fam_grp'].'</td><td>'.$row['last_updated'].'</td></tr>';
}
echo '</table><br><br>';

// show individual volunteer entries
$sql1=<<<SQL
select vol_log.last_name, vol_log.first_name, vol_log.vol_date, vol_log.vol_time_ttl, vol_log.vol_subject, vol_log.entered_by, vol_log.entry_date, volunteer_classes.v_class_name
from vol_log
inner join volunteer_classes on volunteer_classes.id = vol_log.vol_class
inner join people on people.last_name = vol_log.last_name and people.first_name = vol_log.first_name
where people.user_id = $uid ORDER BY vol_log.record DESC
SQL;
if(!$result1 = $conn->query($sql1)){
    die('There was an error running the query [' . $conn->error . ']');
}
$x=0;
echo '<table class="tablesorter">';
echo '<th>Volunteer Date</th><th>Time Volunteered</th><th>Activity</th><th>Entered By</th><th>Date Recorded</th><th>Volunteer Class</th><tr>';
while($row1=$result1->fetch_array()){
/*if ($x==0) {
  echo'<tr><td>'.$row1['first_name'].'</td><td>'.$row1['last_name'].'</td>';
  $x++;
} else {
  echo '<tr><td>&nbsp</td><td>&nbsp</td>';
}*/
echo'<td>'.$row1['vol_date'].'</td>'.'<td>'.$row1['vol_time_ttl'].'</td>'.'<td>'.$row1['vol_subject'].'</td><td>'.$row1['entered_by'].'</td>'.'<td>'.$row1['entry_date'].'</td><td>'.$row1['v_class_name'].'</tr>';
}
echo '</table><br><br>';
if(isset($_GET['print'])) {
  echo '</div>';
}
?>
