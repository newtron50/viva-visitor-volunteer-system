<?php
include ('../functions/header.php');
include('../connect.php');
include('../functions/session.php');

if(isset($_GET['vol_typ'])){
$r_vol_type=$_GET['vol_typ'];
$r_time=$_GET['tyme'];

include (dirname(__FILE__).'/includes/fam_grp_list.php');


} else {

echo '<br><div class="bottom">
    <div class="col"><span class="report_hdr"><center>Individual Reports</center></span><br><br><center><a href="./ind_total.php">Individual\'s Total<br>Volunteer Hours</center></a></div>
    <div class="col"><span class="report_hdr"><center>Family Group Reports</center></span></div>
    <div class="col"><span class="report_hdr"><center>Volunteer Class Reports</center><br><br><center><a href="./vol_class_ttl.php">Total Hours for<br>All Vol. Classes</center></a></span></div>
</div>';
}
?>
