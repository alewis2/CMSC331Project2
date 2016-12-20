<?php
session_start();
$debug = false;
include('../CommonMethods.php');
$COMMON = new Common($debug);

$studID = $_SESSION["studID"];
?>

<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <title>View Appointment</title>
	<link rel='stylesheet' type='text/css' href='./css/standard.css'/>
  </head>
  <body>
    <div id="login">
      <div id="form">
        <div class="top">
		<h1>View Appointment</h1>
	    <div class="field">
	    <?php
			$sql = "select * from Proj2Appointments where `EnrolledID` like '%$studID%'";
			$rs = $COMMON->executeQuery($sql, $_SERVER["SCRIPT_NAME"]);
			// if for some reason there really isn't a match, (something got messed up, tell them there really isn't one there)
			$num_rows = mysql_num_rows($rs);

if($num_rows > 0)
  {
    $row = mysql_fetch_row($rs); // get legit data
    $advisorID = $row[2];
    $datephp = strtotime($row[1]);
    
    
    $sql2 = "select * from Proj2Advisors where `id` = '$advisorID'";
    $rs2 = $COMMON->executeQuery($sql2, $_SERVER["SCRIPT_NAME"]);
    $row2 = mysql_fetch_row($rs2);		 
    $location = $row2[5];
    $advisorName = $row2[1] . " " . $row2[2];
    $enrolledNum = $row[5];
    $maxNum = $row[6];
					
    if($maxNum != 1){ $type = "Group";}
    else{ $type = "Individual";}
			

    echo "<label for='info'>Current Appointment</label>";
    echo ("<b>Appointment Type</b>: $type  ($enrolledNum/$maxNum enrolled)<br>");
    echo "<b>Time: </b>", date('l, F d, Y g:i A', $datephp), "<br>";
    echo "<b>Advisor</b>: ", $advisorName, "<br>";
    echo "<b>Location</b>: ", $location, "<br>";

    
    echo "         <br><div class='finishButton'>
                <form action='StudProcessHome.php' method='post' name='Home'>
<button type='submit' name='selection' class='button large selection' value='Reschedule'>Reschedule</button>
<button type='submit' name='selection' class='button large selection' value='Cancel'>Cancel appointment</button>
</form>";
			

  }
else // something is up, and there DB table needs to be fixed
  {
    echo("No appointment was detected. It may have been cancelled. Please make another appointment.");
    $sql = "update `Proj2Students` set `Status` = '' where `StudentID` = '$studID'";
    $rs = $COMMON->executeQuery($sql, $_SERVER["SCRIPT_NAME"]);
    echo("<div class='finishButton'>                                       
                <form action='StudProcessHome.php' method='post' name='Home'>   <button type='submit' name='selection' class='button large selection' value='Reschedule'>Reschedule</button></form></div>");
  }
	

?>
</div>
<div class="finishButton">
               <form method="link" action="02StudHome.php">
                <input type="submit" name="home" class="button large go" value="Return to Home">
                </form>
	    </div>
		</div>
		</form>
  </body>
</html>