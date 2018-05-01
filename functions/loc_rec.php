<?php
include($_SERVER['DOCUMENT_ROOT'].'/visitor/connect.php');
//record login
$uname=$myusername;
$log_rec="INSERT INTO login_record
  (username,status,ip_addr) VALUES ('$uname','$status','$line')";
if(($conn->query($log_rec)=== TRUE) ){
//success
}

?>
