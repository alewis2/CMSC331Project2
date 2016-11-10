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

	window.print();
	setTimeout(window.close, 0);

    </script>
  </head>
  <body>
<?php

	$date = $_GET["date"];
			
	include('../CommonMethods.php');
	$COMMON = new Common($debug);


      $User = $_SESSION["UserN"];

      $sql = "SELECT `id`, `firstName`, `lastName` FROM `Proj2Advisors` WHERE `Username` = '$User'";
      $rs = $COMMON->executeQuery($sql, "Advising Appointments");
      $row = mysql_fetch_row($rs);
      $id = $row[0];
      $FirstName = $row[1];
      $LastName = $row[2];
      $office = $row[5];

      $dateTitle = date('l m-d-Y', strtotime($date));		
      echo("<center><h2>Group Advising<br>$day $dateTitle</h2><br>");

      $date = date('Y-m-d', strtotime($date));

      displayGroup($id, $date);
?>
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

	echo("<table border='1' width='900px'>\n");
	echo("<tr><td width='80px'>Time:</td><td>Students Enrolled</td></tr>\n");

        while ($row = mysql_fetch_array($rs, MYSQL_NUM)) 
	{
		echo("<tr>");
		echo("<td>".date('g:i A', strtotime($row[0]))."</td>");

		// from Josh's request on 10/7/15, print names too
		// $row[2] should have list of IDs
		
		echo("<td>($row[3] out of $row[4])<br>".getIndividualStudentNames($row[2])."</td>");
		echo("</tr>\n");
	}
        echo("</table><br><br>\n");
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
		
        	$sql = "SELECT `FirstName`, `LastName` FROM `Proj2Students` WHERE `StudentID` = '$element'";
	        $rs = $COMMON->executeQuery($sql, "Advising Appointments");
        	$row = mysql_fetch_array($rs, MYSQL_NUM);
		$string .= $row[0]." ".$row[1]."<br>";
		
	}

	return $string;

}

?>
