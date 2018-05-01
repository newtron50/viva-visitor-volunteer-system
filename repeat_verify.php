<?php
include ('connect.php');
include (dirname(__FILE__).'/includes/guest_header.php');
//repeat2 verify information
$b=0;
session_start();
if(isset($_GET['me'])) {
  //returning variable from below
  $b=1;
} else {
//$lname= $_POST['lname'];
//$fname= $_POST['fname'];
$phone= $_POST['cellphone'];
//eliminate every char except 0-9  VERIFY PHONE NUMBER
$justNums = preg_replace('/[^0-9]/', '', $phone);
//eliminate leading 1 if its there
if (strlen($justNums) == 11) {
$justNums = preg_replace("/^1/", '',$justNums);
}
$phone = $justNums;
//if we have 10 digits left, it's probably valid.
if ((strlen($justNums) != 10)or(isset($lname))or(isset($fname))){
  echo "<meta http-equiv='refresh' content='0;url=./repeat.php?check=\"error\"'>";
}

$sql=<<<SQL
 select *
  from people
  where phone =$phone or cell=$phone or other_phone=$phone
SQL;

if(!$result = $conn->query($sql)){
    die('There was an error running the query [' . $conn->error . ']');
}

}
echo '<link href="./css/multiColumnTemplate.css" rel="stylesheet" type="text/css">';


echo "<div style='position:relative;left:300px;font-size:22px;width:50%;'>";

if(isset($_GET['me'])){
 //need to set session variables here
$uid = $_GET['me'];
//retrieve people info based on UID
$sql=<<<SQL
select * from people
where user_id = $uid
SQL;
if(!$result = $conn->query($sql)){
    die('There was an error running the query [' . $conn->error . ']');
  }
while($row=$result->fetch_array()){ //number of rows
  $v_type = 'VOL';

  $_SESSION['l_name'] = $row['last_name'];
  $_SESSION['f_name'] = $row['first_name'];
  $_SESSION['user_id'] = $row['user_id'];
  $_SESSION['phone'] = $row['phone'];
  $_SESSION['cell'] = $row['cell'];
  $_SESSION['family'] = $row['family_grp'];
  $_SESSION['v_type'] = $v_type;
  //echo $row['last_name'];
echo "<h2>".$row['first_name']." ".$row['last_name']."<br></h2>";
//try new connecgtion
  }
$sql1=<<<SQL
  select * from volunteer_subjects
SQL;
if(!$result = $conn->query($sql1)){
    die('There was an error running the query [' . $conn->error . ']');
  }
echo '<br>Please choose your volunteer task::<br><br><center>';
// Display volunteer sub classes for choice
$y=0;
//
//echo '<h2 class="n_bubble"><a href="barcode.php?vol_sub='.$row['v_sub_name'].'&vol_class='.$row['v_sub_class'].'" id=\"tiles\">'.$row['v_sub_name'].'</a></h2>';
//
while($row=$result->fetch_array()){ //number of rows
echo '<a href="barcode.php?vol_sub='.$row['v_sub_name'].'&vol_class='.$row['v_sub_class'].'" id=\"tiles\" class="n_bubble">'.$row['v_sub_name'].'</a>';
$y++;
if ($y % 4 != 0) {
  echo str_repeat('&nbsp;', 6);
}
if ($y % 4 == 0){
  echo '<br><br><br>';
}
}
echo '<br></center>';
//bail out no submit yet
}
else {
  $x=0;
echo '<div class="green"> Please verify the following information</div><br><br>';

while($row=$result->fetch_array()){ //number of rows
  $area=substr($row['phone'],-10,3);
  $pre=substr($row['phone'],-7,3);
  $last4=substr($row['phone'],-4,4);
  $area2=substr($row['cell'],-10,3);
  $pre2=substr($row['cell'],-7,3);
  $last42=substr($row['cell'],-4,4);

echo '<center><a href="repeat_verify.php?me='.$row['user_id'].'""><p class="n_bubble">'.$row['user_id'].'&nbsp; '.$row['first_name'].' '.$row['last_name'].'</p></a>';
echo '<br><br>';
$x++;
}
if (empty($row['user_id'])) {
  echo '<br>'.$x.' Users Found <a href="./repeat.php" class="n_bubble">&nbsp;&nbsp; Try Again&nbsp;&nbsp;  </a>';
}
}
?>
