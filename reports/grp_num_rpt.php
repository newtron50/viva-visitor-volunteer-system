<?php
include ('../connect.php');
include('../functions/session.php');
include ('../functions/header.php');
if (empty($_POST['grp'])) {
if(isset($_GET['me'])) {
  //returning variable from below
$user_id=$_GET['me'];
}
echo '<br>';
$_SESSION['uid']=$user_id;
}
if (isset($_POST['grp'])){
  $user_id=$_SESSION['uid'];
  $grp=$_POST['grp'];
}
if (isset($_POST['grp'])){
  $update = "UPDATE people set family_grp = $grp where user_id = $user_id";
  if(($conn->query($update)=== TRUE) ){
    /// *** it updated
  echo "<br><p style='text-align:center;font-family:Arial;'>The family / group record has been updated.</p>";
  } else {
  echo "Error record log: " . $sql . "<br>" . $conn->error;
}
}
$sql=<<<SQL
  select *
  from people
  where user_id = $user_id
SQL;
if(!$result = $conn->query($sql)){
    die('There was an error running the query [' . $conn->error . ']');
}
echo '<div class="centered"><table  style="font-size:14px;">';

echo '<table id="table" class="tablesorter" style="font-size:16px;"><thead><tr>';
echo '<th>User ID</th><th>First Name</th><th>Last Name</th><th>Group ID</th>';
echo '</tr></thead><tbody>';
while ($row=$result->fetch_array()) {
  $grp=$row['family_grp'];
echo '<tr><td>'.$row['user_id'].'</td><td>'.$row['first_name'].'</td><td>'.$row['last_name'].'</td><td>'.$grp.'</td></tr>';
}

echo '</table><br></div>';
// insert code to show other group Members
include('../functions/src_mbrs.php');
//
$sql1=<<<SQL
 select max(family_grp)
 as family_grp from people
SQL;
if(!$result1 = $conn->query($sql1)){
    die('There was an error running the query [' . $conn->error . ']');
}

while ($row1 = $result1->fetch_row()){
  $last_grp=$row1[0];
}

if (empty($_POST['grp'])) {
$new_grp=$last_grp+1;
echo '<div style="margin-left:80px;"><p style="text-decoration:underline;">Assign or change the group number to this individual</p>';
echo 'If the person does not have a group number and you need to create one, use this new group number: <span style="text-decoration:strong;color:blue;font-size:20px;">'.$new_grp.'</span><br>';
echo 'Enter the group number you want to assign to the individual listed above<br><br>';
echo'<form action="grp_num_rpt.php?ngrp=y" method="post">
<table border="0" cellpadding="3" cellspacing="3" align="center">
    <tr><td>New Group Assignment Number: <input name="grp" type="text" /autofocus></td></tr>
  </table>
    <br><br>

</div><center>
<input type="submit" class="n_bubble" ></center><br><br></div>';
} else {

  echo '<a href="fam_update.php" style="margin-left:100px;margin-top:50px;">Search for another user\'s family/group ID number</a>';
}

echo '</div>';
?>
