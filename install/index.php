<?php
echo '<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>VIVA Portal</title>
<link href="install.css" rel="stylesheet" type="text/css">';
echo '<div class="main"><center>';
echo '<div class="install_base" align="left">';
echo '<center><h1>VIVA Visitor program installation helper</h1>';
echo 'The following pages will help install the program for you.</center>';
echo '<p><hr></p>';
echo '<br><h3>The following are requirements for a successful installation:</h3>';
echo '<p>You should feel comfortable working within a server environment or using pre-packaged distribution such as a flavor of Linux or installing LAMP, MAMP, XXAMP. </p>';
echo '<ul>';
echo '<li>Web Server</li>';
echo '<ul>';
echo '<li>Apache2 : Tested</li>';
echo '<li>Nginx : Untested</li>';
echo '<li>Lighttpd : Untested</li>';
echo '</ul></ul>';
echo '<ul><li>PHP Software</li>';
echo '<ul><li>PHP4.0 : Tested</li>';
echo '<li>PHP5.0 - 7.0.2: Tested</li>';
echo '</ul></ul>';
echo '<ul><li>MYSQL Software</li>';
echo '<ul><li>MYSQL 5 - 5.6:  Tested</li>';
echo '<li>MYSQL 5.7+: Tested but needs sql_mode change<br>&nbsp;&nbsp;remove sql_mode ONLY_FULL_GROUP_BY<br>&nbsp;&nbsp;see instructions</li>';
echo '<li>MARIA:  Untested</li>';
echo '<li>POSTGRES : NO</li></ul></ul>';
$b = is_writable( "../includes" ); //boolean value
echo '<br><br>The /includes directory needs to be writable:  ';
if ($b==true) {
  echo '<img src="../images/green.png" width="15px">  Good to go!';
} else {
  echo '<img src="../images/red.png" width="15px">  Oops - change folder permissions';
}

$c = is_writable( "../" ); //boolean value
echo '<br><br>The /main directory needs to be writable:  ';
if ($c==true) {
  echo '<img src="../images/green.png" width="15px">  Good to go!';
} else {
  echo '<img src="../images/red.png" width="15px">  Oops - change folder permissions';
}

if ($b==true && $c==true) {
echo '<br><br><br><br><center><a href="install1.php" class="admin_btn">Next Step</a></center>';
} else {
  echo '<br><br><br><br><center><a href="index.php" class="admin_btn">Set Folder permissions and Recheck</a></center>';
}

echo '</div></center></div>';




?>
