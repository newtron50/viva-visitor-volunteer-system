<?php
//log report

include('../connect.php');
include('../functions/session.php');
include('../functions/header.php');

//check if the starting row variable was passed in the URL or not
if (!isset($_GET['startrow']) or !is_numeric($_GET['startrow'])) {
  //we give the value of the starting row to 0 because nothing was found in URL
  $startrow = 0;
//otherwise we take the value from the URL
} else {
  $startrow = (int)$_GET['startrow'];
}
echo '<div><br><br><center>';
//this part goes after the checking of the $_GET var
$fetch =mysql_query("Select username, time, status,ip_addr from login_record order by time desc LIMIT $startrow, 20") or die(mysql_error());
   $num=Mysql_num_rows($fetch);
        if($num>0)
        {
        echo "<table style='width:90%;color:#464647;	border: 1px solid gray;	background-color: #e6e9ef;border-radius: 5px;'>";
        echo "<tr><td width='20%'>Username</td><td width='40%'>Login Time</td><td width='20%'>Status</td><td width='40%'>IP address</td></td>";
        for($i=0;$i<$num;$i++)
        {
          $y=0;
          $page=NULL;
        $row=mysql_fetch_row($fetch);
        echo "<tr>";
        for ($x=0;$x<=20;$x++) {
$y++;
        echo"<td>$row[$x]</td>";
      }

        echo"</tr>";
        }//for
        echo"</table>";
        }
        echo '<br><br>';
//now this is the link..
if ($i==20) {
echo '<a href="'.$_SERVER['PHP_SELF'].'?startrow='.($startrow+20).'">Next</a><span style="margin-left:50px;"></span>';
}
$prev = $startrow - 20;

//only print a "Previous" link if a "Next" was clicked
if ($prev >= 0){
    echo '<a href="'.$_SERVER['PHP_SELF'].'?startrow='.$prev.'">Previous</a>';
  }
  echo '</center></div>';
?>
