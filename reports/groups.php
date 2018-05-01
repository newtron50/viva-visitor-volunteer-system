<?php
include('../connect.php');
include('../functions/session.php');
include ('../functions/header.php');
//query database for totals
echo '<div class="report_hdr"><center>List of Family/Group Members</center></div>';
echo '<br><span style="margin-left:400px;"><a href="./functions/print.php" target="_blank">Create a printable report</a><br></span>';
$field='family_grp';
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
if($_GET['field']=='grp_nbr')
{
   $field = "family_grp";
}
elseif($_GET['field']=='last_name')
{
   $field = "last_name";
}
elseif($_GET['field']=='first_name')
{
   $field="first_name";
}
$sql=<<<SQL
select * from people ORDER BY $field $sort
SQL;
if(!$result = $conn->query($sql)){
    die('There was an error running the query [' . $conn->error . ']');
}
$grp=-1;
echo '<div class="centered"><center>';
echo '<table id="table" class="tablesorter" style="font-size:16px;width:80%;margin-left:40px;"><thead><tr>';
//end
echo  '<th><a href="groups.php?sorting='.$sort.'&field=grp_nbr">Grp #</a></th>';
echo  '<th><a href="groups.php?sorting='.$sort.'&field=last_name">Last Name</a></th>';
echo  '<th><a href="groups.php?sorting='.$sort.'&field=first_name">First Name</a></th>';
echo  '<th>User ID</th>';
echo '</tr></thead><tbody>';

while($row=$result->fetch_array()){ //number of rows
echo '<tr style="height:24px;vertical-align:middle;">';
if ($grp == $row['family_grp']) {
  echo '<td>&nbsp</td><td style="vertical-align:middle;">'.$row['last_name'].'</td>';;
echo '<td style="vertical-align:middle;">'.$row['first_name'].'</td><td style="vertical-align:middle;">'.$row['user_id'].'</td></tr>';
} else {
echo '<tr class="blank_row" style="height:16px;vertical-align:middle;"><td colspan="4" ></td></tr>';
echo '<td style="height:24px;vertical-align:middle;">'.$row['family_grp'].'</td><td style="vertical-align:middle;">'.$row['last_name'].'</td>';
echo '<td style="height:24px;vertical-align:middle;">'.$row['first_name'].'</td><td style="height:24px;vertical-align:middle;">'.$row['user_id'].'</td></tr>';
}
$grp = $row['family_grp'];
}
echo '</center></div>';


?>
