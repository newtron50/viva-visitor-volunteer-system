<?php
include('../connect.php');
include('../functions/session.php');
include('../functions/header.php');
if ($login_lvl>=6){
include ('../includes/date_today.php');

  $month=$tmonth;
  $year=$tyear;
  $today=$tyear.'-'.$tmonth;
    $start_date= $today.'-01';
    $end_date=$today.'-31';

echo '<div class="centered"><center>';
echo '<h4>Statement Choices - <b>Select ONLY ONE</b></h4></center><form target="_blank" method=post name=f55 action="../functions/genstatements.php"><input type=hidden name=todo value=submit><input name="rpttype" type="checkbox" value="m"/><b>  Generate Monthly Statements</b>';
echo '</div>';
echo "<div><center><br>
Select a Month to Generate Reports:

  <table border='0' cellspacing='0' >
  <tr><td  align=left  >
  <select name=month value=''>Select Month</option>
  <option selected=".$tmonth." value=".$tmonth.">".$nmonth."</option>
  <option value='01'>January</option>
  <option value='02'>February</option>
  <option value='03'>March</option>
  <option value='04'>April</option>
  <option value='05'>May</option>
  <option value='06'>June</option>
  <option value='07'>July</option>
  <option value='08'>August</option>
  <option value='09'>September</option>
  <option value='10'>October</option>
  <option value='11'>November</option>
  <option value='12'>December</option>
  </select>
  </td><td  align=left  ><select name=year>";
$latest_year=$tyear;
$earliest_year=$tyear-1;
foreach ( range( $latest_year, $earliest_year ) as $i ) {
  // Prints the option with the next year in range.
echo '<option value="'.$i.'"'.($i === $currently_selected ? ' selected="selected"' : '').'>'.$i.'</option>';
}
echo "</select><input  type=submit value=Submit></tr>
  </form></table>
</center></div><p class='line' style='width:80%;'></p><br>";


echo '  <form target="_blank" method=post name=f56 action="../functions/genstatements_qtr.php"><input type=hidden name=year value="'.$tyear.'"><div class="centered"><input name="rpttype" type="checkbox" value="q"/><b>  Generate Quarterly Statements</b>';
echo '</div>';
echo "<div><center><br>
Select a Quarter to Generate Reports:
<table border='0' cellspacing='0' >
  <tr><td  align=left  >
  <select name=month value=''>Select Month</option>
  <option value='1'>June-July-Aug</option>
  <option value='2'>Sept-Oct-Nov</option>
  <option value='3'>Dec-Jan-Feb</option>
  <option value='4'>Mar-Apr-May</option>";
echo "</select><input type=submit value=Submit></form></tr>
  </table>
</center></div><p class='line' style='width:80%;'></p><br>";
echo '<form target="_blank" method=post name=f57 action="../functions/genstatements_yr.php"><input type=hidden name=year value="'.$tyear.'"><input type=hidden name=month value="1"><div class="centered"><input name="rpttype" type="checkbox" value="eof"/><b>  Generate Year End Statements</b>';
echo '</div>';
echo "<div><center><br>
End of Year reports:</select><input type=submit value=Submit></tr>
  </table></form>
</center></div><p class='line' style='width:80%;'></p><br>";


} else {
//back to home page
header("location: ../admintest.php");
}
?>
