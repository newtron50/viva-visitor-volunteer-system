<?php


        $admin= array('settings.php','reports.php','people.php','logout.php','admintest.php','edit_hrs.php');

        echo '<a href="../admin/'.$admin[4].'" class="menu_a">Home</a>&nbsp;&nbsp;&nbsp;';
if ($login_lvl>=6){
        echo '<a href="../admin/'.$admin[1].'" class="menu_a">Reports</a>&nbsp;&nbsp;&nbsp;';
      }
      if ($login_lvl>=4){
        echo '<a href="../admin/'.$admin[2].'" class="menu_a">People</a>&nbsp;&nbsp;&nbsp;';
      }
        if ($login_lvl>=7){
        echo '<a href="../admin/'.$admin[0].'" class="menu_a">Functions</a>&nbsp;&nbsp;&nbsp;';
      }
      if ($login_lvl==3 or $login_lvl==5){
      echo '<a href="../admin/'.$admin[5].'" class="menu_a">Add Volunteer Hours</a>&nbsp;&nbsp;&nbsp;';
    }
        echo '<a href="../admin/'.$admin[3].'" class="menu_a">Logout</a>&nbsp;&nbsp;&nbsp;';



?>
