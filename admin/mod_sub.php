<?php
include ('../connect.php');
include('../functions/session.php');
include ('../functions/header.php');
if ($login_lvl>=8){
$sql=<<<SQL
  SELECT vs.sub_index, vs.v_sub_name, vs.v_sub_class, vc.v_class_name
  from volunteer_subjects as vs
  inner join volunteer_classes as vc ON vc.id = vs.v_sub_class
  ORDER by vs.sub_index ASC
SQL;



echo '<div class="centered"><center><h3>Change Program Volunteer Activity</h3></center>';
//sub index
$vsi = array();
//   v_sub_name
$vsn = array();
//   v_sub_class
$vsc = array();
//   v_class_name
$vcn = array();
if(!$result = $conn->query($sql)){
    die('There was an error running the query [' . $conn->error . ']');
}
$x=0;
while ($row=$result->fetch_array()) {
$vsi[$x]= $row['sub_index'];
$vsn[$x] =$row['v_sub_name'];
$vsc[$x] =$row['v_sub_class'];
$vcn[$x] =$row['v_class_name'];
$x++;
}
$total= $x;
if (empty ($_POST['todo'])) {
echo '<form method=post name=f2 action="" method="post"><input type=hidden name=todo value=submit>';
echo '<center><input type="radio" name="radio" value="m">Modify Activity&nbsp
&nbsp&nbsp&nbsp&nbsp<input type="radio" name="radio" value="d">Delete Activity
&nbsp&nbsp&nbsp&nbsp<input type="radio" name="radio" value="n">Create New Activity</center>';
//classification
echo '<center><br><span style="font-size:12px;color:gray;"><b>MODIFY</b> or <b>DELETE</b> require an activity to be selected from the list below</span></center>';

echo '<center><table border="0" cellspacing="0" >
<tr><td align=left  >
<select name=vol value=" " ></option>';
$x=0;
while($x < $total){
echo '<option value="'.$vsi[$x].'">'.$vsn[$x].' - '.$vcn[$x].'</option>';
$x++;
}
echo '</table></select>';
echo '<br><br>';
echo '<input type=submit value=Submit>';
echo '</form></center>';
echo '</div>';

} else {
  // going to perform a function on the subject
$sel=$_POST['radio'];
$id=$_POST['vol'];

switch ($sel) {
  case m:
    $sid=$id-1;
      echo '<div class="centered" ><center><h4>Modify a Volunteer Subject</h4>';
      echo 'You may change the name or the classification of any Volunteer Activity<br><br><br>';
      echo '<form method=post name=f3 action="../functions/chg_vs.php" method="post">';
      echo '<input type=hidden name=va value='.$id.'><input type=hidden name=vc value="'.$vsn[$sid].'"><input type=hidden name=vsc value="'.$vsc[$sid].'"><input type=hidden name=vsi value="'.$vsi[$sid].'"><input type=hidden name=vcn value="'.$vcn[$sid].'">';
      echo '<input type="radio" name="radio" value="n" />Change the Activity Name of <span style="color:blue;">'.$vsn[$sid].'</span> <br><br><br>';
      echo '<input type="radio" name="radio" value="c" />Change Volunteer Class Type for <span style="color:blue;">'.$vsn[$sid].' </span></center>';
      echo '<center><br><input type="submit" class="g_bubble" ></form>';
  echo '<span style="position:relative;margin-left:50px;"><a href="./settings.php" class="g_bubble">CANCEL</a></span></center></div>';
      //classification
   break;
  case n:
      $sql1 ="SELECT * FROM volunteer_classes WHERE v_class_name != 'Visitor'";
      if(!$result1 = $conn->query($sql1)){
          die('There was an error running the query [' . $conn->error . ']');
        }
        echo '<div class="centered" ><center><h3>Add a new Volunteer Subject</h3>';
        echo '<span style="color:red;text-decoration:italic;font-size:12px;">** Only affects future entries</span><br><br>';
        echo '<form action="../functions/new_vs.php" method="post"><table border="0" cellpadding="3" cellspacing="3" align="center">
            <tr><td>Activity Name: <input name="activity" type="text" /autofocus></td></tr><tr><td>Select Volunteer Class Type to be assigned to the new Activity  : <select name=vc value=" " ></option>';
            while ($row1=$result1->fetch_array()) {
  echo '<option value="'.$row1['id'].'">'.$row1['v_class_name'].'</option>';
            }

            echo '</table></select>
        <input type="submit" class="g_bubble" >';
        echo '<span style="position:relative;margin-left:50px;"><a href="./settings.php" class="g_bubble">CANCEL</a></span></center>';
    break;
  case d:
  $sid=$id-1;
        echo '<div class="centered" ><center><h3>Delete <span style="color:blue;">'.$vsn[$sid].'</span> volunteer subject?</h3>';
        echo '<span style="color:red;text-decoration:italic;font-size:12px;">** Only affects future entries</span><br><br>';
        echo '<span class="g_bubble"><a href="../functions/del_vs.php?i='.$id.'&n='.$vsn[$sid].'" id=\"tiles\">Submit</a></span><span style="position:relative;margin-left:50px;"><a href="./settings.php" class="g_bubble">CANCEL</a></span></center>';
     break;
}
}
} else {
//back to home page
header("location: admintest.php");
}
?>
