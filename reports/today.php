<?php
include('../connect.php');
include('../functions/session.php');
if (empty($_GET['p'])) {
include ('../functions/header.php');
} else {
include('../includes/links.php');
}
session_start();
$today = date('Y-m-d');


$sql=<<<SQL
 select * from
 record_log where
 code_out >= $today
SQL;

if(!$result = $conn->query($sql)){
    die('There was an error running the query [' . $conn->error . ']');
}
while($row=$result->fetch_array()){
$data[] =$row;
//  echo $row['record_num'].' '.$row['user_id'].' '.$row['last_name'].' '.$row['first_name'].' '.$row['email'].' '.$row['phone'].' '.$row['cell'].' '.$row['vol_type'].' '.$row['family_grp'];
//echo "<br>";
}
if (empty($_GET['p'])) {
echo '<center><br><br><a href="./today.php" class="admin_chs">Update Now</a>&nbsp;&nbsp;&nbsp;&nbsp;<a href="./today.php?p=y" class="admin_chs" target="_new">Print Report</a></center><br><center><div style="width:90%;"><center>';
} else {
  echo '<div style="width:800;margin-left:80px;"><br><br><br><center><b>'.$short_name.' Visitor </b>report for '.$today;
}


$field='code_out';
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
if($_GET['field']=='user_id')
{
   $field = "user_id";
}
elseif($_GET['field']=='last_name')
{
   $field = "last_name";
}
elseif($_GET['field']=='first_name')
{
   $field="first_name";
}elseif($_GET['field']=='code_out')
{
   $field="code_out";
}
$sql = "SELECT record_num, user_id, type, first_name, last_name, reason, phone, barcode_assign, code_out, code_in FROM record_log ORDER BY $field $sort";
if(!$result = $conn->query($sql)){
    die('There was an error running the query [' . $conn->error . ']');
}
echo '<table id="table" class="tablesorter"><thead><tr>';

//end
echo  '<th><a href="./today.php?sorting='.$sort.'&field=user_id">ID</a></th>';
echo '<th>type</th>';
echo  '<th><a href="./today.php?sorting='.$sort.'&field=last_name">Last Name</a></th>';
echo  '<th><a href="./today.php?sorting='.$sort.'&field=first_name">First Name</a></th>';
echo '<th>Purpose</th>';
echo '<th>Phone</th>';
echo '<th>Barcode</th>';
echo '<th><a href="./today.php?sorting='.$sort.'&field=code_out">Scanned Out</a></th>';
echo '<th>Scanned In</th>';
echo '</tr></thead><tbody>';


while($row=$result->fetch_array()){ //number of rows
if ($row['code_out']>= $today){
echo '<tr>';
$type=$row['type'];
echo '<td style="font-size:14px;">'.$row['user_id'].'</td><td style="font-size:14px;">'.$type.'</td><td style="font-size:14px;">'.$row['last_name'].'</td><td style="font-size:14px;">'.$row['first_name'].'</td><td style="font-size:14px;">'.$row['reason'].'</td>';

//make phone readable
if ($row['phone'] != 0) {
$area=substr($row['phone'],-10,3);
$pre=substr($row['phone'],-7,3);
$last4=substr($row['phone'],-4,4);
echo '<td style="font-size:14px;">('.$area.') '.$pre.'-'.$last4.'</td>';
} else {
  echo '<td> none</td>';
}
$time_in=$row['code_in'];
$ttme=0;
if ($time_in=='') {
  $ttme=1;
  $time_in='On Campus';
}
$t_out=$row['code_out'];
$barc=$row['barcode_assign'];
echo '<td style="font-size:14px;">'.$barc.'</td><td style="font-size:14px;">'.$t_out.'</td>';
if ($ttme==1) {
  echo '<td><a href="../includes/edit_time.php?r='.$row['record_num'].'&f='.$row['first_name'].'&l='.$row['last_name'].'&t='.$t_out.'&bc='.$barc.'" style="color:#DB3232">'.$time_in.'</a></td>';
} else {
  if ($type=='VIS') {
echo '<td><a href="../includes/edit_time.php?r='.$row['record_num'].'&f='.$row['first_name'].'&l='.$row['last_name'].'&t='.$t_out.'&bc='.$barc.'">'.$time_in.'</a></td>';
} else {
echo '<td style="font-size:14px;">'.$time_in.'</td>';
}
}

echo '</tr>';
$area = null;
$pre = null;
$last4 = null;
}
}
  ?>
