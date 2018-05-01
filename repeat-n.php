<?php
if (isset($_GET['check'])){
$error= "ERROR :: Please enter both a first name and a last name";
} else {
  $error = " ";
}
 include (dirname(__FILE__).'/includes/guest_header.php');
 echo '<h2 class="noDisplay">Main Content</h2>

      <h3 style=text-align:center>Thanks for volunteering again!</h3>
        <center><p style="width:80%;background-color:#FF9C9C;font-size:20px;color:black;font-weight:bold;text-align:center"><u><i>Please don\'t forget to scan your barcode before you leave the building.</u></i></p></center>
        <div>
          <h3 style="text-align:center">Please enter the following:</h3>
          <div id="left_article">
      <br>
<form action="repeat_verify-n.php" method="post">
    <table border="0" cellpadding="3" cellspacing="3" align="center">
          <tr><td>Last Name: <input name="lname" type="text" /autofocus></td></tr>

          <tr><td>First Name: <input name="fname" type="text" /></td></tr>
        </table>
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
