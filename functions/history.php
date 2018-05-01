<?php
/***************************
   historical rollover for visitor Program
***************************/
// current Year
$cur_yr= date("Y");


//  save number of Volunteer classes and subjects
$sql_vc=<<<SQL
  SELECT count(*) as count from volunteer_classes where level is not NULL
SQL;
if(!$result_vc = $conn->query($sql_vc)){
    die('There was an error running the query [' . $conn->error . ']');
}
while($row_vc=$result_vc->fetch_array()){
  $cl_num=$row_vc['count'];
  $sql_bvc = "INSERT into history (hist_year,name,type,amount) VALUES ($cur_yr,'Volunteer Classes','# of classes',$cl_num)";
  mysqli_query($conn,$sql_bvc);
}
//  save number of volunteer subjects

$sql_vs=<<<SQL
  SELECT count(*) as count from volunteer_subjects
SQL;
if(!$result_vs = $conn->query($sql_vs)){
    die('There was an error running the query [' . $conn->error . ']');
}
while($row_vs=$result_vs->fetch_array()){
  $cl_nums=$row_vs['count'];
  $sql_bvcs = "INSERT into history (hist_year,name,type,amount) VALUES ($cur_yr,'Volunteer Subjects','# of subjects',$cl_nums)";
  mysqli_query($conn,$sql_bvcs);
}

//  calculate history totals

$sql_a=<<<SQL
select sum(TIME_TO_SEC(v.vol_time_ttl))as time, vs.v_class_name from vol_log as v INNER JOIN volunteer_classes as vs ON v.vol_class = vs.id group by vs.v_class_name order by v_class_name ASC
SQL;
if(!$result_a = $conn->query($sql_a)){
    die('There was an error running the query [' . $conn->error . ']');
}

$data= array();
$g=0;
$h=0;
$ttl_hrs=0;
$v1=0;


while($row_a=$result_a->fetch_array()){ //number of rows

$v_class_a=$row_a['v_class_name'];
$time_a=round(($row_a['time']/60)/60);
$ttl_hrs=$ttl_hrs+$time_a;
$v1++;
//  sql for injection
$sql_b = "INSERT into history (hist_year,name,type,amount) VALUES ($cur_yr,'$v_class_a','Class',$time_a)";
mysqli_query($conn,$sql_b);
}
// Insert total hours into records'
$yr= $cur_yr.' Total Hours';
$sql_hist = "INSERT into history (hist_year,name,type,amount) VALUES ($cur_yr,'$yr','year',$ttl_hrs)";
mysqli_query($conn,$sql_hist);

/////   Now write Volunteer subject total hours to history
$usrs_h=<<<SQL
SELECT count(distinct family_grp) as fam, count(distinct user_id) as id from people
SQL;
if(!$urs_h = $conn->query($usrs_h)){
    die();
  }
    while($u_urs=$urs_h->fetch_array()){
      $users=$u_urs['id'];
      $grp_num=$u_urs['fam'];
  $sql_u = "INSERT into history (hist_year,name,type,amount) VALUES ($cur_yr,'Group','totals',$grp_num)";
  mysqli_query($conn,$sql_u);
  $sql_m = "INSERT into history (hist_year,name,type,amount) VALUES ($cur_yr,'Volunteers','totals',$users)";
  mysqli_query($conn,$sql_m);
}


$give_h=<<<SQL
  SELECT count(distinct user_id) as id from vol_log
SQL;
    if(!$give2h = $conn->query($give_h)){
        die();
      }
        while($give_t=$give2h->fetch_array()){
        $usr_hrs= $give_t['id'];
        $usr_pct=(($usr_hrs/$users)*100);
        $not_give=100-$usr_pct;
        $not_give= number_format( $not_give ,2, '.','');
        $usr_pct= number_format( $usr_pct ,2, '.','');

        $sql_vol = "INSERT into history (hist_year,name,type,amount) VALUES ($cur_yr,'Volunteers with hours','totals',$usr_hrs)";
        mysqli_query($conn,$sql_vol);
        $sql_pct = "INSERT into history (hist_year,name,type,amount) VALUES ($cur_yr,'Volunteer Base of Donations','Percentage',$usr_pct)";
        mysqli_query($conn,$sql_pct);
        }

/*********************
write subject totals to history
**********************/

$sqlh9=<<<SQL
  SELECT distinct vol_subject, sum(TIME_TO_SEC(vol_time_ttl)) as time, count(distinct user_id) as count from vol_log where vol_class > 0 group by vol_subject
SQL;
 if(!$subjh9 = $conn->query($sqlh9)){
     die('Problem with data');
   }
$sdc=array();
$scb=array();
$td=array();
$x=0;
$y=0;
     while($subj_h=$subjh9->fetch_array()){
       $time3=round((($subj_h['time']/60)/60));
       $time2=$time3;
       $time5=$time3;
       $s1=$subj_h['vol_subject'];
       $sc=$subj_h['count'];
       $scb[$x]=$sc;
       $sdc[$x]=$s1;
       $td[$x]=$time5;
//       echo "<tr><td>".$s1."</td><td>".$time2."</td><td>".$sc."</td></tr>";
       $sql_h9 = "INSERT into history (hist_year,name,type,amount) VALUES ($cur_yr,'$s1','subject',$sc)";
       mysqli_query($conn,$sql_h9);


       $x++;
       $y++;
     }






//****************************************

echo "<br>History Records Saved<br>";
///// Write number of members / groups to history


?>
