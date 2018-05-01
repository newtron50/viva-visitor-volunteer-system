
 <script type="text/javascript" src="https://www.google.com/jsapi"></script>

 <script type="text/javascript">
 google.load('visualization', '1', {packages: ['corechart', 'bar']});
 google.setOnLoadCallback(drawMaterial);
 <?php
$temp=$x;
 $q5 = "SELECT SEC_TO_TIME(sum(TIME_TO_SEC(v.vol_time_ttl)))as time, vs.v_class_name,vs.level,v.vol_class from vol_log as v inner join volunteer_classes as vs on v.vol_class = vs.id where family_grp = $grp group by v.vol_class";
 if(!$raw1 = $conn->query($q5)){
     die();
   }
$data=array();
$x=0;
$y=0;
     while($raw=$raw1->fetch_array()){
$data[$x]=$raw["v_class_name"];
$x++;
  $lvl=$raw["time"];
  $lvl=substr($lvl,-0,-6);
$data[$x]= $lvl;
$x++;
$data[$x]= $raw["level"];
$x++;
$y++;
 }
 ?>
 function drawMaterial() {
 var data = google.visualization.arrayToDataTable([
 ['Vol. Classes', 'Hours Completed', 'Target Hours'],
 <?php
 $w=0;
 $x=0;
 $co=$y;
 $y=1;
 $z=2;
 while ($w<$co) {
 echo "['".$data[$x]."',".$data[$y].",".$data[$z]."],";
 $x=$x+3;
 $y=$y+3;
 $z=$z+3;
 $w++;
 }
 $x=$temp;
 ?>
  ]);

 var options = {
 title: 'Group Volunter Hours',
 bars: 'horizontal'
 };
 var material = new google.charts.Bar(document.getElementById('barchart'));
 material.draw(data, options);
 }
 </script>
<h5>Group Volunteer Totals</h5>
 <div id="barchart" style="width: 600px; height: 100px;margin-left:150px;"></div>
