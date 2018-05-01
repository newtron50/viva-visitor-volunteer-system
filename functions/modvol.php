<?php
include('../connect.php');
include('../functions/session.php');
include('../functions/header.php');

$user_id=$_GET['u'];
$cat=$_GET['c'];
$change=$_GET['h'];

if (isset($_GET['u'])) {
if ($change=='family_grp') {
  $mod_user = "UPDATE people set ".$cat." = $change where user_id = $user_id";
} else {
$mod_user = "UPDATE people set ".$cat." = '$change' where user_id = $user_id";
}
if(($conn->query($mod_user)=== TRUE) ){
echo '<br><br><center><h2>Volunteer\'s information has been updated</h2><br><br></center>';
echo '<center><a href="../admin/mod_vol.php"  class="g_bubble" style="background-color:#D9D9C7;"><h4>Return to Menu</a></center>';
unset($change);
unset($cat);
unset($user_id);

}else{
  echo '<br><br><center><h2>Error in updating information</h2><br><br></center>';
}
echo '<br>'.$user_id.' '.$cat.' '.$change.' ';

}
?>
