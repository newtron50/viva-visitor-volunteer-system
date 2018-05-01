<?php
include('../connect.php');
include('../functions/session.php');
include('../functions/header.php');
if ($login_lvl>=5){
$barq=<<<SQL
  SELECT * FROM barcodes
SQL;

  if (isset($_POST['m'])) {
$sta= $_POST['p'];
    if ($sta==2) {
    // add or delete Barcodes
echo $_POST['p'];
    echo '<div class="centerred"><center><br><br>';
  echo '<h3>Delete a Barcode from the System</h3>';
$code=$_POST['bar'];
echo $code.'<br><br>';
echo '<a href="../functions/m_bar.php?c='.$code.'&f=d" class="g_bubble">Delete the barcode?</a><span class="space"></span><a href="a_barcode.php" class="g_bubble">Cancel</a>';

echo '</center></div>';
} else {
  //add barcode
  echo '<div class="centerred"><center><br><br>';
echo '<h3>Add a Barcode to the System</h3>';
echo 'type the barcode number in or use the scanner to add<br>';
echo '<span style="color:gray;font-size:12px">Make sure to scan a compatible barcode type<br><br>';

echo $code.'<br><br>';
echo '<form action="../functions/m_bar.php" method="post"><input type=hidden name=k value="n">
      Barcode <input name="new_b" type="text" autofocus/><br><br><br>
<input type="submit" style="border-radius:8px;box-shadow: 4px 6px 9px -4px #088018;height:40px;align:center;width:100px;border:1px;background-color:gray;font-size:18px;" >';



echo '<span class="space"></span><a href="a_barcode.php" class="g_bubble">Cancel</a>';
echo '</center></div>';
}
  } else {

      echo '<div class="centerred"><center><br><br>';
      echo '<h3>Add or Delete a Fixed Barcode/ID from the System</h3>';
      echo '<br><br>';
      if(!$bar1 = $conn->query($barq)){
          die('There was an error running the query [' . $conn->error . ']');
        }
      echo '<form action="a_barcode.php" method="post"><input type=hidden name=m value="y"><table class="rpt_table_sm"><th>Barcode</th><th>Status</th>';
      while ($bar = $bar1->fetch_assoc()){
          echo '<tr><td><input name="bar" type="checkbox" value="'.$bar['barcode'].'"/>  '.$bar['barcode'].'</td><td>';
          $status=$bar['status'];
          if ($status==0) {
            echo 'Not in use</td></tr>';
          } else {
            echo 'In Use</td><tr>';
          }
      }
echo '</table><button name="p" value="2" type="submit" class="g_bubble" >Delete</button><span class="space"></span><button name="p" value="3" type="submit" class="g_bubble" >Add</button></form><br><br><a href="../admin/settings.php" class="g_bubble"> Settings Menu</a>';


}
//end of code
} else {
//back to home page
header("location: admintest.php");
}
?>
