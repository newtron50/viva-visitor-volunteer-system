<?php
include ('connect.php');
include (dirname(__FILE__).'/includes/guest_header.php');
//repeat2 verify information
if (isset($_GET['check'])){
$error= "ERROR :: Please enter a 10 digit phone number or pin: no - . , ()";
} else {
  $error = " ";
}
session_start();
if(isset($_GET['me'])) {
  //returning variable from below
} else {
$lname= $_POST['lname'];
$fname= $_POST['fname'];
}


$sql=<<<SQL
 select *
  from people
  where last_name
  like '$lname%' and
  first_name like '$fname%'
SQL;
if(!$result = $conn->query($sql)){
    die('There was an error running the query [' . $conn->error . ']');
}

echo '<div style="position:relative;left:300px;font-size:22px;width:50%;">';

if(isset($_GET['me'])){
 //need to set session variables here
$uid = $_GET['me'];
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
echo "<p style=background-color:#A9D8E8;font-size:24px;align:center;text-align:center;>".$row['first_name']." ".$row['last_name']."<br></p>";
//try new connecgtion
  }
$sql1=<<<SQL
  select * from volunteer_subjects
SQL;
if(!$result = $conn->query($sql1)){
    die('There was an error running the query [' . $conn->error . ']');
  }
echo '<br>Please choose your volunteer task::<center>';
// Display volunteer sub classes for choice
while($row=$result->fetch_array()){ //number of rows
echo '<p class="n_bubble"><a href="barcode.php?vol_sub='.$row['v_sub_name'].'" id=\"tiles\">'.$row['v_sub_name'].'</a></p><br>';
//echo $row['v_sub_name'];
}
echo "</center></div>";
//bail out no submit yet
}
else {
echo '<div class="green"> Please verify the following information</div>';
$x=0;
echo '<br><span style="font-size:16px;"><i>Results for your entry:</i><a href="./repeat-n.php" >&nbsp;&nbsp;&nbsp; Return to Previous page&nbsp;&nbsp;  </a></span>';
echo "<center>";
while($row=$result->fetch_array()){ //number of rows
echo '<a href="repeat_verify.php?me='.$row['user_id'].'""><p class="n_bubble">&nbsp;&nbsp;'.$row['user_id'].'&nbsp; '.$row['first_name'].' '.$row['last_name'].'&nbsp;&nbsp;</p></a>';
echo '<br><br>';
$x++;
}
echo "</center>";
if (empty($row['user_id'])) {
  echo '<br>'.$x.' Users Found <a href="./repeat-n.php" class="n_bubble">&nbsp;&nbsp;&nbsp; Try Again&nbsp;&nbsp;  </a>';
}
}
?>
<br><br><br>
</div>
</header>
</body>
</html>
