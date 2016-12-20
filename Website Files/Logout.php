<?php
session_start();
$flag = false;

if(isset($_SESSION['studID'])) { $flag = true; }


session_unset();
session_destroy();

session_start();
$_SESSION["agreement"] = "yes";

if($flag) { header("Location: 01StudSignIn.php"); }
else { header("Location: AdminSignIn.php"); }

?>