<?php
/*****************************

Generates end of year Visitor Report and downloads into spreadsheet

******************************/
include('../connect.php');
include('../functions/session.php');
$sql_vs = "SELECT * FROM record_log ORDER BY code_in ASC";
  if(!$result_vs = $conn->query($sql_vs)){
      die('There was an error running the query [' . $conn->error . ']');
  }
  echo '<center> Yearly Visitor Records for Archival Purposes --   ';
if (empty($_GET['x'])) {
  echo '"<a href="./yr_visits.php?x=y" class="excel">Download Excel Spreadsheet</a>';
}
  echo '<center><table id="table" class="tablesorter" style="font-size:14px;width:90%;"><thead><tr>';

  if (isset($_GET['x'])) {
    $data = NULL;
    $filename=NULL;
    include('../functions/xl_1.php');
  }
  //end

  echo '<th>type</th>';
  echo  '<th>Last Name</th>';
  echo  '<th>First Name</th>';
  echo '<th>Purpose</th>';
  echo '<th>Scanned In</th>';
  echo '<th>Scanned Out</th>';
  echo '</tr></thead><tbody>';


  while($row_vs=$result_vs->fetch_array()){ //number of rows
//  $day= $row['code_out'];   day code....remove later
//  $day_1= strtotime($day);
//  $day_hack = date('Y-m-d',$day_1);
  if ($row_vs['code_in'] >= $start_date && $row['code_in'] <= $end_date){
    if ($vclass != $row_vs['type']) {
  echo '<tr>';
  echo '<td>'.$row_vs['type'].'</td>'.'<td>'.$row_vs['last_name'].'</td>'.'<td>'.$row_vs['first_name'].'</td>'.'<td>'.$row_vs['reason'].'</td>';

  echo '<td>'.$row_vs['code_out'].'</td>'.'<td>'.$row_vs['code_in'].'</td>';
  echo '</tr>';
  $area = null;
  $pre = null;
  $last4 = null;
}

  }
  }


  if (isset($_GET['x'])) {
    echo'</body></html>';
    echo $data;
  }
echo '</center></table>';


// excel Spreadsheet
echo '<div style="width:80%;margin-left:40px;"><br><link href="../css/multiColumnTemplate.css" rel="stylesheet" type="text/css">';
echo '<link href="../css/table-style.css" rel="stylesheet" type="text/css">';

if (isset($_GET['x'])) {
  echo'</body></html>';
  echo $data;
}

?>
