<?php
include('../connect.php');
include('../functions/session.php');
include('../functions/header.php');
if ($login_lvl>=5){
echo '<br><div class="bottom">
    <div class="col"><span class="report_hdr"><center>Volunteer Add / Modify</center></span><br><center><a href="add_vol.php" class="menu_r" >Add a New<br>Volunteer</center></a><br><center><a href="mod_vol.php" class="menu_r">Modify a Volunteer\'s<br> Information</center></a><br><center><a href="edit_hrs.php" class="menu_r">Manually Enter <br>Volunteer Hours</center></a><br>';
}
if ($login_lvl>=8){
    echo '<center><a href="mod_hrs.php" class="menu_r">Modify (Subtract)<br>Volunteer Hours</center></a></div>';
}
if ($login_lvl>=5){
 echo '<div class="col"><span class="report_hdr"><center>Change Program Settings</center><br><center><a href="mod_sub.php" class="menu_r">Modify Volunteer<br>Activity List</center></a><br><center><a href="mod_class.php" class="menu_r">Modify Volunteer<br>Classes</center></a><br><center><a href="a_barcode.php" class="menu_r">Modify Barcodes</center></a></span></div>
    <div class="col"><span class="report_hdr"><center>Other Functions</center><br>';
}
if ($login_lvl>=8){
  echo '<center><a href="del_vol.php" class="menu_r">Delete<br>a Volunteer</center></a><br>';
    echo '<center><a href="del_grps.php" class="menu_r">Delete Family Group<br>and Associated Members</center></a><br><center><a href="a_set.php" class="menu_r">Admin Settings</center></a>';
}
if ($login_lvl==9){
  echo '<br><center><a href="admin_a.php" class="menu_r">Add or Edit<br>an Admin</center></a></span></div></div>';
}
if (($login_lvl==9)or($login_lvl==8)or($login_lvl==5)) {
//back to home page
} else {
header("location: admintest.php");
}
?>
