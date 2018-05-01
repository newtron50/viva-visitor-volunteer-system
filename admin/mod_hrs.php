<?php
include('../connect.php');
include('../functions/session.php');
include('../functions/header.php');
if ($login_lvl>=8){
  echo '<div class="centerred"><center>';
  echo '<h3>Modify / Edit Volunteer Hours</h3>';
echo '</center></div>';
if(empty($_GET['u'])) {
////////******************
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
    echo '<a href="mod_hrs.php?l='.$char.'">'.$char . "\n".'&nbsp&nbsp</a>';
}
echo '</center></div>';
}
if(isset($_GET['u'])) {
//display Hours
$user_id=$_GET['u'];
$full_name=$_GET['n'];

include ('../includes/date_today.php');

if (empty($_POST['month'])) {
$month=$tmonth;
$year=$tyear;
$today=$tyear.'-'.$tmonth;
  $start_date= $today.'-01';
  $end_date=$today.'-31';


}else {
$month=$_POST['month'];
$year=$_POST['year'];
//$date_value="$month/$dt/$year";
    //echo "mm/dd/yyyy format :$date_value<br>";
    $date_value="$year-$month";
    //echo "YYYY-mm-dd format :$date_value<br>";
    $today=$date_value;
    //get today's date for auto form fill
    $start_date= $today.'-01';
    $end_date=$today.'-31';
    $bobo=$month.'/31/'.$year;
  }


echo '<div><center><br><h3>Edit or Delete <span style="color:blue">'.$full_name.'\'s </span>Volunteer Hours</h3>';
echo 'Select a Different Month to View or Select a Line to Edit</center></div>';
echo "<div><center><br><br>
Select a Month to view:
  <form method=post name=f55 action=''><input type=hidden name=todo value=submit>
  <table border='0' cellspacing='0' >
  <tr><td  align=left  >
  <select name=month value=''>Select Month</option>
  <option selected=".$tmonth." value=".$tmonth.">".$nmonth."</option>
  <option value='01'>January</option>
  <option value='02'>February</option>
  <option value='03'>March</option>
  <option value='04'>April</option>
  <option value='05'>May</option>
  <option value='06'>June</option>
  <option value='07'>July</option>
  <option value='08'>August</option>
  <option value='09'>September</option>
  <option value='10'>October</option>
  <option value='11'>November</option>
  <option value='12'>December</option>
  </select>
  </td><td  align=left  ><select name=year>";
$latest_year=$tyear;
$earliest_year=$tyear-1;
foreach ( range( $latest_year, $earliest_year ) as $i ) {
  // Prints the option with the next year in range.
  print '<option value="'.$i.'"'.($i === $currently_selected ? ' selected="selected"' : '').'>'.$i.'</option>';
}
echo "</select><input type=submit value=Submit></tr>
  </table>
  </form>
</center></div>";

$rel=<<<SQL
  Select v.record, v.user_id, v.vol_date, CONCAT(v.first_name,' ',v.last_name) as name, TIME_FORMAT(v.vol_time_ttl, "%H:%i") as time, v.vol_subject, vc.v_class_name, v.entered_by, CURDATE(), v.entry_date from vol_log as v inner join volunteer_classes as vc ON v.vol_class = vc.id where user_id = $user_id and STR_TO_DATE(v.vol_date ,'%m/%d/%Y') BETWEEN '$start_date' and '$end_date' order by v.vol_date DESC
SQL;
if(!$rel1 = $conn->query($rel)){
    die('There was an error running the query 1 query[' . $conn->error . ']');
}
echo '<div><center><table>';

echo '<thead><th>Date of Activity</th><th>Total Time</th><th>Activity</th><th>Vol. Class</th><th>Entered by</th><th>Date of Entry</th><th>EDIT or DELETE</th></thead>';
while($real=$rel1->fetch_array()){
  $record=$real['record'];
  echo '<tr><td>'.$real['vol_date'].'</td><td>'.$real['time'].'</td><td>'.$real['vol_subject'].'</td><td>'.$real['v_class_name'].'</td><td>'.$real['entered_by'].'</td><td>'.$real['entry_date'].'</td><td>';
  echo '<a href="../functions/e_volHours.php?r='.$record.'&e=1&n='.$full_name.'" class="tooltip2"><img src="../images/edit.png" height="18" width="18"><span class="tooltiptext2">Edit</span></a> &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp';
  echo '<a href="../functions/e_volHours.php?r='.$record.'&e=0" class="tooltip2"><img src="../images/delete.jpeg" height="18" width="18"><span class="tooltiptext2">Edit</span></a></td></tr>';

}
echo '</table></center></div>';
// **************  end display hours

} else {

$sql = "SELECT user_id, phone, other_phone,cell, email, family_grp, CONCAT(first_name,' ',last_name) as name FROM people where last_name
like '$lname%' ORDER BY $field $sort";
if(!$result = $conn->query($sql)){
    die('There was an error running the query [' . $conn->error . ']');
}
echo '<div class="centered"><br><table id="table" class="tablesorter"><thead>';


echo  '<th>User ID</th>';
echo  '<th>Name</th>';
echo  '<th>Fam Group</a></th>';
echo '</thead>';


while($row=$result->fetch_array()){ //number of rows
echo '<tr style="line-height:18px;">';
$f_grp=$row['family_grp'];
if ($f_grp=='') {
  $f_grp=0;
}
$test=$row['user_id'];
echo '<td>'.$test.'</td><td><a href="../admin/mod_hrs.php?u='.$row['user_id'].'&grp='.$f_grp.'&n='.$row['name'].'">'.$row['name'].'</a></td>';

if ($f_grp!=0) {
  echo '<td>'.$f_grp.'</td>';
} else {
  echo '<td><a href="mod_vol.php?u='.$test.'&grp='.$f_grp.'&n='.$row['name'].'" style="color:red;">Missing</a></td>';
}

echo '</tr>';


}
echo '</table></div>';
}
}
 else {
//back to home page
header("location: admintest.php");
}
?>
