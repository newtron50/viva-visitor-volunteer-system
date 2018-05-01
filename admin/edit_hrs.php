<?php
include('../connect.php');
include('../functions/session.php');
include('../functions/header.php');


if ($login_lvl==3 OR $login_lvl>=5) {

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
      echo '<a href="edit_hrs.php?l='.$char.'">'.$char . "\n".'&nbsp&nbsp</a>';
  }
  echo '</center></div>';
  if (isset($_GET['u'])) {
include('../functions/edit_hr.php');

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
              echo '<tr><td>'.$row['user_id'].'</td><td><a href="./edit_hrs.php?u='.$row['user_id'].'&grp='.$row['family_grp'].'&n='.$row['name'].'">'.$row['name'].'</a></td><td>'.$row['family_grp'].'</td></tr>';
            }
            echo '</div>';
        } // end of Get l
      }  // end of Get u
} else {
  echo '<center><br><br><br>You are not authorized for this function</center>';
}//end login level



?>
