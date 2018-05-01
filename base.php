<?php
session_start();
include (dirname(__FILE__).'/includes/data.php');
echo '<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>VIVA Portal</title>
<link href="css/multiColumnTemplate.css" rel="stylesheet" type="text/css">
</head>
<body>
<div class="container">
  <header>
    <div class="primary_header">
      <h1 class="title">'.$school_name.' Visitor Program</h1>
      <h3 style="text-align:center;color:white;"> Please choose your login</h3><br><br>
      <p style="text-align:center;">
      <a href="index.php" class="badge" style="margin-left:-200px;">Administrator</a>
      <a href="./main.php" class="badge3">User Portal</a>
    </p>
    </div>
</header>
  <section>
    <h2 class="noDisplay">Main Content</h2>
    <article class="left_article">

</article>
</section>

<div class="column_half right_half"> </div>
  </div>
    <div class="row blockDisplay">

</div>';
?>
