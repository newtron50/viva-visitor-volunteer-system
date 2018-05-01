<?php
include('../connect.php');
include('../functions/session.php');
include('../functions/header.php');
if ($login_lvl>=5){

if (isset($_GET['f'])) {

///  delete the code
$code =$_GET['c'];
$del_code = "DELETE from barcodes where barcode = $code";
if(($conn->query($del_code)=== TRUE) ){
echo '<div class="centerred"><center><br><br>';
echo '<h3>Barcode '.$new_b.' has been deleted.</h3><br>';
} else {
  echo 'ERROR deleting barcode';
}
echo '<a href="../admin/settings.php" class="g_bubble"> Settings Menu</a>';
} elseif (isset($_POST['k'])) {
/// add a barcode
$new_barcode=$_POST['new_b'];
$new_b = "INSERT INTO barcodes (barcode,status) VALUES ($new_barcode,0)";
if(($conn->query($new_b)=== TRUE) ){
echo '<div class="centerred"><center><br><br>';
echo '<h3>Barcode '.$new_barcode.' has been added.</h3><br>';
} else {
  echo 'ERROR deleting barcode';
}
echo '<a href="../admin/settings.php" class="g_bubble"> Settings Menu</a>';

}
unset($new_barcode);
unset($new_b);
unset($code);
} else {
  //back to home page
  header("location: admintest.php");
}
?>
