<?php
include('../connect.php');
echo '<link href="../css/multiColumnTemplate.css" rel="stylesheet" type="text/css">';
include('../includes/guest_header.php');
include('../includes/data.php');

$errors1='';
$errors2='';
$errors3='';

echo "<div style='text-align:center;'><h3>Add a new volunteer:</h3>";
$err=1;
if (isset($_POST['todo']))  {
$e1=0;
$e2=0;
$e3=0;
$e4=0;
$err=2;



  if ($_POST['fname'] == "") {
    $_POST['fname'] = filter_var($_POST['name'], FILTER_SANITIZE_STRING);
    if ($_POST['fname'] == "") {
        $errors1 .= 'Please enter a valid first name.<br/><br/>';
          $e1=1;
          $err=0;
    }
  }
  if ($_POST['lname'] == ""){
    $_POST['lname'] = filter_var($_POST['name'], FILTER_SANITIZE_STRING);
    if ($_POST['lname'] == "") {
        $errors2 .= 'Please enter a valid last name.<br/><br/>';
          $e2=1;
          $err=0;
    }
  }
  if ($_POST['email'] != "") {
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      $errors3 .= "$email is <strong>NOT</strong> a valid email address.<br/><br/>";
      $e3=1;
      $err=0;
      }
    }

}



if ($err==1 || $err==0) {

echo '<form action="./functions/add_vol.php" method="post"><input type=hidden name=todo value="submit">';
echo '<h2>If you have previously registered as a volunteer<br>Don\'t register again<br><h1><a href="./repeat_search.php">Click here if already registered</a><br></h1></h2>
      <table border="0" cellpadding="3" cellspacing="3" align="center">
        <tr><td>First Name: </td><td><input name="fname" type="text" /></td><td>';
if ($e1=1) {
  echo '<span style="color:red;font-size:12px;font-style:italic">'.$errors1.'</span>';
}
echo       '</td></tr>
        <tr><td>Last Name: </td><td><input name="lname" type="text" /></td><td>';
if ($e2=1) {
  echo '<span style="color:red;font-size:12px;font-style:italic">'.$errors2.'</span>';
}
echo       '</td></tr>
      <tr><td>Email: </td><td><input name="email" type="email"  /></td><td>';
if ($e3=1) {
echo '<span style="color:red;font-size:12px;font-style:italic">'.$errors3.'</span>';
}
echo       '</td></tr><tr><td>Phone Number: </td><td><input name="phone1" type="tel" /></td><td></td></tr>
        <tr><td>Cellphone Number: </td><td><input name="phone2" type="tel" /></td><td></td></tr>
          <tr><td>Assign a PIN instead of Phone number:</td><td><input name="ph_type" type="checkbox" value="y"/>Create a PIN number?</td></tr>  <tr><td>Other Number: </td><td><input name="phone3" type="tel" placeholder="Don\'t Use if PIN is checked"/></td><td></td></tr><tr><td></td></tr><tr><td><a href="../reports/fam_update.php" target="_new"> Search for an exisiting Group Number</a></td><td><span style="color:gray;font-size:12px;font-style:italic;">Leave group blank to create a new Group</span></td></tr>
                <tr><td>Group Number: </td><td><input name="grp" type="number" placeholder="required"/></td></tr>
      </table><br><br><input type="submit" class="g_bubble" ></center><br><br></form>';
    }  else {
//form entered

$lname=$_POST['lname'];
$fname=$_POST['fname'];
$email=$_POST['email'];
$ph_1=$_POST['phone1'];
if (isset($_POST['ph_type'])) {
$ph_t=$_POST['ph_type'];
} else {
  $ph_t = 'n';
}
$ph_2=$_POST['phone2'];
$ph_3=$_POST['phone3'];
$grp=$_POST['grp'];

// set numbers for phone
$justNums = preg_replace('/[^0-9]/', '', $ph_1);
//eliminate leading 1 if its there
if (strlen($justNums) == 11) {
$justNums = preg_replace("/^1/", '',$justNums);
}
$ph_1 = $justNums;
// set numbers for phone
$justNums = preg_replace('/[^0-9]/', '', $ph_2);
//eliminate leading 1 if its there
if (strlen($justNums) == 11) {
$justNums = preg_replace("/^1/", '',$justNums);
}
$ph_2 = $justNums;
// set numbers for phone
$justNums = preg_replace('/[^0-9]/', '', $ph_3);
//eliminate leading 1 if its there
if (strlen($justNums) == 11) {
$justNums = preg_replace("/^1/", '',$justNums);
}
$ph_3 = $justNums;


echo '<div class="centered"><center>';
///  using group functions???
if ($gpf==1) {
$sql=<<<SQL
    select *
    from people where last_name
    like '$lname%' or
    first_name like '$fname%' and last_name
    like '$lname%'
SQL;

if(!$result = $conn->query($sql)){
        die('There was an error running the query [' . $conn->error . ']');
    }
  $x=0;
  echo '<form action="../functions/cr_ppl.php" method="post">';
while($row=$result->fetch_assoc()){
        if ($x==0)   {
          $temp_grp=$row['family_grp'];
        echo '<center><p style="color:red;font-size:18px;"><u>Use Caution  --- Like Entries </u></p><table class="bbo_sm"><td colspan="2" style="border-bottom: thin solid;">Name</td><td style="border-bottom: thin solid;">Group</td><td style="border-bottom: thin solid;">Check only one box if desired</td></tr>';
      echo '<tr><td>'.$row['first_name'].'</td><td>'.$row['last_name'].'</td><td>'.$row['family_grp'].'</td><td><input name="grp4" type="checkbox" value="'.$temp_grp.'"/><label>Join Volunteer to this group?</label></td></tr>';
      $x++;
    }  else {
      $temp_grp=$row['family_grp'];
      echo '<tr><td>'.$row['first_name'].'</td><td>'.$row['last_name'].'</td><td>'.$temp_grp.'</td><td><input name="grp5" type="checkbox" value="'.$temp_grp.'"/><label>Join Volunteer to this group?</label></td></tr>';
    }

    }
    echo '</table></center>';

}///  not if not using group functions

$sql1=<<<SQL
     select max(family_grp)
     as family_grp from people
SQL;
    if(!$result1 = $conn->query($sql1)){
        die('There was an error running the query [' . $conn->error . ']');
    }
      while ($row1 = $result1->fetch_row()){
      $last_grp=$row1[0];
    }

// variable to check if all phone #;s are blank and PIN is not checked
$chg=0;
echo '<br><br><h2>Verify your entry</h2><br><table><tr>';
echo '<th colspan="2">Name</th><th>Email</th><th>Phone 1</th><th>Phone 2</th><th>Phone 3</th><th>Use a PIN?</th><th>Group #</th></tr>';
    echo '<tr><td>'.$lname.'</td><td>'.$fname.'</td><td>';
if ($email!='') {
  echo $email;
} else {
  echo '-----';
}
echo '</td><td>';
if ($ph_1!='') {
  echo $ph_1;
} else {
  echo '-----';
  $chk++;
}
echo '</td><td>';
if ($ph_2!='') {
  echo $ph_2;
} else {
  echo '-----';
  $chk++;
}
echo'</td><td>';
if ($ph_3!='') {
  echo $ph_3;
} else {
  echo '-----';
  if ($chk==2) {
    $ph_t = 'y';
//invokes PIN creation because no Phone numbers are entered
  }
}
echo'</td><td>';
  if ($ph_t=='y') {
    echo '<span style="color:red;"><b>YES</b></span>';
    $ph_3=$new_pin;
  } else {
    echo 'NO';
  }
  echo '</td><td>';
  if ($grp!='') {
    echo $grp;
  } else {
  $grp=$last_grp+1;
  echo '<span style="color:red"><b>New: '.$grp.'</b></span>';
  }
  echo '</td></tr></table><br>';
  if ($ph_t=='y'){
  include ('../functions/get_PIN.php');
  $ph_3=$new_pin;
  }
  //send parameters
  $_SESSION['new_peep'] = array($lname,$fname,$email,$ph_1,$ph_2,$ph_3,$ph_t,$grp,$new_pin);

  if ($ph_t=='y'){
    echo '<br><p style="font-size:20px;">Assigned PIN Number: <b>'.$new_pin.'</b><span style="position:relative;margin-left:10px;color:gray;font-size:12px;">Make note of the PIN Number</span></p>';
  }
  echo '<center><br><br>Are you sure you want to create this new profile?<br>';
  echo '<input type="hidden" name="manual" value="1">';
  echo '<br><input type="submit" class="g_bubble" value="Create User"><span style="position:relative;margin-left:40px;"></span><a href="../main.php" class="g_bubble">CANCEL</a></center></form>';




echo '</center></div>';

}

?>
