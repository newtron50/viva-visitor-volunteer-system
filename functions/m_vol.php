<?php
//m_vol
if ($flag==0) {
$usrid=$_GET['u'];
} else {
  $usrid=$usr;
}
$sql8=<<<SQL
  SELECT * from people where
  user_id = $usrid;
SQL;
echo '<div class="centered" style="margin-top:40px;"><h3>Modify a Volunteer\'s Information</h3>';

if(!$result8 = $conn->query($sql8)){
  die('There was an error running the query [' . $conn->error . ']');
}

while($row8=$result8->fetch_array()){ //number of rows
$other=  $row8['other_phone'];
$user=$row8['user_id'];
  echo '<div class="centered"><table class="rpt_table_sm" style="width:100%;"><thead style="font-size:12px;"><tr>';
  echo  '<th>User ID</th>';
  echo  '<th>First Name</th>
        <th>Last Name</th>
  <th>Main Phone</th>
  <th>Cell Phone</th>';
  if ($other >=9990000000) {
    echo '<th>PIN Number</th>';
  }else {
echo '<th>Other Phone </th>';
}
echo '<th>Email</th>';
  echo  '<th>Fam Group</a></th>';
  echo '</tr></thead>';
echo'<tr><td>'.$user.'</td><td>'.$row8['first_name'].'</td><td>'.$row8['last_name'].'</td><td>';
if ($row8['phone'] != NULL ) {
  echo $row8['phone'];
} else {
  echo '-----------';
}
echo '</td><td>';
if ($row8['cell'] != NULL ) {
  echo $row8['cell'];
} else {
  echo '-----------';
}
echo '</td><td>';
if ($other != NULL ) {
  echo $other;
} else {
  echo '-----------';
}
echo '</td><td>'.$row8['email'].'</td><td>'.$row8['family_grp'].'</td></tr></table>';

}
if ($flag==0)  {
echo '<br><br><span style="position:relative;margin-top:-130px;font-size:18px;color:#545659">Select an item to modify</span><br><form method=post name=mod action="mod_vol.php"><input type=hidden name=todo value="submit"><input type=hidden name=user value="'.$user.'">';
echo '<tr><td  align=left  ><select name=month value="" >Select Month</option>';
echo '<option selected="data" value="first_name">First Name</option>';
echo '<option selected="data" value="last_name">Last Name</option>';
echo '<option selected="data" value="phone">Main Phone</option>';
echo '<option selected="data" value="cell">Cell Phone</option>';
echo '<option selected="data" value="other">Other Phone</option>';
echo '<option selected="data" value="email">Email</option></td>';
echo '<option selected="data" value="family_grp">Group #</option></td></select>';
echo '<br><br>Enter new information to be entered:<input name="replace" type="text" /autofocus><br><br>
<input type="submit" class="g_bubble" value="Modify Volunteer"><span style="position:relative;margin-left:40px;"></span><a href="settings.php" class="g_bubble">CANCEL</a>';
echo '<div style="position:abolute;margin-left:500px;margin-top:-150px;"><table style="border:1px solid black;font-size:16px;background-color:#e5e7ea;border-radius:13px;color:#3e4042;"><td>Helpful Tips:</td><tr></tr><tr><td><i>* 10 Digit Phone #\'s</i></td></tr><tr><td><i>* PINs cannot be modified</i></td></tr><tr><td><i>* Ensure you enter a valid email</i></td></tr><tr><td> </td></tr></table>';


echo '</span></center></div>';
}
?>
