<?php
include ('../functions/header.php');
echo '<br>';
echo '<div class="report_hdr"><center>Individual Volunteer Report</center></div>';
echo '<div>
    <h3 style="text-align:center">Please enter the following:</h3>
    <div id="left_article"><br>
<form action="ind_ttl_verify.php" method="post">
<table border="0" cellpadding="3" cellspacing="3" align="center">
    <tr><td>Last Name: <input name="lname" type="text" /autofocus></td></tr>

    <tr><td>First Name: <input name="fname" type="text" /></td></tr>
  </table>
    <br><br>
  </div><center>
            </div>
</div><center>
<input type="submit" class="n_bubble" ></center><br><br></div>';

?>
