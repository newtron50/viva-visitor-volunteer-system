<?php
echo '<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>VIVA Portal</title>
<link href="install.css" rel="stylesheet" type="text/css">';
echo '<div class="main"><center>';
echo '<div class="install_base" align="left">';
echo '<center><h1>VIVA Visitor program installation helper</h1>';
echo 'STEP 3: Your MYSQL Information</center>';
echo '<p><hr></p>';

echo '<p>All ARE REQUIRED...</p>';
echo '<div style="padding-left:50px;">';
echo '<form action="install3.php" method="post">';
echo '<br>Server address: <input type="text" name="server"></input>  <i>usually</i> localhost   <span class="tooltip" style="position:relative;top:0px;left:8px;z-index:5;"><img src="../images/Help.png"alt="question mark" height="15" width="15">
  <span class="tooltiptext">If you\'ll be connecting to a remote database, specify IP or other routing<br></span></span>';
echo '<br><br>Root or Authorized MYSQL User: <input type="text" name="user"></input>  <span class="tooltip" style="position:relative;top:0px;left:8px;z-index:5;"><img src="../images/Help.png"alt="question mark" height="15" width="15">
  <span class="tooltiptext">Username entered must be granted all privileges including CREATE<br></span></span>';
  echo '<br><br>Password for the user: <input type="text" name="pword"></input>';
  echo '<br><br>Database Name: <input type="text" name="dbname" value="visitor"></input>  <span class="tooltip" style="position:relative;top:0px;left:8px;z-index:5;"><img src="../images/Help.png"alt="question mark" height="15" width="15">
    <span class="tooltiptext"><i>visitor</i> is the default DB name.  Change it if this will cause a conflict.<br></span></span><br><br>';
echo '</div><center><input type="submit" value="NEXT STEP" class="admin_btn"></input></center></form>';



echo '</div></center></div>';




?>
