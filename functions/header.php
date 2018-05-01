<?php
session_start();

include (dirname(__DIR__).'/includes/data.php');
echo '<html><head><meta charset="UTF-8"><meta http-equiv="X-UA-Compatible" content="IE=edge"><meta name="viewport" content="width=device-width, initial-scale=1"><title>VIVA</title>
<link href="../css/multiColumnTemplate.css" rel="stylesheet" type="text/css">
<link href="../css/table-style.css" rel="stylesheet" type="text/css">
<!--<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.2/jquery.min.js"></script>
<script type="text/javascript" src="./js/tablesorter/jquery.tablesorter.js"></script>
<script src="sort.js"></script>-->
</head>
<body>
  <div class="container">
    <header>
      <div class="primary_header">
        <h1 class="title">'.$ssn.' Admin Portal</h1><span style="float:center;"><center>';

include ('../admin/admin_nav.php');
echo '</center><span class="login">Signed On: <br>'.$_SESSION['login_name'].'<br>Auth Level: '.$login_lvl.'</span>';
echo '</span></div></header></div>';
?>
