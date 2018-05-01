<?php
include($_SERVER['DOCUMENT_ROOT'].'/visitor/includes/data.php');
session_start();

   $user_check = $_SESSION['login_user'];
$short_name =$_SESSION['school_short'];
   $ses_sql = mysqli_query($conn,"select username from admin where username = '$user_check' ");
   $row = mysqli_fetch_array($ses_sql,MYSQLI_ASSOC);


   $login_session = $row['username'];
$login_name=$_SESSION['login_name'];
   $login_lvl=$_SESSION['admin_level'];
   if(!isset($_SESSION['login_user'])){
      header("location: /visitor/admin/login.php");
   }
?>
