<?php
include ('../connect.php');
include('../functions/session.php');
if (isset($_GET['p'])) {
include('../includes/links.php');
}else{
include ('../functions/header.php');
}
if ($login_lvl>=5){
if (empty($_GET['p'])) {
echo '<div style="width:85%;font-size:18px;"><center><p>Search by Last Name</p>';
$field='last_name';
$sort='ASC';
// try the php sorting
if (isset($_GET['l'])) {
  $lname = $_GET['l'];
} else {
  $lname = 'A';
}
foreach (range('A', 'Z') as $char) {
    echo '<a href="people2.php?l='.$char.'">'.$char . "\n".'&nbsp&nbsp</a>';
}
echo '</center></div>';
}
if(isset($_GET['u'])) {
include('../functions/ind.php');

} else {

$sql = "SELECT user_id, phone, other_phone,cell, email, family_grp, CONCAT(first_name,' ',last_name) as name FROM people where last_name
like '$lname%' ORDER BY $field $sort";
if(!$result = $conn->query($sql)){
    die('There was an error running the query [' . $conn->error . ']');
}
echo '<div class="centered"><br><table id="table" class="tablesorter"><thead>';


echo  '<th>User ID</th>';
echo  '<th>Name</th>';
echo '<th>Phone</th>';
echo '<th>2nd Phone</th>';
echo '<th>Cell</th>';
echo '<th>Email</th>';
echo  '<th>Fam Group</a></th>';
echo '</thead>';


while($row=$result->fetch_array()){ //number of rows
echo '<tr style="line-height:18px;">';
$f_grp=$row['family_grp'];
if ($f_grp=='') {
  $f_grp=0;
}
$test=$row['user_id'];
echo '<td>'.$test.'</td><td><a href="./people2.php?u='.$row['user_id'].'&grp='.$f_grp.'&n='.$row['name'].'">'.$row['name'].'</a></td>';

//make phone readable
if ($row['phone'] != 0) {
$area=substr($row['phone'],-10,3);
$pre=substr($row['phone'],-7,3);
$last4=substr($row['phone'],-4,4);
echo '<td>('.$area.') '.$pre.'-'.$last4.'</td>';
} else {
  echo '<td> none</td>';
}
if ($row['other_phone'] != 0) {
$area=substr($row['other_phone'],-10,3);
$pre=substr($row['other_phone'],-7,3);
$last4=substr($row['other_phone'],-4,4);
echo '<td>('.$area.') '.$pre.'-'.$last4.'</td>';
} else {
    echo '<td> none</td>';
}
if ($row['cell'] != 0) {
$area=substr($row['cell'],-10,3);
$pre=substr($row['cell'],-7,3);
$last4=substr($row['cell'],-4,4);
echo '<td>('.$area.') '.$pre.'-'.$last4.'</td>';
} else {
    echo '<td> none</td>';
}
echo '<td>'.$row['email'].'</td>';
if ($f_grp!=0) {
  echo '<td>'.$f_grp.'</td>';
} else {
  echo '<td><a href="mod_vol.php?u='.$test.'&grp='.$f_grp.'&n='.$row['name'].'" style="color:red;">Missing</a></td>';
}

echo '</tr>';
$area = null;
$pre = null;
$last4 = null;
}
}
echo '</table></div>';

} else {
//back to home page
header("location: admintest.php");
}
  ?>
