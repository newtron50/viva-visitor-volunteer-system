<?php
if (isset($_GET['check'])){
$error= "ERROR :: Please enter a 10 digit phone number or pin: no - . , ()";
} else {
  $error = " ";
}
include (dirname(__FILE__).'/includes/guest_header.php');
echo '<h3 style=text-align:center>Thanks for volunteering again!</h3>
        <p style="background-color:#6AFF57;font-size:20px;color:black;font-weight:bold;text-align:center"><u><i>Please don\'t forget to scan your barcode before you leave the building.</u></i></p>
        <div>
          <h3 style="text-align:center">Please enter the following:</h3>
          <div id="left_article">
            <form action="repeat_verify.php" method="post">
              <div id="right_article">
                <table border="0" cellpadding="3" cellspacing="3" align="center">
                <tr><td>Phone Number / PIN: <input name="cellphone" type="text" autofocus=/></td></tr>
              </table>
          <p><p style=text-align:center;background-color:#D1DBDE;font-weight:bold;color:red;>'.$error.'</p></p>

          <br><br>
        </div><center>
                  </div>
</div><center>
  <input type="submit" class="n_bubble" ></center><br><br>
<br><br>
<center><br><br>
<a href="./repeat_search.php" class="return">Return to Previous Page</a>
</center>';
?>
