<?php
// update fam_grp record_log

// get family time
$sql4=<<<SQL
  SELECT * from family
  where grp_nbr = $family_grp
  and vol_class = $vol_class
SQL;

if(!$result4 = $conn->query($sql4)){
    die('There was an error running the query [' . $conn->error . ']');
}
while($row4=$result4->fetch_assoc()){
$fam_grp_time = $row4['ttl_time'];
}
$time_yy = $fam_grp_time;
$time_zz = $diff_2;
$secs2 = strtotime($time_zz)-strtotime("00:00:00");
$mstr_updated_time = date("H:i:s",strtotime($time_yy)+$secs2);

$update_fam_grp_record = "UPDATE family set time_ttl = '$mstr_updated_time' where grp_nbr = '$family_grp' and vol_class = '$vol_class' ";
if(($conn->query($update_fam_grp_record)=== TRUE) ){
  echo "<p> Family record for ".$lname. " was updated";
} else {
  echo "<p>Error Updating Family record</p>";
}

?>
