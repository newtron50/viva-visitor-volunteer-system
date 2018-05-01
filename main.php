<?php
session_start();
include (dirname(__FILE__).'/includes/data.php');
include (dirname(__FILE__).'/functions/clr.php');
include (dirname(__FILE__).'/includes/data.php');
echo '<html>
<head>
<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>VIVA</title>
<link href="./css/multiColumnTemplate.css" rel="stylesheet" type="text/css">
</head>
<body>
<div class="container">
  <header>
    <div class="primary_header">
      <h2 class="title">Welcome to '.$school_name.'</h2>
    </div>';

echo '</div></header></div></body>';

echo '<br>  <p style="color:black;font-size:24px;text-align:center;">For the security and safety of all,<br>we require that you sign in and out using our digital visitor system.</p>
    <h2 class="noDisplay">Main Content</h2>';



if ($fc==1) { //volunteer only
  echo '<br><br><br><center><a href="./vol_class.php" class="badgeY" style="display:inline-block;color:white;"><br>Start your '.$ssn.' visit here<br>&nbsp;</a><span class="space"></span>&nbsp&nbsp&nbsp&nbsp';
} elseif ($fc==2) {  // visitor only
  echo '<br><br><br><center><a href="./visit_class.php" class="badgeY" style="display:inline-block;color:white;"><br>Start your '.$ssn.' visit here<br>&nbsp;</a><span class="space"></span>&nbsp&nbsp&nbsp&nbsp';
} else {  // both classes
  echo '<br><br><br><center><a href="./main-visit.php" class="badgeY" style="display:inline-block;color:white;"><br>Start your '.$ssn.' visit here<br>&nbsp;</a><span class="space"></span>&nbsp&nbsp&nbsp&nbsp';
}
echo '<a href="./scanout.php" class="badgeN" style="display:inline-block;color:white;"><center>End your '.$ssn.' visit <br>SCAN BADGE NOW<form action="checkout.php" method="GET">
<input name="barcode" type="text" autofocus>
</form></center></a><br><br><br><br><br><br>
<div style="text-align:center;">
<a href="./base.php" style="font-size:24px;">Return to Main Page</a>
</div>';
?>
