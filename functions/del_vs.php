<?php

include ('../connect.php');
include ('../functions/header.php');
include('../functions/session.php');
$name=$_GET['n'];
$id=$_GET['i'];

$del_vs = "DELETE FROM volunteer_subjects where sub_index = $id";
if(($conn->query($del_vs)=== TRUE) ){
echo '<div class="centered"><center><h3>Volunteer Subjects</h3><br><span style="text-decoration:bold;"><b>'.$name.'</b></span> has been deleted from the system</center></div>';;
}
?>
