<?php
//

include('../connect.php');
include('../functions/session.php');
include('../functions/header.php');
$path1='/var/www/html/visitor/files/';
$files = array_values(array_filter(scandir($path1), function($file) {
    return !is_dir($file);
}));
echo '<div style="width:90%;"><center><br><br>';
echo '<a href="folder.php?ex=1">Erase all visible files?</a><br><br>';
if (isset($_GET['ex'])) {
array_map('unlink', glob("/var/www/html/visitor/files/*.pdf"));
header("location: ../functions/folder.php");
}
$t=1;
echo '<table style="width:90%;"><tr>';
foreach($files as $file){
  if ($file!= '.pdf') {
    echo '<td><a href="../files/'.$file.'" target="_new">'.$file.'</a></td>';
if ($t==3) {
  $t=0;
  echo '</tr><tr>';
}
$t++;
}
}
echo '</tr></table>';



?>
