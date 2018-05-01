<?php

include ('../functions/header.php');
echo '<br>';
include ('../connect.php');
include('../functions/session.php');
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

echo '<div style="background-color:#eaeaea;"><center> Please verify the following information</center></div><br><br>';
$x=0;
echo "<center>";
while($row=$result->fetch_array()){ //number of rows
echo '<a href="ind_rpt.php?me='.$row['user_id'].'&l='.$row['last_name'].'&n='.$row['first_name'].'""><p class="n_bubble">&nbsp;&nbsp;'.$row['user_id'].'&nbsp; '.$row['first_name'].' '.$row['last_name'].'&nbsp;&nbsp;</p></a>';
echo '<br><br>';
$x++;
}
echo "</center>";
if (empty($row['user_id'])) {
  echo '<br><center>'.$x.' Users Found <a href="./ind_total.php" class="n_bubble">&nbsp;&nbsp;&nbsp; Try Again&nbsp;&nbsp;  </a></center>';
}


?>
