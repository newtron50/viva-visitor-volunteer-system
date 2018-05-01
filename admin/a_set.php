<?php
include('../connect.php');
include('../functions/session.php');
include('../functions/header.php');
//Program Settings
if ($login_lvl>=8){
echo '<br><br><center>This is to set program parameters<br><br></center>';
echo '<br><div class="bottom">
    <div class="col"><span class="report_hdr"><center>Program Setup</center></span><br><center><a href="../includes/rollover.php" class="menu_r">Save Year End Data<br>Start New Vol. Year</center></a><br><center><a href="/dadabik/index.php?tablename=people&function=search&where_clause=&page=0&order=user_id&order_type=DESC" class="menu_r" target="_new">Add New Group<br>With Group Members</center></a><br><center><a href="../reports/fam_update.php" class="menu_r">****3****</center></a></div>
    <div class="col"><span class="report_hdr"><center>Change Program Settings</center><br><center><a href="../reports/search_today.php" class="menu_r">*** 1 ***</center></a><br><center><a href="../reports/search_month.php" class="menu_r">*** 2 ***</center></a><br><center><a href="../reports/find_ind.php" class="menu_r">*** 3 ***</center></a></span></div>
    <div class="col"><span class="report_hdr"><center>Other Functions</center>';
if ($login_lvl>=9){
    echo '<br><center><a href="../functions/save_sql.php" class="menu_r">Save Database<br>to Download File</center></a>';
}
echo '<br><center><a href="../reports/logs.php" class="menu_r">Login Report</center></a><br><center><a href="../functions/genstmnt_qry.php" class="menu_r">Save Quarterly<br>Test Reports</center></a><br><center><a href="../functions/folder.php" class="menu_r">View Saved Files</center></a></span><br>';
} else {
//back to home page
header("location: admintest.php");
}



?>
