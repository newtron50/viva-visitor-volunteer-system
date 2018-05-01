<?php
session_start();
include (dirname(__FILE__).'/data.php');
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
      <h2 class="title">Welcome '.$ssn.' Visitor</h2>
    </div>';

echo '</div></header></div></body>';
?>
