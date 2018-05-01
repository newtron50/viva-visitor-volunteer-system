<?php
include ('../functions/header.php');
include ('../connect.php');
include('../functions/session.php');

echo ' '. $_POST['radio'];
if ($_POST['radio']=='n' and empty($_POST['id'])) {

  $chg=$_POST['radio'];
  $vc=$_POST['vc'];
  $va=$_POST['va'];
  if ($chg=='n') {
      echo '<div class="centered" ><center><h4>Change the Activity Name of '.$vc.'</h4><br>';
      echo '<form method=post name=f3 action="chg_vs.php" method="post"><input type=hidden name=id value="'.$va.'"><input type=hidden name=old value="'.$vc.'">';
      echo 'Enter the new name to refer to this Activity by: <input name="new" type="text" /autofocus><br><br><br>';
      echo '<input type=submit value=Submit class="g_bubble"></span><span style="position:relative;margin-left:50px;"><a href="../admin/settings.php" class="g_bubble">CANCEL</a></span><span style="position:relative;margin-left:50px;"></span>';
    }

} elseif (isset($_POST['id'])) {
// change name

$old_name=$_POST['old'];
$uid=$_POST['id'];
$new_name=$_POST['new'];
$chg_name= "UPDATE volunteer_subjects SET v_sub_name = '$new_name' where sub_index = $uid";
if(($conn->query($chg_name)=== TRUE) ){
echo '<div class="centered"><center><h3>Volunteer Subjects</h3><br><span style="text-decoration:bold;"><b>'.$old_name.'</b></span> has been changed to <span style="color:blue;">'.$new_name.'</span>.<br><br><br>Volunteer records are only affected with this change going forward.</center></div>';
}
echo '<br><br><center><a href="../admin/settings.php" class="g_bubble">Return to Menu</a></center>';

} else {
$vsc1=$_POST['vsc'];
$vsn1=$_POST['vc'];
$vcn1=$_POST['vcn'];
$vsi1=$_POST['vsi'];
  // change volunteer activity class level
$sql1 = "SELECT * from volunteer_classes where v_class_name != 'Visitor'";
if(!$result1 = $conn->query($sql1)){
    die('There was an error running the query [' . $conn->error . ']');
  }
  echo '<div class="centered"><center><h4>Change Volunteer Class for Activity</h4>';
  echo '<br><br> Change <b><i>'.$vsn1.'</b></i> -- Current Class: '.$vcn1.'<br><br>';
  echo '<br>Select a new Volunteer Classification <br><br><br>';
  echo '<form method=post name=chg_vc action="c_vs.php " "><input type=hidden name=id value="'.$vsi1.'"><input type=hidden name=activity value="'.$vsn1.'">';
  echo '<select name=chg_vc value=" " style="font-size:18px;-webkit-appearance: none;"></option>';
$x=0;
      while ($row1=$result1->fetch_array()) {
        if ($x==0) {
          echo '<option value=" ">-- Select Class --</option>';
          echo '<option value="'.$row1['id'].'">'.$row1['v_class_name'].'</option>';
          $x++;
          } else {
            echo '<option value="'.$row1['id'].'">'.$row1['v_class_name'].'</option>';
          }
      }
  echo '</select><br><br>';

echo '<input type="submit" class="g_bubble" >';
echo '<span style="position:relative;margin-left:50px;"><a href="../admin/settings.php" class="g_bubble">CANCEL</a></span></form></center></div>';

  echo '</center></div>';

}

/*$new_vs = "INSERT INTO volunteer_subjects (v_sub_name, v_sub_class) VALUES ('$act',$vc)";
if(($conn->query($new_vs)=== TRUE) ){
echo '<div class="centered"><center><h3>Volunteer Subjects</h3><br><span style="text-decoration:bold;"><b>'.$act.'</b></span> has been created</center></div>';
}*/
?>
