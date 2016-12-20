<?php
session_start();
$debug = false;
include('../CommonMethods.php');
$COMMON = new Common($debug);
error_reporting(0);
?>

<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <title>Select Advising Type</title>
	<link rel='stylesheet' type='text/css' href='./css/standard.css'/>
  </head>
  <body>
    <div id="login">
      <div id="form">
        <div class="top">
		<h1>Schedule Appointment</h1>
		<h2>What kind of advising appointment would you like?</h2><br>
	<form action="StudProcessType.php" method="post" name="SelectType">
	<div class="nextButton">
<center>
	<?php
  if(isIndividualAvailable()) { echo("<input type='submit' name='type' class='button large go' style='margin-right:40px;' value='Individual'>"); }
		if(isGroupAvailable()) { echo("<input type='submit' name='type' class='button large go' value='Group'>"); }
	?>
</center>
	    </div>
		</div>
		</form>


<br>
<br>
		<div>
	<?php
		if(!isIndividualAvailable() && !isGroupAvailable()) { echo("I'm sorry, nothing is available at this time. Please check again later."); }
	?>

	<?php 
	if($_SESSION['resch']){
	  echo('<form method="link" action="04StudViewApp.php">  
            <input type="submit" name="home" class="button large" value="Cancel"></form>');
	}
	  else{
	    echo('<form method="link" action="02StudHome.php">
	    <input type="submit" name="home" class="button large" value="Cancel"></form>');
	  }

	?>
		  
		</div>
  </body>
</html>

<?php

// functions for IF there are any appointments to select

function isIndividualAvailable() // based on Major too
{
	global $debug; global $COMMON;

	$localMaj = $_SESSION["major"];
	$sql = "select * from Proj2Appointments where `EnrolledNum` = 0 and `Max` = 1 and (`Major` like '%$localMaj%' or `Major` = '') and `Time` > '".date('Y-m-d H:i:s', strtotime('+24 hours'))."'";
	$rs = $COMMON->executeQuery($sql, $_SERVER["SCRIPT_NAME"]);
	$row = mysql_fetch_row($rs);
	
	if($row[0] > 0)
	{ 
	  return true; 
	} 

	return false;
}

function isGroupAvailable() // based on Major too
{
	global $debug; global $COMMON;

	$localMaj = $_SESSION["major"];
	$sql = "select count(*) from Proj2Appointments where `EnrolledNum` < `Max` and `Max` > 1 and (`Major` like '%$localMaj%' or `Major` = '')  and `Time` > '".date('Y-m-d H:i:s', strtotime('+24 hours'))."'";
	$rs = $COMMON->executeQuery($sql, $_SERVER["SCRIPT_NAME"]);
	$row = mysql_fetch_row($rs);

	if($row[0] > 0)
	{ return true; } 

	return false;

}
