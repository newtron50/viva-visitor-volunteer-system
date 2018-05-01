<?php
include('../connect.php');
include('../functions/session.php');
include('../functions/header.php');


if ($login_lvl>=5){
$flag=0;
  echo '<div style="width:85%;"><center><p>Search by Last Name</p>';
  $field='last_name';
  $sort='ASC';
  // try the php sorting
  if (isset($_GET['l'])) {
    $lname = $_GET['l'];
  } else {
    $lname = 'A';
  }
  foreach (range('A', 'Z') as $char) {
      echo '<a href="mod_vol.php?l='.$char.'">'.$char . "\n".'&nbsp&nbsp</a>';
  }
  echo '</center></div>';
  if (isset($_GET['u'])) {
include('../functions/m_vol.php');


  } else {
      if (isset($_GET['l'])) {

              $sql = "SELECT user_id, family_grp, CONCAT(first_name,' ',last_name) as name FROM people where last_name
                    like '$lname%' ORDER BY $field $sort";
                      if(!$result = $conn->query($sql)){
                        die('There was an error running the query [' . $conn->error . ']');
                      }
              echo '<div class="centered"><table id="table" class="tablesorter"><thead><tr>';
              echo  '<th>User ID</th>';
              echo  '<th>Name</th>';
              echo  '<th>Fam Group</a></th>';
              echo '</tr></thead><tbody>';
            while($row=$result->fetch_array()){ //number of rows
              echo '<tr style="line-height:16px;"><td>'.$row['user_id'].'</td><td><a href="mod_vol.php?u='.$row['user_id'].'&grp='.$row['family_grp'].'&n='.$row['name'].'">'.$row['name'].'</a></td><td>'.$row['family_grp'].'</td></tr>';
            }
            echo '</div>';
        } // end of Get l
      }  // end of Get u
      if (isset($_POST['todo'])) {
        //verify and write data
        $a=$_POST['month'];
        $b=$_POST['replace'];
        $usr=$_POST['user'];


        $flag=1;
        include('../functions/m_vol.php');
$err=0;
//check data
            if ($a=='fname'){
              $b = preg_replace('/ +/', ' ', $b);

              $b = filter_var($b, FILTER_SANITIZE_STRING);
              if ($b == "") {
                  $errors4 .= 'Please enter a valid first name.<br/><br/>';
                    $err=1;
              }
            }
            if ($a=='lname'){
              $b = filter_var($b, FILTER_SANITIZE_STRING);
              if ($b == "") {
                  $errors4 .= 'Please enter a valid last name.<br/><br/>';
                    $err=1;
              }
            }
            if ($a == 'email') {
              $b = filter_var($b, FILTER_SANITIZE_EMAIL);
              if (!filter_var($b, FILTER_VALIDATE_EMAIL)) {
                $errors4 .= "$b is <strong>NOT</strong> a valid email address.<br/><br/>";
                $err=1;
              }
            }
            if ($a == 'phone') {
              $b = preg_replace('/[^0-9]/', '', $b);
              if (strlen($b) != 10) {
                $errors4 .= "Phone number is not the correct format or length.<br/><br/>";
                $err=1;
              }
            }
            if ($a == 'cell') {
              $b = preg_replace('/[^0-9]/', '', $b);
              if (strlen($b) != 10) {
                $errors4 .= "Phone number is not the correct format or length.<br/><br/>";
                $err=1;
              }
            }
            if ($a == 'other') {
              $b = preg_replace('/[^0-9]/', '', $b);
              if (strlen($b) != 10) {
                $errors4 .= "Phone number is not the correct format or length.<br/><br/>";
                $err=1;
              }
            }
            echo '<br><br><h3>Verify you want to modify the information for this volunteer</h3>';
          $tags=array('first_name' => 'First Name','last_name' => 'Last Name','phone' => 'Main Phone','cell' => 'Cell Phone','other' => 'Other Phone','PIN' => 'PIN','email' => 'Email','family_grp' => 'Member of Group #');
          echo $tags[$a].'<span class="space_b">'.$b.'</span>';
          if ($err==1)  {
            echo '<p style="color:red"><b>'.$errors4.'</p>';
          }
          if ($err!=1)  {
          echo '<br><br><center><a href="../functions/modvol.php?u='.$usr.'&c='.$a.'&h='.$b.'" class="g_bubble">Modify the Information</a></center>';
        }
          echo '<center><p style="font-size:24px;"><a href="mod_vol.php?u='.$usr.'" class="g_bubble">Return to the previous menu</a></center>';
  $err=0;
        $flag=0;
          }

      }
 //end login level
?>
