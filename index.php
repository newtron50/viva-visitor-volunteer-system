<?php
   include("connect.php");
   session_start();
  echo '<html><head><meta charset="UTF-8"><meta http-equiv="X-UA-Compatible" content="IE=edge"><meta name="viewport" content="width=device-width, initial-scale=1"><title>VIVA</title><style>body {background-image: url("./images/viva2.jpg ");background-repeat: no-repeat;background-size: 100%;background-color: #1c1565;}</style>
   <link href="../css/multiColumnTemplate.css" rel="stylesheet" type="text/css">
   <link href="../css/table-style.css" rel="stylesheet" type="text/css">
   <!--<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.2/jquery.min.js"></script>
   <script type="text/javascript" src="./js/tablesorter/jquery.tablesorter.js"></script>
   <script src="sort.js"></script>-->
   </head>
   <body>
     <div class="container">
       <header>
         <div class="primary_header" style="background-color:#20488A;">';

   echo '</div></head>';

   if($_SERVER["REQUEST_METHOD"] == "POST") {
      // username and password sent from form
      //modify password
//      (password_verify($password, $hashed_password))

      $myusername = mysqli_real_escape_string($conn,$_POST['username']);
      $mypassword = mysqli_real_escape_string($conn,$_POST['password']);

      $sql = "SELECT admin.user_id, admin.name, admin.username, admin.admin_level, al.admin_lvl_name, admin.password FROM admin inner join admin_levels as al on al.level = admin.admin_level where admin.username = '$myusername'";
      $result = mysqli_query($conn,$sql);
      $row = mysqli_fetch_array($result,MYSQLI_ASSOC);
//      $active = $row['active'];
      //test code
      $login_lvl= $row['admin_level'];
      $login_admin=$row['admin_lvl_name'];
      $login_name=$row['name'];
      $hashed_password=$row['password'];
$_SESSION['admin_level'] = $login_lvl;
$_SESSION['admin_lvl_name'] = $login_admin;
$_SESSION['login_name'] = $login_name;



//original code      $count = mysqli_num_rows($result);
$count=0;
if(password_verify($mypassword, $hashed_password)) {
  $count++;
}

      // If result matched $myusername and $mypassword, table row must be 1 row

      if($count == 1) {
         //session_register("myusername");
         $_SESSION['login_user'] = $myusername;
         $status="successful";
         $error='';
         $line=$_SERVER['REMOTE_ADDR'];
         ///******* include program settings

         include (dirname(__FILE__).'/functions/loc_rec.php');
                if ($login_lvl<1) {
                    header("location: base.php");
                } else {
                    header("location: ./admin/admintest.php");
                }
/// *** write user to login DB

///
      }else {
        $uname=$myusername;
        $status="failed";
         $error = "Your Login Name or Password is invalid";
         $line="none";
         include (dirname(__FILE__).'/functions/loc_rec.php');
      }
      //record login
      $uname=$myusername;


   }

?>
<html>

   <head>
      <title>Login Page</title>

      <style type = "text/css">
         body {
            font-family:Arial, Helvetica, sans-serif;
            font-size:14px;
         }

         label {
            font-weight:bold;
            width:100px;
            font-size:14px;
         }

         .box {
            border:#666666 solid 1px;
         }
      </style>

   </head>

   <body bgcolor = "#FFFFFF">
<body link="#FFFFFF" vlink="#FFFFFF" alink="#FFFFFF">
      <div align = "center">
  <!--       <div style = "width:300px; border: solid 0px #333333; margin-left:400px;margin-top:50px;" align = "left">
            <div style = "background-color:#333333; color:#FFFFFF; padding:3px;"><b>Login</b></div>-->

            <div style = "margin-left:140px;margin-top:50px">

               <form action = "" method = "post">
                  <label>UserName  :</label><input type = "text" name = "username" class = "box" autofocus/><br /><br />
                  <label>Password  :</label><input type = "password" name = "password" class = "box" /><br/><br />
                  <input type = "submit" value = " Submit "/><br />
               </form>
	       <br><br><span style="font-size:20px;"><a href="base.php" color:white>Enter Guest & Volunteer Station</a></span>
               <div style = "font-size:11px; color:#cc0000; margin-top:10px"><?php echo $error; ?></div>
            </div>

         </div>

      </div>

   </body>
</html>
