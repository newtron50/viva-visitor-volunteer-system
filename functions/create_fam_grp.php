<?php
// Create family group record_log

$create_fam = "INSERT INTO family (grp_nbr, vol_class,last_name,ttl_time,last_updated) VALUES ('$family_grp','$vol_class2','$lname','$diff_2','$datein')";
if(($conn->query($create_fam)=== TRUE) ){
echo "<p style='text-align:center;font-size:2em;font-family:Arial;'>Family group was created</p>";
} else {
echo "Error record log: " . $sql . "<br>" . $conn->error;
}

?>
