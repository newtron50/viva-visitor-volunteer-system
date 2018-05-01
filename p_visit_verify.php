<?php
include ('connect.php');
include (dirname(__FILE__).'/includes/guest_header.php');
//repeat2 verify information
$b=0;
if(isset($_GET['f'])) {
$ln=$_GET['l'];
$fn=$_GET['f'];
$ph=$_GET['p'];
echo '<center><br><br>';
echo 'Please enter the reason for your visit today<br><br>';
echo '<form action="new_visit.php" method="post"><input type=hidden name=k value="n"><input type=hidden name=lname value="'.$ln.'"><input type=hidden name=fname value="'.$fn.'"><input type=hidden name=cell value="'.$ph.'">';
echo '<input name="reason" type="text" placeholder="reason for visit" autofocus/>';
echo '<br><br>  <input type="submit" class="n_bubble" ></center><br><br>';
} else {

$phone= $_POST['phone'];
//eliminate every char except 0-9  VERIFY PHONE NUMBER
$justNums = preg_replace('/[^0-9]/', '', $phone);
//eliminate leading 1 if its there
if (strlen($justNums) == 11) {
$justNums = preg_replace("/^1/", '',$justNums);
}
$phone = $justNums;
//if we have 10 digits left, it's probably valid.
if (strlen($justNums) != 10){
  echo "<meta http-equiv='refresh' content='0;url=./visit_repeat.php?n=2&check=error'>";
}

$sql=<<<SQL
SELECT DISTINCT last_name, first_name from record_log where phone =$phone
UNION
SELECT DISTINCT last_name, first_name from people where phone =$phone
UNION
SELECT DISTINCT last_name, first_name from people where cell =$phone
SQL;
echo '<center><br><br>';
  $x=0;
if(!$result = $conn->query($sql)){
    die('There was an error running the query [' . $conn->error . ']');
  }
while($row=$result->fetch_array()){ //number of rows

  //echo $row['last_name'];
echo '<center><a href="p_visit_verify.php?f='.$row['first_name'].'&l='.$row['last_name'].'&p='.$phone.'"><p class="n_bubble">&nbsp; '.$row['first_name'].' '.$row['last_name'].' </p></a>';
//try new connecgtion
echo '<br>';
$x++;
//bail out no submit yet
}  $v_type = 'VIS';
  $_SESSION['rec']= $row['rec'];
  $_SESSION['l_name'] = $row['last_name'];
  $_SESSION['f_name'] = $row['first_name'];
  $_SESSION['phone'] = $row['phone'];


  echo '<br>'.$x.' Users Found <a href="./visit_repeat.php?n=2" class="n_bubble">&nbsp;&nbsp; Try Again&nbsp;&nbsp;  </a>';
}

  echo '<br><br><br><br> <center><a href="./visit_class.php" class="return">Return to Visitor Start Page</a>';

echo '<br></center>';
?>
