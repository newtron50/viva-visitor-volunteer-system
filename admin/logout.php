<?php

   session_start();

   if(session_destroy()) {
      header("Location: ../index.php");
   }

?>
<html>
<head>
<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>VIVA</title>
<link href="./css/multiColumnTemplate.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="js/modernizr.custom.29473.js"></script>
</head>
<body>
  <div class="container">
    <header>
      <div class="primary_header">
        <h1 class="title">Welcome to <?php echo $short_name; ?></h1>
        <p> You have been logged out </p>
        <p style="align:center;">Please close your browser or<a href="../index.php" class="return">  Return to the Main Menu</a>
        </header>
        </div
        </body>
        </html>
