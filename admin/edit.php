<?php
include('../connect.php');
include('../functions/session.php');
include('../functions/header.php');

//** changing user permissions
if ($login_lvl>=8) {

$sql=<<<SQL
    select * from admin
SQL;
  if(!$result = $conn->query($sql)) {
      die('There was an error running the query [' . $conn->error . ']');
  }
$sql1=<<<SQL
    select * from admin_levels
SQL;
  if(!$result1 = $conn->query($sql1)) {
      die('There was an error running the query [' . $conn->error . ']');
      }
if (isset($_POST['user'])) {
  $usr= $_POST['user'];
  $lvl=$_POST['lvl'];
  $change_lvl = "UPDATE admin SET admin_level = $lvl where user_id=$usr";
  if(($conn->query($change_lvl)=== TRUE) ){
echo '<br><br><center><h2>User\'s Permission Level has been changed</h2><br><br></center>';
echo '<center><a href="admin_a.php" style="background-color:#D9D9C7;"><h4>Return to Admin Menu</a></center>';
  }
} else {
  echo '<br><br><center><div style="width:80%;background-color:#dce0e8;"><br><br><center><table style><tr><td><form method=post name=change action=\'\'>Select a user to change the Permissions Level:</td><td>
<select name=user value=\'\'></option>';
while ($row=$result->fetch_assoc()){
    echo '<option value='.$row['user_id'].'>'.$row['name'].'</option>';
  }
echo '</select></tr><tr><td></td><td></td></tr><tr><td style="text-align:right;">Select a Permission Level:&nbsp</td><td>';
echo '<select name=lvl value=\'\'></option>';
while ($row1=$result1->fetch_assoc()){
    echo '<option value='.$row1['level'].'>'.$row1['admin_lvl_name'].'</option>';
  }
  echo '</td></td></table>';
echo '<br><br><input type=submit value=Submit><br><br></form></center></div></center>';
  }


} else {
  //back to home page
  header("location: admintest.php");
}
?>
