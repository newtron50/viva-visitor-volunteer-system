<?php
// Delete an user
include('../connect.php');
include('../functions/session.php');
include('../functions/header.php');
if ($login_lvl>=8){
$sql=<<<SQL
  select a.user_id, a.name, a.username, al.admin_lvl_name
  FROM admin as a
  inner join admin_levels as al
  on a.admin_level = al.level
SQL;
  if(!$result = $conn->query($sql)){
    die('There was an error running the query [' . $conn->error . ']');
  }

$sql2=<<<SQL
  SELECT user_id, name from admin
SQL;
  if(!$result2 = $conn->query($sql2)){
    die('There was an error running the query [' . $conn->error . ']');
  }

  if (isset($_POST['delete'])) {
      $usr=$_POST['delete'];
      $delete = "DELETE from admin where user_id = $usr";
      if(($conn->query($delete)=== TRUE) ){
    echo '<br><br><h2><center>User successfully deleted</h2><br><br></center>
    <center><a href="admin_a.php" style="background-color:#D9D9C7;"><h4>Return to Admin Menu</a></center>';
        }
          } else {


              echo '<br><br><center>Select an Administrator/User to <span style="text-decoration:bold;color:red;">DELETE:</span><br><span style="text-decoration:italic;color:gray;">WARNING: This cannot be undone<br><br>';
              echo '<form method=post name=level action=""><input type=hidden name=todo value=submit><table border="0" cellspacing="0" ><tr><td  align=left  >
              <select name=delete value=" ">Select Level: </option>';
                while($row2=$result2->fetch_assoc()){
                    echo '<option value='.$row2[user_id].'>'.$row2[name].'</option>';
                    }
              echo '</select><input type=submit value=Submit></table></form>';
              echo '<br><br><a href="admin_a.php" style="font-weight:bold;">Cancel and Return</a><br><br></center>';
              echo '<center><table class="rpt_table_sm"><thead><th>User ID</th><th>Name</th><th>Username</th><th>Admin Level</th></thead>';
                  while($row=$result->fetch_assoc()){
                      echo '<tr><td>'.$row['user_id'].'</td><td>'.$row['name'].'</td><td>'.$row['username'].'</td><td>'.$row['admin_lvl_name'].'</td></tr>';
                    }
              echo '</center>';

              }
            } else {
//back to home page
header("location: admintest.php");
}
?>
