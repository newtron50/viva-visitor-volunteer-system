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
  $short_name =$_SESSION['school_short'];
$today = $_GET['t'];
$todo="submit";
$vclass=$_GET['vc'];
echo '<link href="../css/multiColumnTemplate.css" rel="stylesheet" type="text/css">';
echo '<link href="../css/table-style.css" rel="stylesheet" type="text/css">';
}

//date selection
if(isset($todo) and $todo=="submit"){
  if(empty($_GET['print'])) {

    $today=$_POST['date'];
  }
}

//***  BELOW IN HTML IS DATE CODE
if(empty($_GET['print'])) {
echo "<div class='centered'><center><br><br>Select a Day to view:
  <form method=post name=f1 action=''><input type=hidden name=todo value=submit>";
  //datepicker code
  echo '<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css"><link rel="stylesheet" href="/resources/demos/style.css">
   <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
   <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
   <script>
   $( function() {
     $( "#datepicker" ).datepicker();
   } );
   </script>

  <p>Date: <input type="text" id="datepicker" name="date"><span style="color:gray;"><i>&nbsp&nbspClick box for calendar</p>';
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
echo "
  <input type=submit value=Submit>
  </table>
  </form>
</center></div>";
}
if (isset($_GET['print'])) {
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
if(isset($todo) and $todo=="submit") {
  echo '<center>';
      if(isset($_GET['print'])) {
            echo '<h4>'.$short_name.'</h4>'.$vclass_2.' report for: '.$today;
          }
  if (empty($_GET['print'])) {
    echo '<a href="search_today.php?print=y&t='.$today.'&vc='.$vclass.'" target="_blank" style="margin-left:50px;">Print Report</a></center>';
}
//convert m-d-y to timecode to compare
$hack=date("Y-m-d", strtotime($today));;
$hack_day=substr($hack,8,2);
$hack_day=$hack_day+1;
if ($hack_day<9) {
  $hack_day='0'.$hack_day;
}
$hack_day= substr_replace($hack,$hack_day,8,2);
$hack_day=$hack_day.' 00:00:00';
$hack=$hack.' 00:00:00';

$day_hack = date('m/d/Y',$day_1);
// end time convert
  $sql = "SELECT * FROM record_log where code_in >= '$hack' and code_in < '$hack_day' ORDER BY code_in ASC";
  if(!$result = $conn->query($sql)){
      die('There was an error running the query [' . $conn->error . ']');
  }
  echo '<div style="margin-left:40px;width:90%;"><center><table id="table" class="tablesorter" style="font-size:14px;"><thead><tr>';

  //end
  echo  '<th>User ID</th>';
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

      if ($vclass != $row['type']) {
  echo '<tr>';
  echo '<td>'.$row['user_id'].'</td>'.'<td>'.$row['type'].'</td>'.'<td>'.$row['last_name'].'</td>'.'<td>'.$row['first_name'].'</td>'.'<td>'.$row['reason'].'</td>';

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

  }
}
if (isset($_GET['print'])) {
  echo '</center></div>';
}

 ?>
