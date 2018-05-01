<?php
// save sql files and download for user_id


include('../connect.php');
include('../functions/session.php');


$filename = "backup-" . date("d-m-Y") . ".sql";
$mime = "application/octet-stream";

header( "Content-Type: " . $mime );
header( 'Content-Disposition: attachment; filename="' . $filename . '"' );

$cmd = "mysqldump -u $username --password=$password visitor ";

passthru( $cmd );

exit(0);


?>
