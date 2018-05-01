<?php
include (dirname(__FILE__).'/includes/data.php');
include (dirname(__FILE__).'/includes/guest_header.php');
if (isset($_GET['check'])){
$error= "ERROR :: Please enter a 10 digit phone number or pin: no - . , ()";
} else {
  $error = " ";
}
if ($avm==1) {
 echo '
      <h2 style=text-align:center>If you\'ve never a volunteer here<br>Please provide your information to the person at the '.$location.'.</h2>
        <div>
          <h3 style="text-align:center">Enter the following when prompted:</h3>
          <div id="left_article">
            <form action="repeat_verify.php" method="post">
              <div id="right_article">
                <table border="0" cellpadding="3" cellspacing="3" align="center">
                <tr><td>Phone Number / PIN: <input name="cellphone" type="text" autofocus=/></td></tr>
              </table>
<p style=text-align:center;background-color:#D1DBDE;font-weight:bold;color:red;>'.$error.'</p></p><br><br></div><center></div></div><center>
  <input type="submit" class="n_bubble" ></center><br><br>
<br><br>
<center><br><br>';
} else {
include (dirname(__FILE__).'/functions/add_vol.php');
}
echo '
<a href="./main-visit.php" class="return">Return to Main Page</a>
</center>';
?>
