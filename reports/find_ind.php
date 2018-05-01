<?php
include('../connect.php');
include('../functions/session.php');
include('../functions/header.php');
if (empty($_GET['l'])) {
if (empty($_POST['lname'])) {
echo '<br>';
echo '<div class="report_hdr"><center>Search a Visitor by Name</center></div>';
echo '<div>
    <h3 style="text-align:center">Please enter the following:</h3>
    <div id="left_article"><br>
<form action="find_ind.php" method="post">
<table border="0" cellpadding="3" cellspacing="3" align="center">
    <tr><td>Last Name: <input name="lname" type="text" /autofocus></td></tr>

    <tr><td>First Name: <input name="fname" type="text" /></td></tr>
  </table>
    <br><br>
  </div><center>
            </div>
</div><center>
<input type="submit" class="n_bubble" ></center><br><br></div>';



echo '<hr {
    display: block;
    margin-top: 0.5em;
    margin-bottom: 0.5em;
    margin-left: auto;
    margin-right: auto;
    border-style: inset;
    border-width: 1px;

}>';
} else {
$lname= $_POST['lname'];
$fname= $_POST['fname'];



$sql=<<<SQL
  SELECT distinct last_name, first_name, user_id from record_log
  where last_name
  like '$lname%' and
  first_name like '$fname%'
SQL;
if(!$result = $conn->query($sql)){
    die('There was an error running the query [' . $conn->error . ']');
}

echo '<br><div style="background-color:#eaeaea;"><center> Please verify the following information</center></div>';
$x=0;
echo "<center>";

while($row=$result->fetch_array()){ //number of rows
echo '<a href="find_ind.php?l='.$row['first_name'].'&n='.$row['last_name'].'""><p class="n_bubble">&nbsp;&nbsp;'.$row['first_name'].' '.$row['last_name'].'&nbsp;&nbsp;</p></a>';
echo '<br><br>';
$x++;
}
echo "</center>";
if (empty($row['user_id'])) {
  echo '<br><center>'.$x.' Users Found <a href="./find_ind.php" class="n_bubble">&nbsp;&nbsp;&nbsp; Try Again&nbsp;&nbsp;  </a></center>';
}

}
} else {
$l = $_GET['l'];
$n = $_GET['n'];
//display record log for individual
$sql1=<<<SQL
select concat(r.first_name,' ',r.last_name) as name,
r.reason, r.code_in,r.code_out, r.vol_class, v.v_class_name from record_log as r
inner join volunteer_classes as v on v.id = r.vol_class
  where last_name = '$n' and first_name = '$l'
  ORDER BY r.code_out DESC
SQL;
if(!$result1 = $conn->query($sql1)){
    die('There was an error running the query [' . $conn->error . ']');
}
$x=0;

echo '<div class="centered"><center>';
while($row=$result1->fetch_array()){ //number of rows
if ($x== 0) {
echo '<br><table class="rpt_table_2">
<th><span style="font-size:16px;">'.$row['name'].'</span></th><th>Reason for Visit</th><th>Sign In</th><th>Sign Out</th>';
}

//change for readable date entry
$btime=$row['code_in'];
$ctime=$row['code_out'];
$time= strtotime($btime);
$monthcode = date( 'M-d-Y', $time );
$j_time=substr($ctime, 11,5);
$k_time= substr($btime, 11,5);
echo '<tr><td>'.$monthcode.'</td><td>'.$row['reason'].'</td><td>'.$j_time.'</td><td>'.$k_time.'</td></tr>';
$x++;
}
echo '</table></center></div><br><center> <a href="find_ind.php">Search Again</center></a>';
}
?>
