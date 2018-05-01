<?php
//yearly member report

$yr_end=<<<SQL
SELECT distinct concat(r.first_name,' ',r.last_name) as name, v.v_class_name, user_id, TIME_FORMAT(SEC_TO_TIME(sum(TIME_TO_SEC(r.vol_time_ttl))), "%H:%i")as time  from vol_log as r inner join volunteer_classes as v on r.vol_class = v.id where family_grp = $rec group by name, v.v_class_name order by name ASC
SQL;

if(!$ok1 = $conn->query($yr_end)){
die();
}
?>
