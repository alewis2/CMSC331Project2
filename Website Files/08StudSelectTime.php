<?php
session_start();
error_reporting(0);
$debug = false;
include('../CommonMethods.php');
$COMMON = new Common($debug);



if(isset($_POST["advisor"])){
  $_SESSION["advisor"] = $_POST["advisor"];

$localAdvisor = $_SESSION["advisor"];
$localMaj = $_SESSION["major"];
$localStud = $_SESSION["studID"];
$sql = "select * from Proj2Advisors where `id` = '$localAdvisor'";
$rs = $COMMON->executeQuery($sql, $_SERVER["SCRIPT_NAME"]);
$row = mysql_fetch_row($rs);
$advisorName = $row[1]." ".$row[2];}

?>

<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <title>Select Appointment</title>
	<link rel='stylesheet' type='text/css' href='./css/standard.css'/>
 </head>
  <body>
    <div id="login">
      <div id="form">
        <div class="top">
		<h1>Select Appointment Time</h1>
	    <div class="field">
		<form action = "10StudConfirmSch.php" method = "post" name = "SelectTime">
	    <?php

// http://php.net/manual/en/function.time.php fpr SQL statements below
// Comparing timestamps, could not remember. 

  $curtime = time();

if ($_SESSION["advisor"] != "Group")  // for individual conferences only
  { 
    $sql = "select * from Proj2Appointments where `EnrolledNum` = 0 and `Max` = 1 and (`Major` like '%$localMaj%' or `Major` = '') and `Time` > '".date('Y-m-d H:i:s', strtotime('+24 hours'))."' and `AdvisorID` = $localAdvisor order by `Time` ASC limit 30";
    $rs = $COMMON->executeQuery($sql, $_SERVER["SCRIPT_NAME"]);
    echo "<h2>Individual Advising</h2><br>";
    echo "<label for='prompt'>Select appointment with ",$advisorName,":</label><br>";

      echo "<table>";
      while($row = mysql_fetch_row($rs)){
	$datephp = strtotime($row[1]);
	echo "<tr><td><label for='",$row[0],"'>";
	echo "<input id='",$row[0],"' type='radio' name='appointment' required value=$row[0]>", date('l, F d, Y g:i A', $datephp),"</label></td></tr>";
    
    
  }
echo "</table>";
    

    echo('<div class="nextButton">
           <input type="submit" name="next" class="button large go" value="Next">                                                                             
           </div>                                                              
           </form>                                                             
           <div>                                                               
           <form method="link" action="07StudSelectAdvisor.php">           
           <input type="submit" name="home" class="button large" value="Back"> 
           </form>                                                             
           </div>');

    }
else // for group conferences
  {

    $sql = "select * from Proj2Appointments where `EnrolledNum` <= `Max` and `Max` > 1 and (`Major` like '%$localMaj%' or `Major` = '') and (`EnrolledID` not like '%$_SESSION[studID]%') and `Time` > '".date('Y-m-d H:i:s', strtotime('+24 hours'))."'  order by `Time` ASC limit 30";	   			  
    $rs = $COMMON->executeQuery($sql, $_SERVER["SCRIPT_NAME"]);
    echo "<h2>Group Advising</h2><br>";
    echo "<label for='prompt'>Select appointment:</label><br>";

    echo "<table>";
    while($row = mysql_fetch_row($rs)){
      $datephp = strtotime($row[1]);
      $max = $row[6];
      $enrolled = $row[5];
      
      $advsql = "select * from Proj2Advisors where `id`=$row[2]";
      $advrs = $COMMON->executeQuery($advsql, $_SERVER["SCRIPT_NAME"]);;
      $adv = mysql_fetch_row($advrs);

      echo "<tr><td class='packet'><label for='",$row[0],"'>";
      echo "<input id='",$row[0],"' type='radio' name='appointment' required value=$row[0]>", date('l, F d, Y g:i A', $datephp),"</label>";
      echo "<b>Enrolled</b>: $enrolled/$max students<br>";
      echo "<b>Advisor</b>: $adv[1] $adv[2]<br>";
      echo "<b>Location</b>: $adv[5]<br><br></td></tr>";
    }
    echo "</table>";
    echo('<div class="nextButton">
	   <input type="submit" name="next" class="button large go" value="Next">
	   </div>
	   </form>
	   <div>
	   <form method="link" action="03StudSelectType.php">
	   <input type="submit" name="home" class="button large" value="Back">
	   </form>
	   </div>');
  }
		?>
        </div>

		<div class="bottom">
		<p>Note: Appointments are maximum 30 minutes long.</p>
		<p style="color:red">If there are no more open appointments, contact your advisor or click <a href='02StudHome.php'>here</a> to start over.</p>
		</div>
  </body>
</html>