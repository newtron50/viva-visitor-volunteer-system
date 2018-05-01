<?php
include('../connect.php');
include('../functions/session.php');
if(empty($_GET['print'])) {
session_start();
include('../functions/header.php');
$todo=$_POST['todo'];
if (empty($_POST['vclass'])){
  $vclass='All';
  }else {
    $vclass=$_POST['vclass'];
  }
}

if (isset($_GET['print'])) {
  $today = $_GET['t'];
  $todo="submit";
  $vclass = $_GET['vc'];
  //dump css for excel
  if (empty($_GET['x'])) {
  echo '<div style="width:80%;margin-left:40px;"><br><link href="../css/multiColumnTemplate.css" rel="stylesheet" type="text/css">';
  echo '<link href="../css/table-style.css" rel="stylesheet" type="text/css">';
}
}


//date selection
if(isset($todo) and $todo=="submit"){
  if(empty($_GET['print'])) {

    $month=$_POST['month'];
    $year=$_POST['year'];
    //$date_value="$month/$dt/$year";
    //echo "mm/dd/yyyy format :$date_value<br>";
    $date_value="$year-$month";
    //echo "YYYY-mm-dd format :$date_value<br>";
    $today=$date_value;
  }
}

//get today's date for auto form fill
include ('../includes/date_today.php');
$start_date= $today.'-01';
$end_date=$today.'-31';

//***  BELOW IN HTML IS DATE CODE
if(empty($_GET['print'])) {

echo "
<div style='width:80%;'><center><br><br>

Select a Month to view:
  <form method=post name=f1 action=''><input type=hidden name=todo value=submit>
  <table border='0' cellspacing='0' >
  <tr><td  align=left  >
  <select name=month value=''>Select Month</option>
  <option selected=".$tmonth." value=".$tmonth.">".$nmonth."</option>
  <option value='01'>January</option>
  <option value='02'>February</option>
  <option value='03'>March</option>
  <option value='04'>April</option>
  <option value='05'>May</option>
  <option value='06'>June</option>
  <option value='07'>July</option>
  <option value='08'>August</option>
  <option value='09'>September</option>
  <option value='10'>October</option>
  <option value='11'>November</option>
  <option value='12'>December</option>
  </select>
  </td><td  align=left  ><select name=year>";
  $latest_year=$tyear;
  $earliest_year=$tyear-1;
  foreach ( range( $latest_year, $earliest_year ) as $i ) {
    // Prints the option with the next year in range.
    print '<option value="'.$i.'"'.($i === $currently_selected ? ' selected="selected"' : '').'>'.$i.'</option>';
  }
echo "</tr><tr><td>Select Visitior Class:</td>
  <td><select name=vclass>";

    switch ($vclass){
      case 'VOL':
          $vclass_2='Visitors';
          $sw=1;
          break;
      case 'VIS':
          $vclass_2='Volunteer';
          $sw=2;
          break;
      case 'All':
          $vclass_2='All Visitors/Volunteers';
          $sw=3;
          break;
    }
    if ($sw!=3) {
  echo    "<option selected=".$vclass_2." value=".$vclass_2.">".$vclass_2."</option>";
  }else {
    echo "<option selected=".$vclass_2." value=".$vclass_2.">All</option>";
  }
    if ($sw!=3){
    echo "  <option value='All'>All</option>";
  }
  if ($sw!=1){
    echo "<option value='VOL'>Visitors</option>";
  }
  if ($sw !=2) {
  echo "  <option value='VIS'>Volunteer</option>";
  }
  echo "  <input type=submit value=Submit></tr>
  </table>
  </form>
</center></div>";
}
if (isset($_GET['print'])) {
//$school = $_SESSION['school'];     ******* needs work for report header
//  echo "<center>".$school.' Log Report</center>';
}
echo '<hr {
    display: block;
    margin-top: 0.5em;
    margin-bottom: 0.5em;
    margin-left: auto;
    margin-right: auto;
    border-style: inset;
    border-width: 1px;

}>';
switch ($vclass){
  case 'VOL':
      $vclass_2='Visitors';
      break;
  case 'VIS':
      $vclass_2='Volunteer';
      break;
  case 'All':
      $vclass_2='All Visitors/Volunteers';
      break;
}
if ((isset($_GET['print'])) and (empty($_GET['x']))) {
  echo '<a href="search_month.php?print=y&t='.$today.'&vc='.$vclass.'&x=y" class="excel">Download Excel Spreadsheet</a>';
}
if (isset($_GET['x'])) {
  $data = NULL;
  $filename=NULL;
  include('../functions/xl_1.php');
}
if(isset($todo) and $todo=="submit") {
  echo '<br><center>Monthly '.$vclass_2.' report for: '.$start_date.' through '.$end_date;


if (empty($_GET['print'])) {
$monthNum  = $month;
$dateObj   = DateTime::createFromFormat('!m', $monthNum);
$monthName = $dateObj->format('F'); // March
}
  if (empty($_GET['print'])) {
    echo '<a href="search_month.php?print=y&t='.$today.'&vc='.$vclass.'" target="_blank" style="margin-left:50px;">Print Report</a></center>';
}
$sql = "SELECT * FROM record_log ORDER BY code_in DESC";
  if(!$result = $conn->query($sql)){
      die('There was an error running the query [' . $conn->error . ']');
  }
  echo '<center><table id="table" class="tablesorter" style="font-size:14px;width:90%;"><thead><tr>';

  //end

  echo '<th>type</th>';
  echo  '<th>Last Name</th>';
  echo  '<th>First Name</th>';
  echo '<th>Purpose</th>';
  echo '<th>Phone</th>';
  echo '<th>Barcode</th>';
  echo '<th>Scanned In</th>';
  echo '<th>Scanned Out</th>';
  echo '</tr></thead><tbody>';


  while($row=$result->fetch_array()){ //number of rows
//  $day= $row['code_out'];   day code....remove later
//  $day_1= strtotime($day);
//  $day_hack = date('Y-m-d',$day_1);
  if ($row['code_in'] >= $start_date && $row['code_in'] <= $end_date){
    if ($vclass != $row['type']) {
  echo '<tr>';
  echo '<td>'.$row['type'].'</td>'.'<td>'.$row['last_name'].'</td>'.'<td>'.$row['first_name'].'</td>'.'<td>'.$row['reason'].'</td>';

  //make phone readable
  if ($row['phone'] != 0) {
  $area=substr($row['phone'],-10,3);
  $pre=substr($row['phone'],-7,3);
  $last4=substr($row['phone'],-4,4);
  echo '<td>('.$area.') '.$pre.'-'.$last4.'</td>';
  } else {
    echo '<td> none</td>';
  }

  echo '<td>'.$row['barcode_assign'].'</td>'.'<td>'.$row['code_out'].'</td>'.'<td>'.$row['code_in'].'</td>';
  echo '</tr>';
  $area = null;
  $pre = null;
  $last4 = null;
}
//echo $tyear.'-'.$tmonth.'-'.$tday;
//echo $day_hack.' // '.$day.' // '.$day_1.'<br>';
  }
  }
}
if (isset($_GET['print'])) {
  echo '</div>';
}
  if (isset($_GET['x'])) {
    echo'</body></html>';
    echo $data;
  }
echo '</center></table>';

 ?>
