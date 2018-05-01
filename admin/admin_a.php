<?php
include('../connect.php');
include('../functions/session.php');
include('../functions/header.php');

//** adding or editing a user
if ($login_lvl>=8){

$sql=<<<SQL
  select a.user_id, a.name, a.username, al.admin_lvl_name
  FROM admin as a
  inner join admin_levels as al
  on a.admin_level = al.level
SQL;
if(!$result = $conn->query($sql)){
    die('There was an error running the query [' . $conn->error . ']');
}
$sql1=<<<SQL
  SELECT * FROM admin_levels ORDER BY admin_levels.level DESC
SQL;
if(!$result1 = $conn->query($sql1)){
    die('There was an error running the query [' . $conn->error . ']');
}
//edit admin

//write to admin

if (isset($_POST['level'])) {
$ln=$_SESSION['ca'];
$lun=$_SESSION['cb'];
$lpw=$_SESSION['cc'];
$lvl=$_POST['level'];
$hashed_password = password_hash($lpw, PASSWORD_DEFAULT);
$create_admin = "INSERT INTO admin (name, username, password, admin_level) VALUES ('$ln','$lun','$hashed_password', $lvl)";
  if(($conn->query($create_admin)=== TRUE) ){
echo '<br><br><center><h2>User created</h2><br><br></center>';
  }
}


if (isset($_POST['name']) && isset($_POST['username']) && isset($_POST['password']) && empty($_POST['level'])) {

  if (strlen($_POST['password'])< 6) {
      echo 'Your password must be at least six characters long';
  } else {
  echo '<br><br><center><div style="disp">Verify the information and select a Administrator level';
  echo '<table><tr><td>Name: </td><td>'.$_POST['name'].'</td></tr><tr><td>Username: </td><td>'.$_POST['username'].'</td></tr><tr><td>Password: </td><td>'.$_POST['password'].'</td></tr></table>';
  $_SESSION['ca']=$_POST['name'];
  $_SESSION['cb']=$_POST['username'];
  $_SESSION['cc']=$_POST['password'];
  echo '<p>Select an Administrator level to assign:    </p>';
  echo '<form method=post name=level action=""><input type=hidden name=todo value=submit><table border="0" cellspacing="0" ><tr><td  align=left  >
<select name=level value=" ">Select Level: </option>';
while($row1=$result1->fetch_assoc()){
  echo '<option value='.$row1[level].'>'.$row1[admin_lvl_name].'</option>';
}
echo '</select><input type=submit value=Submit></table></form>';
  echo '</div></center>';
  }
}

/////
if (isset($_GET['a'])) {
  echo '<br><br><div style="width:100%;display:inline-block;text-align:center;">';
echo'<p style="background-color:#e3e5e8;">Please enter the following:</p><p id="required"> all fields are required</p>
    <form action="admin_a.php?n=1" method="post">
    <table border="0" cellpadding="3" cellspacing="3" align="center">
  <tr><td>Name: </td><td><input name="name" type="text" autofocus/><span style="font-style:italic;">&nbspFirst & Last Name</span></td></tr>
  <tr><td>username:</td><td><input name="username" type="text" /></td></tr>
  <tr><td>Password:</td><td><input name="password" type="text" /><span style="font-style:italic;">&nbspMust be at least 6 characters</span></td></tr>
  </table><br>
<input type="submit" class="bubble" ></center><br><br>';
  echo '</div>';
}
if (empty($_GET['m'])){
echo '<br><center><table class="choose"><tr><td><a href="admin_a.php?a=y&m=1">Add an Administrator</a></td><td><a href="edit.php">Edit an Admin Level</a></td></tr><tr><td><a href="del_usr.php">Delete an Admin</a></td><td><a href="change.php">Change a Password</a></td></tr></table><br>';
}
echo '<center><table class="rpt_table_sm"><thead><th>User ID</th><th>Name</th><th>Username</th><th>Admin Level</th></thead>';

while($row=$result->fetch_assoc()){
  echo '<tr><td>'.$row['user_id'].'</td><td>'.$row['name'].'</td><td>'.$row['username'].'</td><td>'.$row['admin_lvl_name'].'</td></tr>';
}
echo '</center>';
} else {
//back to home page
header("location: admintest.php");
}


?>
