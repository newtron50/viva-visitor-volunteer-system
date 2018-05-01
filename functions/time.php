<?php
//time functions
$clock = substr($t_in, strpos($t_in, " ") + 1);
$clock2=date("H",strtotime($clock));
$minutes=date("i",strtotime($clock));
$clock=date("h:i a",strtotime($clock));
$clock = ltrim($clock, '0');

$hour=$clock2;
echo '<br><br><center>';
//echo '<b>This feature is in development -- NOT USABLE</b><br><br>';
//echo $hour.'<br>'.$minutes;
echo '<h3>Editing Sign Out time for '.$fname.' '.$lname.'</h3>';
echo '<br>Checked in at: '.$clock.'<br>';
echo '<br><br>Change the Sign Out time to:<br>';
echo '<br><br>';
echo "<form method=post name=f66 action=''><input type=hidden name=now value=clock><input type=hidden name=barc value=".$barc.">
<input type=hidden name=rnum value=".$rnum.">Select the Hour<table border='0' cellspacing='0' >
<tr><td  align=left  ><select name=hour value=''>Select Hour</option>";
// test code
$count_time=$hour;
$max_hrs=23;

while ($count_time <= $max_hrs) {
  $display_time=$count_time;
$delimiter=' am';
if ($count_time > 12) {
  $display_time=$count_time-12;
  $delimiter=' pm';
}
if ($count_time == 00) {
$delimiter=' am';
  $display_time=12;
  }
echo "<option value=".$count_time.">".$display_time.$delimiter."</option>";
$count_time++;
}
echo "</select></td></tr></table>";
echo "Select the minutes<table border='0' cellspacing='0' >
<tr><td  align=left  >
<select name=min value=''>Select Minutes</option>";
echo "<option value=00>00</option>";
echo "<option value=10>10</option>";
echo "<option value=20>20</option>";
echo "<option value=30>30</option>";
echo "<option value=40>40</option>";
echo "<option value=50>50</option>";
echo "</select></td></tr></table>";
echo "  <input type=submit value=Submit></form>";
?>
