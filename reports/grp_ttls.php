<?php
include('../connect.php');
include('../functions/session.php');
if (empty($_GET['print'])) {
include ('../functions/header.php');
}
if (isset($_GET['print'])) {
  $short_name =$_SESSION['school_short'];
  $today_date=date('m/d/Y');
  if (empty($_GET['x'])) {
  echo '<link href="../css/multiColumnTemplate.css" rel="stylesheet" type="text/css">
  <link href="../css/table-style.css" rel="stylesheet" type="text/css">';
  echo '<br><a href="grp_ttls.php?sorting=DESC&field=last_name&print=y&x=y" class="excel" style="margin-left:40px;">Download to Excel</a>';
}
  echo '<div class="centered"><center><br><h3>'.$short_name.' Volunteer Summary Report by Groups</h3> '.$today_date.'<br></center></div>';
}
if (isset($_GET['x'])) {
  $data = NULL;
  $filename=NULL;
  include('../functions/xl_1.php');
}
$field='last_name';
$sort='ASC';
// try the php sorting
if(isset($_GET['sorting']))
{
  if($_GET['sorting']=='ASC')
  {
  $sort='DESC';
  }
  else
  {
    $sort='ASC';
  }
}
if($_GET['field']=='family_grp')
{
   $field = "family_grp";
}
elseif($_GET['field']=='last_name')
{
   $field = "last_name";
}
elseif($_GET['field']=='time')
{
   $field="time";
}
elseif($_GET['field']=='v_class_name')
{
   $field="v_class_name";
}
$sql=<<<SQL
SELECT  v.family_grp, v.last_name, SEC_TO_TIME(sum(TIME_TO_SEC(v.vol_time_ttl)))as time, vs.v_class_name
from vol_log as v
inner join volunteer_classes as vs
on v.vol_class = vs.id
where v.family_grp > 0
group by v.family_grp, vol_class
order by $field $sort
SQL;
if(!$result = $conn->query($sql)){
    die('There was an error running the query [' . $conn->error . ']');
}
echo '<div class="report_hdr"><center>Group Volunteer Hour Totals</center></div>';
if (empty($_GET['print'])) {
echo '<br><br><center><a href="grp_ttls.php?sorting=DESC&field=last_name&print=y" target="_new">Print report</a>';

}
echo '<div class="centered"><table id="table" class="tablesorter" style="font-size:14px;"><thead><tr>';
//end
echo  '<th><a href="grp_ttls.php?sorting='.$sort.'&field=family_grp">Group Number</a></th>';
echo  '<th><a href="grp_ttls.php?sorting='.$sort.'&field=last_name">Last Name</a></th>';
echo  '<th><a href="grp_ttls.php?sorting='.$sort.'&field=time">Total Vol. Time</a></th>';
echo  '<th><a href="grp_ttls.php?sorting='.$sort.'&field=v_class_name">Volunteer Class</a></th>';
echo '</tr></thead><tbody>';

while($row=$result->fetch_array()){ //number of rows
echo '<tr style="height:24px;">';
echo '<td style="vertical-align:middle;">'.$row['family_grp'].'</td><td style="vertical-align:middle;">'.$row['last_name'].'</td><td style="vertical-align:middle;">'.$row['time'].'</td>';
echo '<td style="vertical-align:middle;">'.$row['v_class_name'].'</td></tr>';
}
echo '</table></div>';
if (isset($_GET['x'])) {
  echo'</body></html>';
  echo $data;
}
?>
