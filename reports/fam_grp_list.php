<?php
include('../functions/session.php');
echo '<br><span style="margin-left:400px;"><a href="/includes/print.php" target="_blank">Create a printable report</a><br>';
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
}
elseif($_GET['field']=='family_grp')
{
   $field="family_grp";
}
$sql = "SELECT grp_nbr, vol_class, last_name, ttl_time, last_updated FROM family ORDER BY $field $sort";
if(!$result = $conn->query($sql)){
    die('There was an error running the query [' . $conn->error . ']');
}

echo '<table id="table" class="tablesorter"><thead><tr>';

//end
echo  '<th><a href="reports_vol?sorting='.$sort.'&field=grp_nbr">Grp #</a></th>';
echo  '<th><a href="reports_vol?sorting='.$sort.'&field=last_name">Last Name</a></th>';
echo  '<th><a href="reports_vol?sorting='.$sort.'&field=vol_class">Vol Class</a></th>';
echo  '<th><a href="reports_vol?sorting='.$sort.'&field=ttl_time">Vol Time</a></th>';
echo  '<th><a href="reports_vol.php?sorting='.$sort.'&field=last_updated">Last Updated</a></th>';
echo '</tr></thead><tbody>';

while($row=$result->fetch_array()){ //number of rows
echo '<tr>';
echo '<td>'.$row['grp_nbr'].'</td>'.'<td>'.$row['last_name'].'</td>'.'<td>'.$row['vol_class'].'</td>';
echo '<td>'.$row['ttl_time'].'</td>'.'<td>'.$row['last_updated'].'</td>';
echo '</tr>';
$area = null;
$pre = null;
$last4 = null;
}
?>
