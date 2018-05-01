<?php
session_start();
include("./includes/data.php");
//get global variables
$l_name= $_SESSION['l_name'];
$f_name= $_SESSION['f_name'];
$phone= $_SESSION['phone'];
$u_id = $_SESSION['user_id'];
$v_type=$_SESSION['v_type'];

$_SESSION['bctype']=$bctype;

echo "<link href=\"./css/multiColumnTemplate.css\" rel=\"stylesheet\" type=\"text/css\">";
include (dirname(__FILE__).'/includes/guest_header.php');
if ($bctype ==1) {
if (isset($_GET['check'])) {
  $used = 'Barcode Error -- Please try another badge';
    echo '<center><p class="red" style="width:90%;">'.$used.'</p></center>';
} else {
if ($v_type == "VIS"){
  $badge_type = "VISITOR";
  $reason = $_SESSION['reason'];
  $vol_class=0;
} else {
  $badge_type = "VOLUNTEER";
  $reason=$_GET['vol_sub'];
  $vol_class=$_GET['vol_class'];
}
$_SESSION['reason']=$reason;
$_SESSION['v_class']=$vol_class;
}


// *  testing class & reason **  echo '1'.$_GET['vol_sub'].' 2'.$_SESSION['reason'].' 3'.$reason.' badge_type '.$badge_type;
echo '
<center><div class="green" style="width:90%;"> Please get a badge and scan your barcode now</div></center><br><br><br>';
// testing echo '<br>'.$_SESSION['reason'].'<br>';
echo '</div><br><br><center><form action="scanned.php" method="GET">
<input name="barcode" type="text" autofocus>
</form>';
} else { //barcode generated for label printer using timecode
  if ($v_type == "VIS"){
    $badge_type = "VISITOR";
    $reason = $_SESSION['reason'];
    $vol_class=0;
  } else {
    $badge_type = "VOLUNTEER";
    $reason=$_GET['vol_sub'];
    $vol_class=$_GET['vol_class'];
  }
  $_SESSION['reason']=$reason;
  $_SESSION['v_class']=$vol_class;
    // bctype ==2   Generate on the fly for label badges
$date = date_create();
$bubba1= date_timestamp_get($date);

echo '<center><br><br><br>'.$bubba1;
$_SESSION['flxcode']=$bubba1;
echo '<br>'.date('m/d/Y H:i:s',$bubba1).'</center>';
//echo '<a href="bartest.php?t='.$bubba1.'" target="_blank">Get Badge</a>';
echo "<script src='Print.js/print.min.js'></script>";
echo "<script type='text/javascript'>
function printPdf() {
    printJS('bartest.php?t=".$bubba1."');

}
function boogie() {
  setTimeout(function() { window.location.replace('./scanned.php')},4000);
  }

</script>";
echo "<center><h2>Generate your ".$badge_type." badge</h2><br><br>";
echo "<button onClick='printPdf();boogie();' class='admin_btn'>Generate!</button>";



}
?>
