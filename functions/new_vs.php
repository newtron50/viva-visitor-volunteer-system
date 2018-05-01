<?php
include ('../connect.php');
include('../functions/session.php');
include ('../functions/header.php');
$act=$_POST['activity'];
$vc=$_POST['vc'];


$new_vs = "INSERT INTO volunteer_subjects (v_sub_name, v_sub_class) VALUES ('$act',$vc)";
if(($conn->query($new_vs)=== TRUE) ){
echo '<div class="centered"><center><h3>Volunteer Subjects</h3><br><span style="text-decoration:bold;"><b>'.$act.'</b></span> has been created</center>';
echo '<br><br><center><a href="../admin/settings.php" style="g_bubble">Menu</a></center></div>';
}
?>
