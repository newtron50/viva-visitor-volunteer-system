<?php

$fam1=<<<SQL
  SELECT family_grp
  from people where
  user_id = $user_id
SQL;

if(!$fam2 = $conn->query($fam1)){
    die('There was an error running the query [' . $conn->error . ']');
}
while ($fam3 = $fam2->fetch_row()){
$family_grp=$fam3[0];
}

?>
