<?php
$fam_ttl=<<<SQL
SELECT  SEC_TO_TIME(sum(TIME_TO_SEC(v.vol_time_ttl)))as time, vs.v_class_name,v.vol_class, vs.level
from vol_log as v
inner join volunteer_classes as vs
on v.vol_class = vs.id
where family_grp = $grp group by v.vol_class
SQL;

if(!$result_ttl = $conn->query($fam_ttl)){
    die;
  }

echo '<table class="rpt_table_sm2" style="width:300px;">';
echo '<thead><th colspan="2">Group Volunteer Class Totals</th><th>Target</th></thead>';
$grp_data=0;
while($row_ttl=$result_ttl->fetch_array()) {
  $clock1=$row_ttl['time'];
  $clock1=substr($clock1,0,-3);
  echo '<tr><td>'.$row_ttl['v_class_name'].'</td><td>'.$clock1.'</td><td>'.$row_ttl['level'].'</td></tr>';
$grp_data++;
  }
  if ($grp_data==0) {
    echo '<tr><td colspan="2"> No data available for this group';
  }
  if ($grp==NULL) {
    echo '<tr><td colspan="2"> No group assigned for this volunteer</td></tr>';
  }
  echo '</table>';

?>
