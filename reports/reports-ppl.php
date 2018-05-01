<?php
include('../connect.php');
include('../functions/session.php');
session_start();

$sql=<<<SQL
 select * from
 people
SQL;
$data = array();
if(!$result = $conn->query($sql)){
    die('There was an error running the query [' . $conn->error . ']');
}
while($row=$result->fetch_array()){
$data[] =$row;
//  echo $row['record_num'].' '.$row['user_id'].' '.$row['last_name'].' '.$row['first_name'].' '.$row['email'].' '.$row['phone'].' '.$row['cell'].' '.$row['vol_type'].' '.$row['family_grp'];
//echo "<br>";
}

$school=$_SESSION['school'] ;
$url=$_SESSION['url'];
$short_name =$_SESSION['school_short'] ;
//echo '<br><br>test<br>';
//echo $data[5][3];

?>
<html>
<head>
<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>VIVA</title>
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
        <h1 class="title">Welcome to <?php echo $short_name; ?> Admin Portal</h1>
        <?php
      include('../admin/admin_nav.php');
?>
<div id="sho_login">Nathan Shaffer ::  Super Admin</div>
      </div>
  </header>
</div>
<br><br>
<p style='text-align:center;font-size:12px;text-style:italic;'>Sort Lists by clicking on bold title names</p>
<div class="reports">

  <?php
  include('../connect.php');
$field='last_name';
$sort='ASC';
// try the php sorting
if(isset($_GET['sorting']))
{
  if($_GET['sorting']=='ASC')
  {
  $sort='DESC';
  }
  else
  {
    $sort='ASC';
  }
}
if($_GET['field']=='user_id')
{
   $field = "user_id";
}
elseif($_GET['field']=='last_name')
{
   $field = "last_name";
}
elseif($_GET['field']=='first_name')
{
   $field="first_name";
}
elseif($_GET['field']=='family_grp')
{
   $field="family_grp";
}
$sql = "SELECT user_id, first_name, last_name, phone, cell, email, family_grp FROM people ORDER BY $field $sort";
if(!$result = $conn->query($sql)){
    die('There was an error running the query [' . $conn->error . ']');
}
echo '<table id="table" class="tablesorter"><thead><tr>';

//end
echo  '<th><a href="reports-ppl.php?sorting='.$sort.'&field=user_id">User</a></th>';
echo  '<th><a href="reports-ppl.php?sorting='.$sort.'&field=last_name">Last Name</a></th>';
echo  '<th><a href="reports-ppl.php?sorting='.$sort.'&field=first_name">First Name</a></th>';
echo '<th>Phone</th>';
echo '<th>Cell</th>';
echo '<th>Email</th>';
echo  '<th><a href="reports-ppl.php?sorting='.$sort.'&field=family_grp">Fam Group</a></th>';
echo '</tr></thead><tbody>';


while($row=$result->fetch_array()){ //number of rows
echo '<tr>';
echo '<td>'.$row['user_id'].'</td>'.'<td>'.$row['last_name'].'</td>'.'<td>'.$row['first_name'].'</td>';

//make phone readable
if ($row['phone'] != 0) {
$area=substr($row['phone'],-10,3);
$pre=substr($row['phone'],-7,3);
$last4=substr($row['phone'],-4,4);
echo '<td>('.$area.') '.$pre.'-'.$last4.'</td>';
} else {
  echo '<td> none</td>';
}
if ($row['cell'] != 0) {
$area=substr($row['cell'],-10,3);
$pre=substr($row['cell'],-7,3);
$last4=substr($row['cell'],-4,4);
echo '<td>('.$area.') '.$pre.'-'.$last4.'</td>';
} else {
    echo '<td> none</td>';
}
echo '<td>'.$row['email'].'</td>'.'<td>'.$row['family_grp'].'</td>';
echo '</tr>';
$area = null;
$pre = null;
$last4 = null;
}
  ?>
</tr>

</tbody>
</table>
</div>
</body>
</html>
