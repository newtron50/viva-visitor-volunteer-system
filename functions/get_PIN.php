<?php
//create a pin Number

$search = "SELECT  max(other_phone) as phone2
 from people";


if(!$result = $conn->query($search)){
     die('There was an error running the query [' . $conn->error . ']');
  }
while($row=$result->fetch_assoc()){
  $last_pin=$row['phone2'];
}
//first pin created
if ($last_pin<9990000001) {
  $new_pin=9990000001;
} elseif ($last_pin==9999999999) {
//out of pins --
/*$hunt_pin = "SELECT other_phone from people order by other_phone ASC";
if(!$result1 = $conn->query($hunt_pin)){
     die('There was an error running the query [' . $conn->error . ']');
  }
$lowest=9990000001;
while($row1=$result1->fetch_assoc()){
  $current=$row1['other_phone'];
  if ($current >= $lowest) {
    //in the Zone
      if
  }
}
echo '<br>Need to create function to find pin slots<br>';
*/    //end of code
} else {
  $new_pin = $last_pin+1;
}



?>
