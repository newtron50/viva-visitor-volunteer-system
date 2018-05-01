<?php
$server=//$_POST['server'];
$user=//$_POST['user'];
$pword=//$_POST['pword'];
$dbname=//$_POST['dbname'];

$org=$_POST['org'];
$ssn=$_POST['ssn'];
$location=$_POST['location'];
$bc=$_POST['bc'];
$fc=$_POST['fc'];
$avm=$_POST['avm'];
$gpf=$_POST['gpf'];
$filename="../includes/data.php";
$textdata="<?php
////   Program data info

\$ssn='".$ssn."';
\$school_name='".$org."';
\$location='".$location."';
\$loc_id = 'a';

/* edit barcode type
    1 = fixed (reusable, original)
    2 = generated for label use
*/
\$bctype = ".$bc.";

/* Program limitations - var \$fc
 1 = Volunteers Only
 2 = Visitors Only
 3 = Visitors and Volunteers
*/

\$fc=".$fc.";
/* have volunteers add themselves?
-- This is not recommended as group volunteer tracking can
get easily messed up with group assignments

\$avm = 1  ... added by administrative desk
\$avm = 2  ... added by volunteers themselves (self registration)
*/

\$avm = ".$avm.";

/* Group functions --
Highly recommended if using volunteers to register themselves to turn off this function.
Decides whether to help track voluteering by groups
\$gpf=1  --  group functions on
\$gpf=0  --  group functions off
*/

\$gpf=".$gpf.";


?>";
$patfile=fopen($filename,'w');
fwrite($patfile,$textdata);
fclose($patfile);

echo '<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>VIVA Portal</title>
<link href="install.css" rel="stylesheet" type="text/css">';
echo '<div class="main"><center>';
echo '<div class="install_base" align="left">';
echo '<center><h1>VIVA Visitor program installation helper</h1>';

echo 'STEP 5: You\'re Done</center>';
echo '<p><hr></p>';

echo '<p>For security purposes - make sure to delete the /install folder and all files inside of it.</p>';
echo '<p>Now navigate to your installation. The initial log in credentials are:</p>';
echo '<p>Username: admin<br>Password: password</p>';
echo '<p>You can delete this user and create your own within the admin portion of the program.</p>';
echo '<br><a href="../index.php">Log in to your Visitor Program to finish your administrative setup</a><br>';

echo '</div><center><a href="https://sourceforge.net/p/viva-visitor/discussion/?source=navbar">Questions or more? Visit the forum... otherwise - off ya go!</a></center></form>';



echo '</div></center></div>';




?>
