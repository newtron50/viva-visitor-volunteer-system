<?php
include('../connect.php');


if (isset($_POST['manual'])) {
$manual=$_POST['manual'];
echo '<link href="../css/multiColumnTemplate.css" rel="stylesheet" type="text/css">';
include('../includes/guest_header.php');
session_start();
} else {
include('../functions/session.php');
include('../functions/header.php');
$manual=2;
}
// Get max user number
$sql1=<<<SQL
  select max(user_id)
as user_id from people
SQL;
if(!$result1 = $conn->query($sql1)){
    die('There was an error running the query [' . $conn->error . ']');
}
  while ($row1 = $result1->fetch_row()){
  $usrid=$row1[0];
}
$usrid=$usrid+1;
///

$x=$_SESSION['new_peep'][1];
$x1=$_SESSION['new_peep'][0];
$x2=$_SESSION['new_peep'][3];
$x2 = !empty($x2) ? "'$x2'" : "NULL";
$x3=$_SESSION['new_peep'][5];
$x3 = !empty($x3) ? "'$x3'" : "NULL";
$x4=$_SESSION['new_peep'][4];
$x4 = !empty($x4) ? "'$x4'" : "NULL";
$x5=$_SESSION['new_peep'][2];
$x5 = !empty($x5) ? "'$x5'" : "NULL";
if (isset($_POST['grp4'])) {
    $x6=$_POST['grp4'];
} elseif (isset($_POST['grp5'])) {
  $x6=$_POST['grp5'];
} else {
$x6=$_SESSION['new_peep'][7];
}
$create_noob = "INSERT INTO people (user_id,first_name,last_name,phone,other_phone,cell,email,family_grp) VALUES ($usrid,'$x','$x1',$x2,$x3,$x4,$x5,$x6)";

if(($conn->query($create_noob)=== TRUE)){
echo '<div class="centered"><center><br><br>';
echo 'You have created a new volunteer: '.$_SESSION['new_peep'][1].' '.$_SESSION['new_peep'][0].'<br><br>';
if ($manual==1) {
echo '<a href="../repeat_search.php" class="g_bubble">Log in to start Volunteering</a></center></div>';
} else {  ///  admin volunteer entry
echo '<a href="../admin/settings.php" class="g_bubble">Return to the Settings Menu</a></center></div>';
}
} else {
  echo '<div class="centered"><center><br><br>Failure creating a record<br><br>';
  echo 'There was an error running the query [' . $conn->error . ']';
  echo '<a href="../admin/settings.php">Return to the Settings Menu</a></center></div>';
}



unset($_SESSION['new_peep']);
?>
