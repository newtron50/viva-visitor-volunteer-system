<?php
include (dirname(__FILE__).'/includes/guest_header.php');
echo '  <br><br>
    <p style="text-align:center;font-size:28px;"> Please scan your badge now</p>
    <br><br>
    <div style="text-align:center;">
    <form action="checkout.php" method="GET">
    <input name="barcode" type="text" autofocus>
    <input type="submit" name="submit" hidden>
    </form>
  </div>';
?>
