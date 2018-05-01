<?php
include('../connect.php');
include('../functions/session.php');
include('../functions/header.php');

if ($login_lvl>=8){

  include ('../includes/date_today.php');

    $month=$tmonth;
    $year=$tyear;
    $today=$tyear.'-'.$tmonth;
      $start_date= $today.'-01';
      $end_date=$today.'-31';
echo '<div class="centered" style="width:90%;"><center><br><br>';
echo '  <form method=post name=f56 action="../functions/genstmnt_saved.php"><input type=hidden name=year value="'.$tyear.'"><div class="centered"><b>  Generate Quarterly Statements</b>';
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
echo "</select><input type=submit value=Submit></form></tr></table>";
echo "<br><br><i>**Will not create files if the same quarter files already exist!</i></center></div>";



} else {
//back to home page
header("location: ../admin/admintest.php");
}
?>
