<?php
$server=$_POST['server'];
$user=$_POST['user'];
$pword=$_POST['pword'];
$dbname=$_POST['dbname'];

$link=mysqli_connect($server,$user,$pword);

if($link===false) {
  die ("ERROR: Could not connect.".mysqli_connect_error());
}
$sql_build="CREATE DATABASE $dbname";
if(mysqli_query($link, $sql_build)){
    echo "Database created successfully";
    $creation_status=1;
} else{
    echo "ERROR: Could not able to execute $sql_build. " . mysqli_error($link);
    $creation_status=0;
}

// Close connection
mysqli_close($link);

$conn = new mysqli($server, $user, $pword, $dbname);
$filename = 'visitor.sql';
$op_data = '';
$lines = file($filename);
foreach ($lines as $line)
{
    if (substr($line, 0, 2) == '--' || $line == '')//This IF Remove Comment Inside SQL FILE
    {
        continue;
    }
    $op_data .= $line;
    if (substr(trim($line), -1, 1) == ';')//Breack Line Upto ';' NEW QUERY
    {
        $conn->query($op_data);
        $op_data = '';
    }
}
echo "Table Created Inside " . $dbname . " Database.......";
// write connect file for database connection

$filename1="../connect.php";
$textdata1="<?php
\$servername = '".$server."';
\$username = '".$user."';
\$password = '".$pword."';
\$dbname = '".$dbname."';
// Create connection to visitor
\$conn = new mysqli(\$servername, \$username, \$password, \$dbname);
// Check connection
if (\$conn->connect_error) {
    die('Connection failed: ' . \$conn->connect_error);
    echo 'The connection failed';
}
?>";
$connectfile=fopen($filename1,'w');
fwrite($connectfile,$textdata1);
fclose($connectfile);

// end writing connect.php


$creation_status=1;

echo '<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>VIVA Portal</title>
<link href="install.css" rel="stylesheet" type="text/css">';



echo '<div class="main"><center>';
echo '<div class="install_base" align="left">';
echo '<center><h1>VIVA Visitor program installation helper</h1>';
if ($creation_status==1) {
echo 'STEP 4: Program Configuration</center>';
} else {
 echo 'UH OH - Something happened.<br>Database not created';
}
echo '<p><hr></p>';
if ($creation_status==1) {
echo '<p>All ARE REQUIRED...</p>';
echo '<form action="install4.php" method="POST">';
echo '<input type="hidden" name="server" value='.$server.'>';
echo '<input type="hidden" name="user" value='.$user.'>';
echo '<input type="hidden" name="pword" value='.$pword.'>';
echo '<input type="hidden" name="dbname" value='.$dbname.'>';
echo '<p>Name of your Organization: <input type="text" name="org" size="40"></input></p>';
echo '<p>A short name or initials of your Organization: <input type="text" name="ssn" ></input></p>';
echo '<p>Initial location of reception/check-in: <input type="text" name="location"></input></p>';
echo '<p>What Guest functions do you want for this program:   <span class="tooltip" style="position:relative;top:0px;left:8px;z-index:5;"><img src="../images/Help.png"alt="question mark" height="15" width="15"><span class="tooltiptext"> You can limit the menus & operation depending on the needs of your organization<br></span></span><br><br><input type="radio" name="fc" value="2"> Visitors Only (No Volunteers)<br><input type="radio" name="fc" value="1"> Volunteers Only (no Visitors)<br><input type="radio" name="fc" value="3"> VISITORS AND VOLUNTEERS</p>';
echo '<p>Have Volunteers register themselves?:   <span class="tooltip" style="position:relative;top:0px;left:8px;z-index:5;"><img src="../images/Help.png"alt="question mark" height="15" width="15"><span class="tooltiptext"> Having volunteers register themselves can cause group tracking issues. Only recommended if group tracking will not be used.<br></span></span><br><br><input type="radio" name="avm" value="1" checked="Yes"> Desk / Admins add Volunteers<br><input type="radio" name="avm" value="2"> Volunteers register themselves</p>';
echo '<p>Volunteer Group Tracking:  <span class="tooltip" style="position:relative;top:0px;left:8px;z-index:5;"><img src="../images/Help.png"alt="question mark" height="15" width="15"><span class="tooltiptext"> Highly recommend to DISABLE if volunteers will register themselves<br></span></span><br><br><input type="radio" name="gpf" value="1"> Vol. Group tracking ENABLED<br><input type="radio" name="gpf" value="0"> Vol. Group tracking DISABLED</p>';
echo '<p>Barcode & Badges:  <span class="tooltip" style="position:relative;top:0px;left:8px;z-index:5;"><img src="../images/Help.png"alt="question mark" height="15" width="15"><span class="tooltiptext">Choose between fixed ID cards (barcodes must be registered with the system) or badges printed with label printers<br></span></span><br><br><input type="radio" name="bc" value="1"> Use fixed barcodes - ID cards<br><input type="radio" name="bc" value="2"> Printed Labels at time of check-in</p>';
echo '<div style="padding-left:50px;">';
} else {
  //// problems with the database
}
echo '</div><center><input type="submit" value="FINAL STEP" class="admin_btn"></input></center></form>';



echo '</div></center></div>';




?>
