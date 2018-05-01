<?php
include('../connect.php');
include('../functions/session.php');
include('../functions/header.php');

//** adding or editing a user
if ($login_lvl>=8){
$sql=<<<SQL
  select * from admin
SQL;
if(!$result = $conn->query($sql)){
    die('There was an error running the query [' . $conn->error . ']');
}
$sql1=<<<SQL
  select * from admin_levels
SQL;
if(!$result1 = $conn->query($sql1)){
    die('There was an error running the query [' . $conn->error . ']');
}

if (isset($_POST['password'])) {
$uid=  $_POST['user_id'];
$lpw=$_POST['password'];
$hashed_password = password_hash($lpw, PASSWORD_DEFAULT);
    $change_pwd = "UPDATE admin SET password = '$hashed_password' WHERE user_id = $uid";
    if(($conn->query($change_pwd)=== TRUE) ){
  echo '<br><br><center><h2>User\'s Password has been Updated</h2><br><br></center>';
  echo '<center><a href="admin_a.php" style="background-color:#D9D9C7;"><h4>Return to Admin Menu</a></center>';
    }

  } else {
  echo"<br><br><center><table style><tr><td><form method=post name=change action=''>Select a user to change the password:</td><td>
<select name=user_id value=''></option>";
  //  <option selected=".$tmonth." value=".$tmonth.">".$nmonth."</option>
while($row=$result->fetch_assoc()){
    echo"<option value='".$row['user_id']."'>".$row['name']."</option>";
  }
echo '</select></tr><tr><td></td><td></td></tr><tr><td style="text-align:right;">Enter a New Password:&nbsp</td><td><input name="password" type="text" /><span style="font-style:italic;">&nbspMust be at least 6 characters</span></td></td></table>';
echo "<input type=submit value=Submit></form></center>";
  }


} else {
  header("location: admintest.php");
}
?>
