<?php
// check fam group record_log
$sql5=<<<SQL
SELECT count(*) FROM family
WHERE grp_nbr = $family_grp
and vol_class = $vol_class
SQL;

$result5 = $conn->query($sql5);

if ($result5->num_rows > 0) {
    // output data of each row
    $fam_grp_check = 'Y';
} else {
    $fam_grp_check = 'N';
}
?>
