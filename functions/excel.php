<?php
header('Content-type: application/excel');
$filename = 'VIVA_report.xls';
header('Content-Disposition: attachment; filename='.$filename);

$data = '<html xmlns:x="urn:schemas-microsoft-com:office:excel">
<head>
    <!--[if gte mso 9]>
    <xml>
        <x:ExcelWorkbook>
            <x:ExcelWorksheets>
                <x:ExcelWorksheet>
                    <x:Name>Sheet 1</x:Name>
                    <x:WorksheetOptions>
                        <x:Print>
                            <x:ValidPrinterInfo/>
                        </x:Print>
                    </x:WorksheetOptions>
                </x:ExcelWorksheet>
            </x:ExcelWorksheets>
        </x:ExcelWorkbook>
    </xml>
    <![endif]-->
</head>

<body>';

include('../connect.php');
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

include('./connect.php');
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
$sql = "SELECT user_id, first_name, last_name, phone, other_phone,cell, email, family_grp FROM people ORDER BY $field $sort";
if(!$result = $conn->query($sql)){
    die('There was an error running the query [' . $conn->error . ']');
}
echo '<table id="table" class="tablesorter"><thead><tr>';

//end
echo  '<th><a href="people.php?sorting='.$sort.'&field=user_id">User</a></th>';
echo  '<th><a href="people.php?sorting='.$sort.'&field=last_name">Last Name</a></th>';
echo  '<th><a href="people.php?sorting='.$sort.'&field=first_name">First Name</a></th>';
echo '<th>Phone</th>';
echo '<th>2nd Phone</th>';
echo '<th>Cell</th>';
echo '<th>Email</th>';
echo  '<th><a href="people.php?sorting='.$sort.'&field=family_grp">Fam Group</a></th>';
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
if ($row['other_phone'] != 0) {
$area=substr($row['other_phone'],-10,3);
$pre=substr($row['other_phone'],-7,3);
$last4=substr($row['other_phone'],-4,4);
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
echo '
</tr>

</tbody>
</table>
</div>';


echo '</body></html>';

echo $data;
?>
