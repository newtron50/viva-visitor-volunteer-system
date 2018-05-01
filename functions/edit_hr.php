<?php
$user_id = $_GET['u'];
$grp= $_GET['grp'];
$name=$_GET['n'];

$sql=<<<SQL
SELECT vs.v_sub_name, vs.sub_index, vc.v_class_name, vs.v_sub_class
FROM volunteer_subjects as vs
INNER JOIN volunteer_classes as vc
ON vs.v_sub_class = vc.id order by vs.v_sub_name ASC
SQL;
if(!$result = $conn->query($sql)){
    die('There was an error running the query [' . $conn->error . ']');
}
if (isset($_POST['todo']) and isset($_POST['date']) and isset($_POST['vol']) and isset($_POST['hrs']) and isset($_POST['min']))  {
  $todo = $_POST['todo'];
  $date =$_POST['date'];
  $vol = $_POST['vol'];
  $hrs=$_POST['hrs'];
  if($hrs=='') {
    $hrs='00';
  }
  $today_date = date('m/d/Y');
  $min=$_POST['min'];
  $colon=':';
  $time_trail='00';
  $time=$hrs.$colon.$min.$colon.$time_trail;
  $name=$_GET['n'];
  //join name
  $res= explode(" ",$name,2);
  $fname=$res[0];
  $lname=$res[1];
  $grp=$_GET['grp'];
  $uid=$_GET['u'];
  $v_num = filter_var($vol, FILTER_SANITIZE_NUMBER_INT);
  $v_name = preg_replace('/[0-9]+/', '', $vol);
  $class= explode("$",$v_name,2);
  $edit_hrs=array($uid,$grp,$fname,$lname,$date,$time,$class[0],$class[1],$v_num,$grp);
$_SESSION['edit_hrs']=$edit_hrs;
$today = date("Y-m-d");
$date_test=$date;
$ttt_date=strlen($date);
if ($ttt_date==10) {
  $err8="no";
}elseif (!preg_match("#^[0-9]+$#", $ttt_date)){
  $err8="no";
} else {
  $err8="yes";
}
$date_test= date("Y-m-d", strtotime($date_test) );
if ($err8=='yes') {
  echo '<div class="centered"><center><h3><span style="color:red">ERROR!! </span>You must enter a date in the format of MM/DD/YYYY. <br><br>Example: Feb 2, 2015 as 02/02/2016 </h3>';
    echo '<a href="edit_hrs.php?u='.$uid.'&grp='.$grp.'&n='.$name.'" class="g_bubble">Return to Previous Page</a></span></center></div>';
} else if ($today>=$date_test) {
echo '<div class="centered"><center><h3>Verify the data to be entered</h3>';
echo '<table class="staged">';
echo '<tr><td>Name</td><td>'.$name.'</td></tr>';
echo '<tr><td>Date</td><td>'.$date.'</td></tr>';
echo '<tr><td>Activity</td><td>'.$class[0].'</td></tr>';
echo '<tr><td>Vol. Class</td><td>'.$class[1].'</td></tr>';
echo '<tr><td>Time</td><td>'.$hrs.':'.$min.'</td></tr></table>
<br><br><span class="g_bubble"><a href="../functions/man_hrs.php" id=\"tiles\">Submit</a></span><span style="position:relative;margin-left:50px;"><a href="edit_hrs.php" class="g_bubble">CANCEL</a></span><span style="position:relative;margin-left:50px;"><a href="edit_hrs.php?u='.$uid.'&grp='.$grp.'&n='.$name.'" class="g_bubble">Go Back</a></span></center></div>';

} else {
  echo '<div class="centered"><center><h3><span style="color:red">ERROR!! </span>You have entered a date in the future</h3>';
    echo '<a href="edit_hrs.php?u='.$uid.'&grp='.$grp.'&n='.$name.'" class="g_bubble">Return to Previous Page</a></span></center></div>';

}
} else {

echo '<div class="centered">';
echo '<h3>Manually Enter Volunteer Hours for '.$name.'</h3>';
echo '<p style="font-style:italic;color:red;font-size:12px"><b>** All boxes must be filled</b></p>';
echo '<form method=post name=f2 action="" method="post"><input type=hidden name=todo value=submit>';
//datepicker code
echo '<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css"><link rel="stylesheet" href="/resources/demos/style.css">
 <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
 <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
 <script>
 $( function() {
   $( "#datepicker" ).datepicker();
 } );
 </script>

<p>Date: <input type="text" id="datepicker" name="date" placeholder="mm/dd/yyyy"><span style="color:gray;"><i>&nbsp&nbspClick box for calendar</p>';

//classification

echo '<table border="0" cellspacing="0" >
<tr><td  align=left  >
<select name=vol value=" "></option>';
while($row=$result->fetch_array()){
echo '<option value="'.$row['v_sub_class'].$row['v_sub_name'].'$'.$row['v_class_name'].'">'.$row['v_sub_name'].' - '.$row['v_class_name'].'</option>';
}
echo  '  </select><p>Enter the number of Volunteer Hours for this function:</p>';

echo 'Hours: (between 1 and 40):<br><br><br><input type="number" name="hrs" min="1" max="40">';
echo '<br><br><br>Minutes: <br><table border="0" cellspacing="0" ><tr><td  align=left  ><select name=min value=""></option>';
echo '<option value="00">00</option><option value="15">15</option><option value="30">30</option>
<option value="45">45</option></table></select>';
echo '<br><br><input type=submit value=Submit>';
echo '</form>';
echo '</div>';
}
?>
