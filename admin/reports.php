<?php
include('../connect.php');
include('../functions/session.php');
include('../functions/header.php');
if ($login_lvl>=6){

if(isset($_GET['vol_typ'])){
$r_vol_type=$_GET['vol_typ'];
$r_time=$_GET['tyme'];

include (dirname(__FILE__).'/includes/fam_grp_list.php');


} else {

echo '<br><div class="bottom">
    <div class="col"><span class="report_hdr"><center>Volunteer Reports</center></span><br><center><a href="../admin/people2.php" class="menu_r">Individual<br>Volunteer Report</center></a><br><center><a href="../reports/grp_ttls.php" class="menu_r">Volunteer Totals<br>For Families<br>or Groups</center></a><br><center><a href="../reports/statements.php" class="menu_r">Generate<br>Volunteer Statements</center></a><br><center><a href="../reports/history.php" class="menu_r">Review & Compare<br>Historical Reports</center></a></div>
    <div class="col"><span class="report_hdr"><center>Visitor Reports</center><br><center><a href="../reports/search_today.php" class="menu_r">View a Daily<br>Guest Report</center></a><br><center><a href="../reports/search_month.php" class="menu_r">Monthly<br>Guest Report</center></a><br><center><a href="../reports/find_ind.php" class="menu_r">Find Any<br>Visitor</center></a></span></div>
    <div class="col"><span class="report_hdr"><center>Other Reports</center><br><center><a href="../reports/vol_class_ttl.php" class="menu_r">Program<br>Metrics</center></a></span><br><center><a href="../reports/subject.php" class="menu_r">Volunteer Activity <br>Metrics</center></a><br><center><a href="../reports/groups.php" class="menu_r">Family or<br>Group Members</center></a><br><center><a href="../reports/fam_update.php" class="menu_r">Search for<br>Assigned Group IDs</center></a><br><center></span></div>
</div>';
}
} else {
//back to home page
header("location: admintest.php");
}
?>
