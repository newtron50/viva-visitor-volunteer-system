<?php
include('../connect.php');
include('../functions/session.php');
include('../functions/header.php');
if ($login_lvl>=6){

$sql1=<<<SQL
    SELECT distinct vol_subject, sum(TIME_TO_SEC(vol_time_ttl)) as time, count(distinct user_id) as count from vol_log where vol_class > 0 group by vol_subject
SQL;


echo '<div class="centered"><center><h4>Volunteer Statistics by Activities</h4><br></div>';
echo '<div style="float:left;width:33%;"><center>';
if(!$subj1 = $conn->query($sql1)){
    die('Problem with data');
  }
    echo '<table><th style="font-size:12px;">Activity Type</th><th style="font-size:12px;">Hours</th><th style="font-size:12px;">Volunteer #\'s</th>';
$sdc=array();
$scb=array();
$td=array();
$x=0;
$y=0;
    while($subj=$subj1->fetch_array()){
      $time3=round(($subj['time']/60)/60);;
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
    echo '</table></center></div>';
echo '<div style="display:inline-block;width:66%"><center>';
echo 'Select Activty:<br><form method=post name=f2 action="subject.php"><input type=hidden name=todo value=submit>';
echo '<select name=activity>';
$x=0;
if (isset($_POST['todo'])) {
$activity=$_POST['activity'];
}
echo "  <option value='".$activity."'>".$activity."</option>";
while ($x<$y) {
if ($activity!=$sdc[$x]) {
echo "  <option value='".$sdc[$x]."'>".$sdc[$x]."</option>";
}
$x++;
}
echo '<input type=submit value=Submit>
    </form>
  </center></div>';

if (isset($_POST['todo'])) {
$activity=$_POST['activity'];

echo '<div style="display:inline-block;width:25%;"><h4>In Depth Information for '.$activity.'</h4><span style="font-size:14px;margin-left:20px;color:gray;">Top 15 Volunteers</span><a href="sub_list.php?a='.$activity.'" target="_blank" style="font-size:14px;margin-left:30px;">View a full list</a><br><br>';
$sql9=<<<SQL
SELECT distinct CONCAT(v.first_name,' ',v.last_name) as name, v.vol_subject,
sum(TIME_TO_SEC(v.vol_time_ttl))as time, count(user_id) as count, v.user_id, v.family_grp
from vol_log as v
where vol_subject='$activity'
group by name order by time DESC
SQL;
if(!$subj9 = $conn->query($sql9)){
    die('Problem with data');
  }
  echo '<table><th>Name</th><th>Hours</th><th>Entries</th>';
  $x=0;
  $y=0;
  $subc=array();
  $subt=array();
  $subn=array();
  while($deep=$subj9->fetch_array()){
      $dt2=round(($deep['time']/60)/60);
      $d_time=$dt2;
      $subt[$x]=$dt2;
      $subn[$x]=$deep['name'];
      $subc[$x]=$deep['count'];
if ($x<=14) {
    echo '<tr><td style="font-size:12px;"><a href="../admin/people2.php?u='.$deep['user_id'].'&grp='.$deep['family_grp'].'&n='.$subn[$x].'">'.$subn[$x].'</td><td style="font-size:12px;">'.$d_time.'</td><td style="font-size:12px;">'.$subc[$x].'</td></tr>';
  }
    $x++;
    $y++;
  }
  if (isset($_POST['filter'])) {
  $filter=$_POST['filter'];
} else {
  $filter=.05;
}
$pct_fil=$filter * 100;
  echo '</table></div>';
echo '<div style="float:right;width:41%;"><div class="tooltip" style="position:relative;top:30px;left:140px;z-index:5;"><img src="../images/Help.png"alt="question mark" height="15" width="15">
  <span class="tooltiptext">Chart shows data for volunteers. Use the filter value to limit the minimum percentage of time per volunteer shown<br><i><u>gray slice=other volunteers</u></i></span>
</div>&nbsp&nbspChart filter value&nbsp<form method=post name=f6 action="subject.php"><input type=hidden name=todo value=submit><input type=hidden name=activity value="'.$activity.'">';
echo '<select name=filter>';
echo '<option selected="selected">'.$pct_fil.'%</option>';
echo "  <option value='0'>none</option>";
echo "  <option value='.01'>1%</option>";
echo "  <option value='.03'>3%</option>";
echo "  <option value='.05'>5%</option>";
echo "  <option value='.10'>10%</option>";
echo "  <option value='.15'>15%</option>";
echo "  <option value='.20'>20%</option>";
echo "  <option value='.25'>25%</option></select>";
echo '<input type=submit value=Submit></form>';
echo '<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">';
echo "      google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawChart);
      function drawChart() {

        var data = google.visualization.arrayToDataTable([
          ['Activity', 'Hours'],";
          $x=0;
           while ($x<$y) {
           echo "['".$subn[$x]." ',".$subt[$x]."],";
           $x++;
          }

         echo " ]);
        var options = {
          title: '".$activity." Volunteering',
          legend: {
              position: 'bottom'
            },
          ";
 echo "sliceVisibilityThreshold: ".$filter." ";

echo "
      };

        var chart = new google.visualization.PieChart(document.getElementById('piechart'));

        chart.draw(data, options);
      }
    </script>
  </head>
  <body>
    <div id='piechart' style='width: 450px; height: 400px;'></div>
  </body>";



} ///end of todo


} else {
//back to home page
header("location: admintest.php");
}
?>
