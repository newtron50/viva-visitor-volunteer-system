<?php
include('../connect.php');
include('../functions/session.php');
include('../functions/header.php');
if ($login_lvl >=1) {
$sql=<<<SQL
 select * from
 settings where id = 1
SQL;

if(!$result = $conn->query($sql)){
    die('There was an error running the query [' . $conn->error . ']');
}
while($row=$result->fetch_assoc()){
  $school=$row['school'];
  $url=$row['site_url'];
  $short_name=$row['school_short_name'];
}

$_SESSION['school'] = $school;
$_SESSION['url'] = $url;
$_SESSION['school_short'] = $short_name;

//echo $_SESSION['admin_level'].'<br> '.$_SESSION['admin_lvl_name'].'<br> '.$_SESSION['login_name'];

if ($login_lvl >=4){
echo'<center><p class="admin_hdr"> Quick Administrative Links:</p></center>';
        echo '<center><a href="../reports/here.php" class="admin_btn">Whose Here?</a>&nbsp;&nbsp;&nbsp;';
        echo '<a href="../reports/today.php" class="admin_btn">View/Print Today\'s Visitor Report</a>&nbsp;&nbsp;&nbsp;';
        if ($login_lvl >=4){
      echo '<a href="../admin/add_vol.php" class="admin_btn">Add a New Volunteer</a>&nbsp;&nbsp;&nbsp;</center>';
      }
    } else {
      echo'<center><br><br><br><p class="admin_hdr"> <br>Welcome to '.$_SESSION['school'].' Visitor / Volunteer Program<br>&nbsp</p></center>';
    }
}  else {
  header("location: ../index.php");
}
?>
