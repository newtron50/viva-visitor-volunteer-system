<?php
include('../connect.php');
include('../functions/session.php');
include('../functions/header.php');


$sql = "SELECT user_id, first_name, last_name, family_grp FROM people ORDER BY last_name ASC";
if(!$result = $conn->query($sql)){
    die('There was an error running the query [' . $conn->error . ']');

}
echo '<div style="width:80%px;"><center>';
echo '<table style="font-size:14px;font-family:sans-serif;"><thead><tr>';

//end
echo  '<th>User</th>';
echo  '<th>Last Name</th>';
echo  '<th>First Name</th>';
echo  '<th>Fam Group</th>';
echo  '<th>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>';
echo '</tr></thead><tbody>';

$prev_famgrp=0;
while($row=$result->fetch_array()){ //number of rows

echo '<tr><td>'.$row['user_id'].'</td>'.'<td>'.$row['last_name'].'</td>'.'<td>'.$row['first_name'].'</td><td>'.$row['family_grp'].'</td>';

if ($prev_famgrp != $row['family_grp']) {
  echo '<td><a href="../includes/del_fam.php?fam='.$row['family_grp'].'">  DELETE </td>';
}
$prev_famgrp=$row['family_grp'];
echo '</tr>';
}
echo '</tr></tbody></table></center></div>';







?>
