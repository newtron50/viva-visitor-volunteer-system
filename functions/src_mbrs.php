<?php
//for looking up additional group members
$sql9=<<<SQL
  select *
   from
  people where
  family_grp = $grp
SQL;
  echo '<span class="line"></span>';
if(!$result9 = $conn->query($sql9)){
    die('<span style="margin-left:200px;">Oops! - The member selected isn\'t assigned to a Group. <a href="../reports/grp_num_rpt.php?me='.$usr_id.'">Click here to assign a group number</a></span>');
}
echo '<div style="margin-left:140px"><span style="text-decoration:underline;">Additional Group Members:</span><br>';

while($row9=$result9->fetch_array()){
if ($user_id != $row9['user_id']){
echo '<a href="../reports/grp_num_rpt.php?me='.$row9['user_id'].'&grp='. $grp.'">'.$row9['user_id'].'&nbsp'.$row9['first_name'].' '.$row9['last_name'].'</a><br>';
}
}
echo '<br></div><br>';
?>
