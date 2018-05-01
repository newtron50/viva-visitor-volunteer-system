<?php
/****************  ROLLOVER
   Process:
   - Save historical data from current Year
   - Clear all data points
*****************/

include('../connect.php');
include('../functions/session.php');
include('../functions/header.php');
//Program Settings
if ($login_lvl>=8){

if (isset($_GET['roll'])) {
echo '<br><br><center><div class="loader"></div>';
// ********  Create Historical Records ***********
include('../functions/history.php');

/////////////////


$deleterecords = "TRUNCATE TABLE login_record"; //empty the table of its current records
mysqli_query( $conn, $deleterecords );
echo '<br> Log In Records Cleared<br>';
$deleterecord2 = "TRUNCATE TABLE vol_log"; //empty the table of its current records
mysqli_query( $conn, $deleterecord2 );
echo '<br> Volunteer Records Cleared<br>';
$clearvol = "TRUNCATE TABLE record_log"; // clears out the volunteer records
mysqli_query($conn,$clearvol);
echo '<br>All Records Cleared<br>';
echo'</center>';


echo '<span style="position:absolute;margin-top:100px;"<div class="loader_stop"></div>';

  echo '<meta http-equiv="refresh" content="5;url=./rollover.php?done=y">';
} elseif (isset($_GET['done'])) {


echo '<br><br><center><p style="font-size:24px;">Done</center></p>';

} else {

echo '<div style="font-color:#871823;"><center><p style="font-size:32px;"><b>END OF YEAR ROLLOVER</p>';
echo '<span style="font-size:20px;color:#871823;">You are about to do the following:</b></span><br>';
echo '<ul style=" display: inline-block; text-align: left; font-size:16px;color:#1a2d4c;"><li>Archive the current year\'s volunteer data</li>';
echo '<ol><li>Saves all hour totals</li>';
echo '<li>Saves total number of volunteer class hours</li>';
echo '<li>Saves total number of <i>subject</i> hours</li></ol>';
echo '<li>Clears all individual volunteer hours</li>';
echo '<li>Clears all group volunteer hours</li>';
echo '<li><i><b><u>Clears Visitor Records ** See note below</i></u></b></li>';
echo '</ul></center>';
echo '<center><p style="font-size:32;color:red;">Generate Visitor Log <b>BEFORE</b> Rollover!! <br>(Click Yellow: new tab will open.)<br>(Print and click Download spreadsheet to archive information)<br>Visitor information is not saved between years</center>';
echo '<center><p style="color:red;font-size:30px;"><b><span style="background-color:yellow;"><a href="../functions/yr_visits.php" target="_new">Generate Last Year\'s Visitor Logs<br>For Archival Purposes</a></span><br><br><i>Rollover cannot be reversed<br>Select only after you have archived visitor records</b></i><p><a href="./rollover.php?roll=y" class="menu_r">Rollover for New Year</a>';


echo '</div>';
}






} else {
//back to home page
header("location: admintest.php");
}





?>
