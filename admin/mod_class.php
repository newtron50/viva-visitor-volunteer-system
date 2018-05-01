<?php
include('../connect.php');
include('../functions/session.php');
include('../functions/header.php');
if ($login_lvl>=8){




$sql5=<<<SQL
  Select * from volunteer_classes where v_class_name !='Visitor'
SQL;
if(!$result5 = $conn->query($sql5)){
    die('There was an error running the query [' . $conn->error . ']');
  }


echo '<div class="centered"><center><br><br>';
echo '<table class="rpt_table_sm"><thead><th>Current Volunteer Classifications</th></thead>';
$x=0;
$vclass = array();
$v_id = array();
while ($row5=$result5->fetch_array()) {
  $v_id=$row5['id'];
  $vclass=$row5['v_class_name'];
  echo '<tr><td>'.$vclass.'</td></tr>';
  $x++;
}
$ttl=$x;
echo '</table>';
echo '<br><br><a href="mod_class.php?a=1" style="font-size:20px;">Add a Class</a><br><br><br><a href="mod_class.php?c=1" style="font-size:20px;">Change a Class Name</a><br><br><br><a href="mod_class.php?m=1" style="font-size:20px;">Create or Modify a<br> Monitor Level</a>';

echo '</center></div>';
}else {
//back to home page
header("location: admintest.php");
}




?>
