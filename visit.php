<?php
include (dirname(__FILE__).'/includes/guest_header.php');
$err=0;
if (isset($_GET['check'])){
$error= "ERROR :: All fields are required - only numbers for phone";
$err=1;
} else {
  $error = " ";
}


echo '
<div class="centered" style="width:90%;">

        <div style="background-color:#DCE3E6;padding:5px;padding-left:50px;color:black;font-size:16px;">
        <p>The process is simple:<br>
        <ul>
        <li>Enter the requested inforamtion</li>
        <li>Verify that the information is correct</li>
        <li>Receive a visitor\'s badge from the desk</li>
        <li>Scan the barcode on the badge</li>
        <li>Before you leave, return the badge to the office, scan it and you\'re done!</li>
        </ul></p>
      </div>
        <div style="text-align:center;>
          <p class="green">Please enter the following:</p>
          <p id="required"> all fields are required</p>
          <form action="new_visit.php" method="post">
          <table border="0" cellpadding="3" cellspacing="3" align="center">
        <tr><td>First Name: </td><td><input name="fname" type="text" autofocus/></td></tr>
        <tr><td>Last Name:</td><td><input name="lname" type="text" /></td></tr>
        <tr><td>Reason for Visit: </td><td><input name="reason" type="text" placeholder="reason for visit"/></td></tr>
        <tr><td>Cellphone Number: </td><td><input name="cell" type="text" placeholder="digits only"/></td>
        </tr>
      </table>
      <p><center>';
      echo '<span style="color:red">'.$error.'</span>';
      echo '</center></p>

<br>
      <input type="submit" class="n_bubble" ></center><br><br>

              </div>


</section>
  <div class="row">

</div>
  <div class="row blockDisplay">
<div class="column_half right_half"> </div>
  </div>
<!--<footer class="secondary_header footer">
    <div class="copyright">&copy;2016 - <strong>St John the Apostle Catholic School</strong></div>
    <center>
    <a href="./main2.html" style="color:#BBBCBD;">Return to the Main menu</a>
  </footer>-->
  <center><br><br>
  <a href="./main.php" class="return">Return to Main Page</a>
</center>
</div>';
?>
