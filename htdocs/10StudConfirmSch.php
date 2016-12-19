<?php
session_start();
$_SESSION["appointment"] = $_POST["appointment"]; // radio button selection from previous form

?>

<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <title>Confirm Appointment</title>
	<link rel='stylesheet' type='text/css' href='./css/standard.css'/>  
  </head>
  <body>
	<div id="login">
      <div id="form">
        <div class="top">
		<h1>Confirm Appointment</h1>
	    <div class="field">
		<form action = "StudProcessSch.php" method = "post" name = "SelectTime">
  <?php
  $debug = false;
include('../CommonMethods.php');
$COMMON = new Common($debug);

$firstn = $_SESSION["firstN"];
$lastn = $_SESSION["lastN"];
$studid = $_SESSION["studID"];
$major = $_SESSION["major"];
$email = $_SESSION["email"];

if(($_SESSION["resch"] != null) && ($_SESSION["resch"] == true)){
$sql = "select * from Proj2Appointments where `EnrolledID` like '%$studid%'";
$rs = $COMMON->executeQuery($sql, $_SERVER["SCRIPT_NAME"]);
$oldAppointment = mysql_fetch_row($rs);

// Checking contents
//print_r(array($oldAppointment));

if($oldAppointment != null){
  $oldDatephp = strtotime($oldAppointment[1]);
  $sql2 = "select * from Proj2Advisors where `id` = $oldAppointment[2]";
  $rs2 = $COMMON->executeQuery($sql2, $_SERVER["SCRIPT_NAME"]);
  $oldAdv = mysql_fetch_row($rs2);
  $oldAdvisorName = $oldAdv[1] . " " . $oldAdv[2];
  $oldAdvisorLocation = $oldAdv[5];
  
echo "<h2>Previous Appointment</h2>";
echo "<label for='info'>";
echo "Appointment: ",date('l, F d, Y g:i A', $oldDatephp),"</label>";
echo "<b>Advisor</b>: ",$oldAdvisorName,"<br>";
echo "<b>Location</b>: $oldAdvisorLocation<br>";}
}


$sql3 = "select * from Proj2Appointments where `id` = ".$_SESSION['appointment']."";
$rs3 = $COMMON->executeQuery($sql3, $_SERVER["SCRIPT_NAME"]);
$currentAppointment = mysql_fetch_row($rs3);
$currentDatephp = strtotime($currentAppointment[1]);

$sql4 = "select * from Proj2Advisors where `id` = $currentAppointment[2]";
$rs4 = $COMMON->executeQuery($sql4, $_SERVER["SCRIPT_NAME"]);
$currentAdv = mysql_fetch_row($rs4);
$currentAdvisorName = $currentAdv[1] . " " . $currentAdv[2];
$currentAdvisorLocation = $currentAdv[5];
			
  echo "<h2>New Appointment</h2>";
  echo "<label for='newinfo'>";
  echo "Appointment: ",date('l, F d, Y g:i A', $currentDatephp),"</label>";
  echo "<b>Advisor</b>: ",$currentAdvisorName,"<br>";
  echo "<b>Location</b>: $currentAdvisorLocation<br>";

echo "<br>The appointment above will be scheduled. Continue?";
	?>
        </div>
	    <div class="nextButton">
		<?php
    if(($_SESSION["resch"] != null) && ($_SESSION["resch"] == true)){
				echo "<input type='submit' name='finish' class='button large go' value='Reschedule'>";
			}
			else{
				echo "<input type='submit' name='finish' class='button large go' value='Submit'>";
			}
		?>
			<input style="margin-left: 50px" type="submit" name="finish" class="button large" value="Cancel">
	    </div>
		</form>
		</div>
  </body>
</html>