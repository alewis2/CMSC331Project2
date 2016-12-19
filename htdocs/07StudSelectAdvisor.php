<?php
session_start();
$debug = false;
include('../CommonMethods.php');
$COMMON = new Common($debug);
$localMaj = $_SESSION["major"];
?>

<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <title>Select Advisor</title>
	<link rel='stylesheet' type='text/css' href='./css/standard.css'/>
  </head>
  <body>
    <div id="login">
      <div id="form">
        <div class="top">
		<h1>Individual Advising</h1>
		<h2>Select Advisor</h2>
	    <div class="field">
		<form action="08StudSelectTime.php" method="post" name="SelectAdvisor">
	    <?php


  $sql2 = "select distinct `AdvisorId` from Proj2Appointments WHERE `Max` = 1 and `EnrolledNum` = 0 and (`Major` like '%$localMaj%' or `Major` = '') and `Time` > '".date('Y-m-d H:i:s', strtotime('+24 hours'))."'";
$rs2 = $COMMON->executeQuery($sql2, $_SERVER["SCRIPT_NAME"] );

if($rs2){
while($rows = mysql_fetch_row($rs2)){
  $sql3 = "select * from Proj2Advisors WHERE `id`=$rows[0]";
  $rs3 = $COMMON->executeQuery($sql3, $_SERVER["SCRIPT_NAME"] );
  $row = mysql_fetch_row($rs3);
	echo "<label for='$row[0]'><input id='$row[0]' type='radio' name='advisor' required value=$row[0]>$row[1] $row[2]</label><br>";	
}

echo('<div class="nextButton">
    <input type="submit" name="next" class="button large go" value="Next">
    </div>');

}
else{
  echo("No advisors available for individual appointments.");
}


		?>
        </div>

		</form>
		<div>
		<form method="link" action="03StudSelectType.php">
		<input type="submit" name="home" class="button large" value="Back">
		</form>
		</div>
  </body>
</html>