<?php
//delete user_id

if (isset($_GET['d'])) {
  include('../connect.php');
  include('../functions/session.php');
  include('../functions/header.php');
  $usrid=$_GET['u'];
  $name=$_GET['d'];
$delete = "DELETE FROM people where user_id = $usrid";

  if(($conn->query($delete)=== TRUE) ){
  echo '<div class="centered"><br><br><h3>'.$name.' was deleted from the Database</h3>';
  echo '<span class="space"><a href="../admin/settings.php" class="g_bubble" ><b>Return to Menu</a></span></span>';
} else {
  echo '<div class="centered"><br><br><h3>Error deleting Volunteer from Database</h3>';
}

} else {
$usrid=$_GET['u'];
$name = $_GET['n'];

echo '<div class="centered"><br><br><h3>Delete the following Volunteer\'s from the database?</h3>';
echo '<br><span style="color:#C7000A;font-size:20px;"><b>Name of user to delete: '.$name.' </b>';
echo '<div style="position:abolute;margin-left:500px;margin-top:-50px;"><table style="border:1px solid black;background-color:#e5e7ea;border-radius:13px;color:#3e4042;"><td><span style="color:#C7000A;"><u>NOTICE: What This Does</u></span></td><tr></tr><tr><td><i>* Leaves individual entries in logs</i></td></tr><tr><td><i>* Removes all personal volunteer hours</i></td></tr></table></div>';
echo '<span style="position:relative;margin-top:-270px;"><a href="../functions/d_vol.php?u='.$usrid.'&d='.$name.'" class="g_bubble"><b>DELETE THIS USER?</b></a>
<span class="space"><a href="../admin/settings.php" class="g_bubble" ><b>CANCEL</a></span></span>';

}








?>
