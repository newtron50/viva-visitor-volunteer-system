
<head>
<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>VIVA</title>
<link href="css/multiColumnTemplate.css" rel="stylesheet" type="text/css">
</head>
<body>
<div class="container">

    <h2 class="noDisplay">Main Content</h2>

      <h3 style=text-align:center>Important Information</h3>
      <p style=color:black;font-size:18px>For the security and safety of all on our campus, we require that you sign in and out using our digital system.</p>
      <blockquote>
        <p style=background-color:#6DC23C;color:black;font-size:16px>The process is simple:<br>
        <ul>
        <li>Enter the requested inforamtion</li>
        <li>Verify that the information is correct</li>
        <li>Receive a visitor's badge from the desk</li>
        <li>Scan the barcode on the badge</li>
        <li>Go make a difference!</li>
        </ul></p>
        <p style="background-color:#6DC23C;font-size:18px;color:black;font-weight:bold"><u><i>Please don't forget to scan your barcode before you leave the building.</u></i></p>
        <div style='text-align:center;'>
          <h3>Please enter the following:</h3>
<?php
          if ($_POST['fname'] == "") {
            $_POST['fname'] = filter_var($_POST['name'], FILTER_SANITIZE_STRING);
            if ($_POST['fname'] == "") {
                $errors .= 'Please enter a valid first name.<br/><br/>';
            }
          }
          if ($_POST['lname'] == ""){
            $_POST['lname'] = filter_var($_POST['name'], FILTER_SANITIZE_STRING);
            if ($_POST['lname'] == "") {
                $errors .= 'Please enter a valid last name.<br/><br/>';
            }
          }
            if ($_POST['email'] != "") {
              $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
              if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                  $errors .= "$email is <strong>NOT</strong> a valid email address.<br/><br/>";
          } else {
              $errors .= 'Please enter your email address.<br/>';
          }
          }
          if ($_POST['phone'] == ""){
            $_POST['phone'] = filter_var($_POST['name'], FILTER_SANITIZE_NUMBER_INT);
            if (($_POST['phone'] == "") or (strlen($_POST['phone'])) != '10' ){
                $errors .= 'Please enter a valid phone number.<br/><br/>';
            }
          }
?>
          <form action="new_visit.php" method="post">
              <table border='0' cellpadding='3' cellspacing='3' align="center">
                <tr><td>First Name: </td><td><input name="fname" type="text" /></td></tr>
                <tr><td>Last Name: </td><td><input name="lname" type="text" /></td></tr>
                <tr><td>Email: </td><td><input name="email" type="text" /></td></tr>
                <tr><td>Phone Number or PIN: </td><td><input name="phone" type="text" /></td></tr>
              </table>
                <br>
                  <p style='color:blue;font-size:14px;text-align:center'>If you want to enter a personal PIN number instead of your<br>
                    phone number, enter a 10 digit number beginning with 999</p>
                <br>
                  <input type="submit" style="border-radius:16px;box-shadow: 4px 6px 9px -4px #088018;height:60px;align:center;width:100px;border:1px;background-color:#08A61D;font-size:18px;" ></center><br><br>
        </div>
      </blockquote>

  <div class="row">

</div>
  <div class="row blockDisplay">
<div class="column_half right_half"> </div>
  </div>
<footer class="secondary_header footer">
    <div class="copyright">&copy;2016 - <strong>St John the Apostle Catholic School</strong></div><center>
    <a href="./main2.html" style="color:#BBBCBD;">Return to the Main menu</a></center>
  </footer>
</div>
</body>
