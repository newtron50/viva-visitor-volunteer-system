<?php
include('../connect.php');
include('../functions/session.php');
include('../functions/header.php');

$fam_grp=$_GET['fam'];

if ($_GET['d']=='y') {
echo '<br><br><center><div style="width:80%"><br><br>';
$wipeout_family = "DELETE FROM people where family_grp= $fam_grp";
mysqli_query( $conn, $wipeout_family );
echo 'FAMILY GROUP '.$fam_grp.' has been deleted';
echo '</div></center>';
} else {

$sql5 = "SELECT first_name, last_name, family_grp FROM people where family_grp=$fam_grp";
if(!$result5 = $conn->query($sql5)){
    die('There was an error running the query [' . $conn->error . ']');

}
echo '<br><br><center><div style="width:80%">';
echo '<table><th>First Name</th><th>Last Name</th><th>Family Group</th>';
while($row5=$result5->fetch_array()){
echo '<tr><td>'.$row5['first_name'].'</td><td>'.$row5['last_name'].'</td><td>'.$row5['family_grp'].'</td></tr>';
}
echo '</table><br><br>';
echo '<p style="font-size:20px;">Delete this Family Group and all its users?</p>';
echo '<p style="color:red;">This cannot be undone</p>';

echo '<a href="del_fam.php?fam='.$fam_grp.'&d=y" class="menu_a">DELETE THIS GROUP</a>';

echo '</div></center>';

}
?>
