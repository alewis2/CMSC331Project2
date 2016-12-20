<?php
session_start();
$debug = false;
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <title>Print Schedule</title>
    <script type="text/javascript">
    function saveValue(target){
	var stepVal = document.getElementById(target).value;
	alert("Value: " + stepVal);
    }
    </script>
	<link rel='stylesheet' type='text/css' href='./css/standard.css'/>
 </head>
  <body>
    <div id="login">
      <div id="form">
        <div class="top">

<?php

	$date = $_POST["date"];
	$type = $_POST["type"];
			
	include('../CommonMethods.php');
	$COMMON = new Common($debug);


      $User = $_SESSION["UserN"];

      $sql = "SELECT `id`, `firstName`, `lastName` FROM `Proj2Advisors` WHERE `Username` = '$User'";
      $rs = $COMMON->executeQuery($sql, "Advising Appointments");
      $row = mysql_fetch_row($rs);
      $id = $row[0];
      $FirstName = $row[1];
      $LastName = $row[2];
		
			echo("<h2>Schedule for $FirstName $LastName<br>$date</h2>");
      $date = date('Y-m-d', strtotime($date));
	

	// these are for printing simple door placards - 3/19/16
	$gPrint = false; // group printing
	$iPrint = false; // individual printing

	if($_POST["type"] == 'Both')
	{
		$gPrint = displayGroup($id, $date);
		$iPrint = displayIndividual($id, $date);
	}
	elseif($_POST["type"] == 'Individual') { $iPrint = displayIndividual($id, $date); }
	elseif($_POST["type"] == 'Group') { $gPrint = displayGroup($id, $date); }
	else { echo("Selection invalid"); }

?>
	<form method="link" action="AdminUI.php">
	<input type="submit" name="next" class="button large go" value="Return to Home"><br>
	<input type="button" name="print" class="button large go" value="Print above" onClick="window.print()"><br>
	<?php

	if($iPrint) { echo("<input type='button' name='print' class='button large go' value='Print Individual Door Placard' onClick='window.open(\"AdminPrintSimpleIndividualResults.php?date=$date\")'><br>"); }
	if($gPrint) { echo("<input type='button' name='print' class='button large go' value='Print Group Door Placard' onClick='window.open(\"AdminPrintSimpleGroupResults.php?date=$date\")'><br>"); }

	?>	
	</form>

	</div>
	</div>
	<?php include('./workOrder/workButton.php'); ?>
	</div>

  </body>
  
</html>


<?php

function displayGroup($id, $date)
{
	global $debug; global $COMMON;

	$sql = "SELECT `Time`, `Major`, `EnrolledID`, `EnrolledNum`, `Max` FROM `Proj2Appointments` 
	WHERE `Time` LIKE '$date%' AND `AdvisorID` = 0 AND `MAX` > 1 ORDER BY `Time` ";

	// ******************************************************************
	// Why is Advisor ID 0 above?? (and not id)
	// This is so everyone on staff can see it when viewing a schedule
	// Then only one advisor can schedule the group sessions
	// Lupoli - 8/18/15
	// ******************************************************************


       	$rs = $COMMON->executeQuery($sql, "Advising Appointments");
	$matches = mysql_num_rows($rs); // see how many rows were collected by the query
	if($debug) { echo("matches was $matches"); }
	if($matches == 0) { return false; }

	echo("<h3>Group Appointments:</h3>");
	echo("<table border='1' width='600px'><th colspan='4'>Group Appointments</th>\n");
	echo("<tr><td width='60px'>Time:</td><td width='225px'>students enrolled</td><td width='50px'># of seats</td></tr>\n");

        while ($row = mysql_fetch_array($rs, MYSQL_NUM)) 
	{
		echo("<tr>");
		echo("<td>".date('g:i A', strtotime($row[0]))."</td>");

		#row[1] is too long
		$result = str_replace("Computer", "<br>Computer", trim($row[1]));

                 // echo("<td>".$result."</td>");  NO LONGER WANTED 10/10/16

		// from Josh's request on 10/7/15, print names too
		// $row[2] should have list of IDs
		


		echo("<td>(".$row[3].")<br>".getIndividualStudentNames($row[2])."</td>");
		//echo("<td>(".$row[3].")<br>".$row[2]."</td>");

		echo("<td>".$row[4]."</td>");
		echo("</tr>\n");
	}
        echo("</table><br><br>\n");
	return true;
}

function displayIndividual($id, $date)
{
	global $debug; global $COMMON;

        $sql = "SELECT `Time`, `Major`, `EnrolledID` FROM `Proj2Appointments` 
        WHERE `Time` LIKE '$date%' AND `AdvisorID` = $id AND `MAX` = 1 ORDER BY `Time`";
        $rs = $COMMON->executeQuery($sql, "Advising Appointments");
	$matches = mysql_num_rows($rs); // see how many rows were collected by the query
	if($debug) { echo("matches was $matches"); }
	if($matches == 0) { return false; }

	echo("<h3>Individual Appointments:</h3>");
	echo("<table border='1' width='600px'><th colspan='4'>Individual Appointments</th>\n");
	echo("<tr><td width='60px'>Time:</td><td width='225px'>Student's name</td><td>Student ID</td></tr>\n");

        while ($row = mysql_fetch_array($rs, MYSQL_NUM)) 
	{
		echo("<tr>");
		echo("<td>".date('g:i A', strtotime($row[0]))."</td>");
                //echo("<td>".$row[1]."</td>"); NO LONGER WANTED as of 10/10/16

		// %%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%% 11/8/15 %%%%%%%%%%%%%%%%%%%%%%%%%%%%
		// Had a weird issue where a user's STudent ID was not entered. This would search for a studentID of "" which matched that 
		// one outlier student with no studentID
		// fixed
		// %%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%% 11/8/15 %%%%%%%%%%%%%%%%%%%%%%%%%%%%
		
		if(empty($row[2])) { echo("<td></td><td></td>"); }
		else
		{
		        $trdsql = "SELECT `FirstName`, `LastName`, `Major` FROM `Proj2Students` WHERE `StudentID` = '$row[2]'";
        		$trdrs = $COMMON->executeQuery($trdsql, "Advising Appointments");
			$trdrow = mysql_fetch_row($trdrs);
			echo("<td>".$trdrow[0]." ".$trdrow[1]." (".$trdrow[2].")</td>");
			echo("<td>".$row[2]."</td>");
		}

		echo("</tr>");
	}
        echo("</table><br><br>");
	return true;
}


function getIndividualStudentNames($array)
{
	global $debug; global $COMMON;

	$results = array_filter(explode(" ", $array));
	
	if($debug) { var_dump($results); }

	$string = "";

	foreach($results as $element)
	{
		
        	$sql = "SELECT `FirstName`, `LastName` , `Major` FROM `Proj2Students` WHERE `StudentID` = '$element'";
	        $rs = $COMMON->executeQuery($sql, "Advising Appointments");
        	$row = mysql_fetch_array($rs, MYSQL_NUM);
		$string .= $row[0]." ".$row[1]." (".$row[2].") --> (<b>$element</b>)<br>";
		
	}

	return $string;

}

?>
