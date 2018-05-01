<?php


$usr_id = $_GET['u'];
$grp = $_GET['grp'];
$full_name=$_GET['n'];
$x=0;

//personal totals
$get_totals=<<<SQL
SELECT  SEC_TO_TIME(sum(TIME_TO_SEC(v.vol_time_ttl)))as time, vs.v_class_name, v.vol_class
from vol_log as v
inner join volunteer_classes as vs
on v.vol_class = vs.id
where user_id = $usr_id group by v.vol_class
SQL;
if(!$stuff = $conn->query($get_totals)){
    die();
}
echo '<br><div style="width:60%;"><br><center>Volunteer information for:&nbsp<span style="font-size:18px;font-family:arial;">'.$full_name.'</span>';
if (empty($_GET['p'])) {
echo'<a href="people2.php?u='.$usr_id.'&grp='.$grp.'&n='.$full_name.'&p=y" style="margin-left:40px;font-size:12px;" target="_new">Create Printable Record</a>';
}
echo '</center><br></div>';
echo '<div style="width:40%;float:left;"><table class="rpt_table_sm" style="width:300px;margin-left:50px;">';
echo '<thead><th colspan="2">Individual Volunteer Class Totals</th></thead>';
$no_data=0;
while($stuff1=$stuff->fetch_array()){
  //modify time to show correctly
$clock=$stuff1['time'];
$clock=substr($clock,-0,-3);
//$hrs=substr($clock,0,-4);
  echo '<tr><td>'.$stuff1['v_class_name'].'</td><td>'.$clock.'</td>';
  $no_data++;
}
if ($no_data ==0) {
  echo '<tr><td colspan="2">No data totals entered for '.$full_name.'</td></tr>';
}
echo '</table></div>';
  echo '<div style="width:40%;float:left;">';
include('../functions/grp_ttls.php');
echo '</div>';
// insert bar charts
if ($grp!=NULL){
  echo '<div style="width:60%;margin-left:70px;">';
include('bar.php');
echo '</div>';
}

// ** other group members
$sql9=<<<SQL
  select user_id, CONCAT(first_name,' ',last_name) as name, family_grp
   from
  people where
  family_grp = $grp
SQL;

if(!$result9 = $conn->query($sql9)){
    die();
}
echo '<br><br><div style="margin-left:160px;"><span style="text-decoration:underline;font-size:16px">Additional Group Members:</span><br><br></div>';
echo '<div style="margin-left:160px;">';
$ttt=0;
while($row9=$result9->fetch_array()){
  if ($usr_id != $row9['user_id']){
      if ($ttt<=3) {
        echo '<span class="list_space"></span><a href="people2.php?u='.$row9['user_id'].'&grp='. $grp.'&n='.$row9['name'].'">'.$row9['user_id'].'&nbsp'.$row9['name'].'</a><span class="list_space;"></span>';
        $ttt++;
      }
      if ($ttt==4) {
        $ttt=0;
        echo '<br><br>';
      }
  }
}
echo '</div><br>';
if ($grp==0) {
  echo '<div style="width:300px;margin-left:350px;font-family:arial;"><span style="color:red;font-size:18px;"font-family:arial;">Oops! </span><i>The member selected isn\'t assigned to a Group. </i><br><span class="space"><a href="mod_vol.php?u='.$usr_id.'&grp='.$f_grp.'&n='.$full_name.'" target="_new" ><br>Click here to assign a group number</a></span>';
}
echo '</div>';



//*** separate volunteer times
if ($no_data>=1) {
   echo '<br><div style="margin-left:180px;">Individual Volunteer Times for the last 60 days:';
   echo '<span style="margin-left:50px;"></span><a href="../reports/volunteer.php?u='.$usr_id.'&n='.$full_name.'">View / Print all Entries</a></div>';
}

$sql8=<<<SQL
select r.vol_date, r.vol_subject, TIME_FORMAT(r.vol_time_ttl, "%H:%i") as time, v.v_class_name,  r.entered_by from
  vol_log as r
  inner join volunteer_classes as v on
  r.vol_class = v.id
  where r.user_id =$usr_id and STR_TO_DATE(r.vol_date ,'%m/%d/%Y') >= (CURDATE() - INTERVAL 2 month);
SQL;
if(!$result8 = $conn->query($sql8)){
    die('There was an error running the query 1 query[' . $conn->error . ']');
}
echo '<div>';
while($row8=$result8->fetch_array()){
    if ($x==0) {
echo '<table class="rpt_table_2" style="margin-left:100px">';
echo '<thead><th>Date</th><th>Time</th><th>Reason</th><th>Volunteer Class</th><th>Entered by</thead>';
      }
$x++;
$ttl_time=$row8['time'];
$btime = $row8['vol_date'];
$time= strtotime($btime);
$monthcode = date( 'M-d-Y', $time );
echo '<tr><td>'.$monthcode.'</td><td>'.$ttl_time.'</td><td>'.$row8['vol_subject'].'</td><td>'.$row8['v_class_name'].'</td><td>'.$row8['entered_by'].'</td></tr>';
}
echo '</table></div>';




?>
