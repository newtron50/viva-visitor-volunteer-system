<?php
include('../connect.php');
include('../functions/session.php');
include('../functions/header.php');




echo '<br><div class="bottom">
    <div class="col"><span class="report_hdr"><center>Volunteer Add / Modify<span style="text-decoration:italic;font-size:14px;color:gray;"> Requires secure login</span></center></span><br><center><a href="/dadabik/index.php?function=show_insert_form&tablename=people" class="menu_r" target="_blank">Add a New<br>Volunteer</center></a><br><center><a href="/dadabik/index.php?tablename=people&function=search&where_clause=&page=0&order=user_id&order_type=DESC" class="menu_r" target="_new">Modify a Volunteer\'s<br> Information</center></a><br><center><a href="../reports/fam_update.php" class="menu_r">Modify a Volunteer\'s<br>Group ID Number</center></a></div>
    <div class="col"><span class="report_hdr"><center>Change Program Settings</center><br><center><a href="../reports/search_today.php" class="menu_r">*** 1 ***</center></a><br><center><a href="../reports/search_month.php" class="menu_r">*** 2 ***</center></a><br><center><a href="../reports/find_ind.php" class="menu_r">*** 3 ***</center></a></span></div>
    <div class="col"><span class="report_hdr"><center>Other Functions</center><br><center><a href="../reports/vol_class_ttl.php" class="menu_r">*** 1 ***</center></a></span><br>';
if ($login_lvl<0){
  echo '<center><a href="/config/vol_edit.php" class="menu_r">Add or Delete<br>a Volunteer</center></a><br><center><a href="../reports/fam_update.php" class="menu_r">Admin Settings</center></a><br><center><a href="../reports/fam_mbrs.php" class="menu_r">*** 4 ***</center></a></span>';

}
echo '</div>';
?>
