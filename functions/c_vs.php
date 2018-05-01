<?php
include ('../functions/header.php');
include ('../connect.php');
include('../functions/session.php');

$id2=$_POST['id'];
$vc_chg=$_POST['chg_vc'];
$activity=$_POST['activity'];
$v_name = "SELECT v_class_name from volunteer_classes where id = $vc_chg";
if(!$result5 = $conn->query($v_name)){
    die('There was an error running the query [' . $conn->error . ']');
}
while ($row5=$result5->fetch_array()) {
  $new_name=$row5['v_class_name'];
}
echo '<div class="centered"><center>';
$chg_vclass = "UPDATE volunteer_subjects SET v_sub_class = '$vc_chg' where sub_index = $id2";
if(($conn->query($chg_vclass)=== TRUE) ){
echo '<div class="centered"><center><h3>Volunteer Activity </h3><br><span style="text-decoration:bold;"><b>'.$activity.'</b></span> has been changed to Volunteer Class ::  <span style="color:blue;">'.$new_name.'</span><br><br><br></div>';
}
echo '<br><br><center><a href="../admin/settings.php" class="g_bubble">Return to Menu</a></center>';




?>
