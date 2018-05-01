<?php
include('../connect.php');
$q5 = "SELECT SEC_TO_TIME(sum(TIME_TO_SEC(v.vol_time_ttl)))as time, vs.v_class_name,vs.level,v.vol_class from vol_log as v inner join volunteer_classes as vs on v.vol_class = vs.id where family_grp = $grp group by v.vol_class";
if(!$raw1 = $conn->query($q5)){
    die();
  }
  $delta=array();
  $x=0;
  $c=0;
  while($raw=$raw1->fetch_array()){
$delta[$x]= $raw['v_class_name'];
$x++;
    $lvl=$raw['time'];
    $lvl=substr($lvl,-0,-6);
$delta[$x]=    $lvl;
$x++;
$delta[$x]=    $raw['level'];
$x++;
$c++;
   }

echo '<img src="http://chart.googleapis.com/chart?cht=bhg&chs=400x100&chxt=x,y&chxl=1:|Development|Fair+Share&chtt=Volunteer+Hours&chts=blue,12px,center&chd=s:VolunteerClasses&chf=bg,s,EBEDED&chco=FF4F4F|324DFC|324DFC|324DFC&chbh=12&chd=t:0,0|'.$delta[1].','.$delta[4].'" style="margin-left:160px;"> ';


?>
