<?php
 include (dirname(__FILE__).'/includes/guest_header.php');

$nnn=$_GET['n'];
$error='<span style="color:red;font-size:16;">Please enter a 10 digit number -- ONLY NUMBERS please</span>';
if ($nnn==1) {
 echo '<h2 class="noDisplay">Main Content</h2>

      <h3 style=text-align:center>Thanks for Visiting again!</h3>

        <div>
          <h3 style="text-align:center">Please enter the following:</h3>
          <div id="left_article">
      <br>
<form action="n_visit_verify.php" method="post">
    <table border="0" cellpadding="3" cellspacing="3" align="center">
          <tr><td>Last Name: <input name="lname" type="text" autofocus></td></tr>

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
} else {
  echo '<h2 class="noDisplay">Main Content</h2>

       <h3 style=text-align:center>Thanks for Visiting again!</h3>

         <div>
           <h3 style="text-align:center">Search for your information by phone number:</h3>';
if (isset($_GET['check'])) {
echo '<center><h2>'.$error.'</h2></center>';
}
echo '<div id="left_article">
       <br>
 <form action="p_visit_verify.php" method="post">
     <table border="0" cellpadding="3" cellspacing="3" align="center">
           <tr><td>Phone Number: <input name="phone" type="text" /autofocus></td></tr>
         </table>
           <br><br>
         </div><center>
                   </div>
 </div><center>
   <input type="submit" class="n_bubble" ></center><br><br>
 <br><br>
 <center><br><br>
 <a href="./visit_class.php" class="return">Return to Previous Page</a>
 </center>';
}


?>
