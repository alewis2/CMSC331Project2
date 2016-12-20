<?php

session_start();

$_SESSION["agreement"] = $_POST["agreement"];


if(empty($_SESSION['agreement']) || $_SESSION['agreement'] != 'yes'){
  header('Location: registrationClearance.php');
}
else{
  header('Location: 01StudSignIn.php');}
?>