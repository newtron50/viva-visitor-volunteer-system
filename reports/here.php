<?php
include('../connect.php');
include('../functions/session.php');
if (empty($_GET['p'])) {
include ('../functions/header.php');
} else {
include('../includes/links.php');
}
$today = date('Y-m-d');

$school=$_SESSION['school'] ;
$url=$_SESSION['url'];
$short_name =$_SESSION['school_short'] ;
//echo '<br><br>test<br>';
//echo $data[5][3];
if (empty($_GET['p'])) {
echo '<center><br><br><a href="./here.php" class="admin_chs">Update Now</a>&nbsp;&nbsp;&nbsp;&nbsp;<a href="./here.php?p=y" class="admin_chs" target="_new">Print Report</a></center><br><div class="rep">';
} else {
  echo '<div style="width:800;margin-left:50px;"><br><br><br><center><b>'.$short_name.' Who\'s Here </b>report for '.$today;
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
$sql = "select * from
record_log where
code_in is NULL";
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
echo '<th>OPTION</th>';
echo '</tr></thead><tbody>';


while($row=$result->fetch_array()){ //number of rows
echo '<tr>';
echo '<td style="font-size:14px;">'.$row['user_id'].'</td>'.'<td style="font-size:14px;">'.$row['type'].'</td>'.'<td style="font-size:14px;">'.$row['last_name'].'</td>'.'<td style="font-size:14px;">'.$row['first_name'].'</td>'.'<td style="font-size:14px;">'.$row['reason'].'</td>';

//make phone readable
if ($row['phone'] != 0) {
$area=substr($row['phone'],-10,3);
$pre=substr($row['phone'],-7,3);
$last4=substr($row['phone'],-4,4);
echo '<td>('.$area.') '.$pre.'-'.$last4.'</td>';
} else {
  echo '<td> none</td>';
}

echo '<td style="font-size:14px;">'.$row['barcode_assign'].'</td>'.'<td style="font-size:14px;">'.$row['code_out'].'</td>'.'<td style="font-size:14px;"><a href="../functions/man_edit.php?bc='.$row['barcode_assign'].'&uid='.$row['user_id'].'&tc='.$row['code_out'].'">Check in</a></td>';
echo '</tr><tr>
    <td>

    </td>
</tr>';
$area = null;
$pre = null;
$last4 = null;
}

echo '</tr></tbody></table>';

if (isset($_GET['p'])) {
  echo '</center></div>';
}
echo '</div>';
  ?>
