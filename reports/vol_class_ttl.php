<?php
include('../connect.php');
include('../functions/session.php');
if (isset($_GET['p'])) {
include('../includes/links.php');
}else{
include ('../functions/header.php');
}
//query database for totals
echo '<div class="report_hdr"><center>Volunteer Time Totals per Volunteer Class & Stats</center></div>';
if (isset($_GET['p'])) {
}
else {
echo '<div><center><a href="./vol_class_ttl.php?p=y" target="_blank">Create a printable report</a><br></center></div>';
}

$sql=<<<SQL
select sum(TIME_TO_SEC(v.vol_time_ttl))as time, vs.v_class_name from vol_log as v INNER JOIN volunteer_classes as vs ON v.vol_class = vs.id group by vs.v_class_name order by v_class_name ASC
SQL;
if(!$result = $conn->query($sql)){
    die('There was an error running the query [' . $conn->error . ']');
}

echo '<br><br><div style=" float: left; width: 33%; "><center><table ><thead><tr>';
//end
// left column
echo '<h4>Total Accumulated Hours by Class</h4>';
echo  '<th>Vol Class</th>';
echo  '<th>Hours</th>';
echo '</tr></thead><tbody>';
$data= array();
$g=0;
$h=0;
$ttl_hrs=0;
while($row=$result->fetch_array()){ //number of rows
echo '<tr>';
$v_class=$row['v_class_name'];
$time=round(($row['time']/60)/60);
$ttl_hrs=$ttl_hrs+$time;
echo '<td>'.$v_class.'</td>'.'<td>'.$time.'</td></tr>';
}

echo '</table>';
echo '<br><b><p style="font-size:20px;">Total Volunteer Hours:';
echo '<br>'.$ttl_hrs;
echo '</p></center></div>';

echo '<div style="display: inline-block; width: 33%;"><center>';
// center stuff
$ctr=<<<SQL
SELECT DISTINCT l.family_grp, last_name, SEC_TO_TIME(sum(TIME_TO_SEC(l.vol_time_ttl)))as time, v.v_class_name from vol_log as l inner join volunteer_classes as v ON v.id = l.vol_class where v.level > 0 group by family_grp  ORDER BY `time` DESC limit 10
SQL;
if(!$ctr_met = $conn->query($ctr)){
    die();
}

echo '<h4>Top 10 Group Hour Contributors</h4>';
echo '<table><th>Group #</th><th>Last Name</th><th>Hours</th>';
while($top10=$ctr_met->fetch_array()){
  $cl=substr($top10['time'],-0,-3);
echo '<tr><td>'.$top10['family_grp'].'</td><td>'.$top10['last_name'].'</td><td>'.$cl.'</td></tr>';
}
echo '</table></center></div>';
//right column
echo '<div style="float:right; width: 33%;"><center>';
// center stuff
echo '<h4>Volunteer Information</h4>';
$usrs=<<<SQL
SELECT count(distinct family_grp) as fam, count(distinct user_id) as id from people
SQL;
if(!$urs = $conn->query($usrs)){
    die();
  }
    echo '<table><th># of Groups</th><th># Volunteers</th>';
    while($u_urs=$urs->fetch_array()){
      $users=$u_urs['id'];
    echo '<tr><td>'.$u_urs['fam'].'</td><td>'.$users.'</td></tr>';
    }
    echo '<br>';

$give1=<<<SQL
  SELECT count(distinct user_id) as id from vol_log
SQL;
    if(!$give2 = $conn->query($give1)){
        die();
      }
        echo '<table><th style="font-size:12px;"># of Volunteers<br><br>with Hours</th><th style="font-size:12px;">% of Volunteer Base</th>';
        while($give=$give2->fetch_array()){
        $usr_hrs= $give['id'];
        $usr_pct=(($usr_hrs/$users)*100);
        $not_give=100-$usr_pct;
        $not_give= number_format( $not_give ,2, '.','');
        $usr_pct= number_format( $usr_pct ,2, '.','');
        echo '<tr><td>'.$usr_hrs.'</td><td>'.$usr_pct .'%</td></tr>';
        }
        echo '<br>';
echo '</table>';
  echo '<br>';
echo '<img src="http://chart.googleapis.com/chart?cht=p3&chtt=%%20of%20people%20that%20have%20volunteered&chs=400x150&chd=t:'.$usr_pct.','.$not_give.'&chl='.$usr_pct.'%|'.$not_give.'%">';
echo '</center></div>';

//echo by subject
echo '<br><div style="float:left; width: 30%;"><br><br><center><h4>Volunteers & Hours Per<br>Volunteer Class<br>';
$sql9=<<<SQL
  SELECT distinct vol_subject, sum(TIME_TO_SEC(vol_time_ttl)) as time, count(distinct user_id) as count from vol_log where vol_class > 0 group by vol_subject
SQL;
 if(!$subj1 = $conn->query($sql9)){
     die('Problem with count 1 data');
   }
     echo '<table><th style="font-size:12px;">Activity Type</th><th style="font-size:12px;">Hours</th><th style="font-size:12px;">Volunteer #\'s</th>';
$sdc=array();
$scb=array();
$td=array();
$x=0;
$y=0;
     while($subj=$subj1->fetch_array()){
       $time3=round((($subj['time']/60)/60));
       $time2=$time3;
       $time5=$time3;
       $s1=$subj['vol_subject'];
       $sc=$subj['count'];
       $scb[$x]=$sc;
       $sdc[$x]=$s1;
       $td[$x]=$time5;
       echo "<tr><td>".$s1."</td><td>".$time2."</td><td>".$sc."</td></tr>";
       $x++;
       $y++;
     }
     echo '</table>';
echo '</center></div>';
//graph for volunteer subjects
$x=0;
echo '<div style=" position: absolute;
    right: 0px;""><br><br>';
echo '<br><br>';
/// gonna try new google chart
echo '<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

<script type="text/javascript">
  google.charts.load("current", {packages:["corechart"]});
  google.charts.setOnLoadCallback(drawChart);
  function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ["Activity", "Hours"],';
          $x=0;
           while ($x<$y) {
           echo "['".$sdc[$x]." ',".$td[$x]."],";
           $x++;
          }

         echo ' ]);
         var options = {
           title: "Total Volunteer Hours by Activity",
           is3D: true,
         };

         var chart = new google.visualization.PieChart(document.getElementById("donutchart"));
         chart.draw(data, options);
       }
     </script>
     <div id="donutchart" style="width: 700px; height: 500px;"></div>';


echo  '<br>';
echo '</div>';
?>
