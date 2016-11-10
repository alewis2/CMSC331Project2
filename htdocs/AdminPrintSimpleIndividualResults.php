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

      $sql = "SELECT `id`, `firstName`, `lastName`, `room` FROM `Proj2Advisors` WHERE `Username` = '$User'";
      $rs = $COMMON->executeQuery($sql, "Advising Appointments");
      $row = mysql_fetch_row($rs);
      $id = $row[0];
      $FirstName = $row[1];
      $LastName = $row[2];
      $office = $row[3];

      $dateTitle = date('l m-d-Y', strtotime($date));		
      echo("<center><h1><b>Schedule for $FirstName $LastName<br>$day $dateTitle<br>$office<br></b></h1><h2>");

      $date = date('Y-m-d', strtotime($date));

      displayIndividual($id, $date);
?>
  </body>
  
</html>


<?php

function displayIndividual($id, $date)
{
	global $debug; global $COMMON;

        $sql = "SELECT `Time`, `Major`, `EnrolledID` FROM `Proj2Appointments` 
        WHERE `Time` LIKE '$date%' AND `AdvisorID` = $id AND `MAX` = 1 ORDER BY `Time`";
        $rs = $COMMON->executeQuery($sql, "Advising Appointments");
	$matches = mysql_num_rows($rs); // see how many rows were collected by the query
	if($debug) { echo("matches was $matches"); }
	if($matches == 0) { return false; }

	echo("<table border='1' width='600px'><th colspan='2'>Individual Appointments</th>\n");
	echo("<tr><td width='130px'>Time:</td><td>Student's name</td></tr>\n");

        while ($row = mysql_fetch_array($rs, MYSQL_NUM)) 
	{
		echo("<tr>");
		echo("<td>".date('g:i A', strtotime($row[0]))."</td>");

		// %%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%% 11/8/15 %%%%%%%%%%%%%%%%%%%%%%%%%%%%
		// Had a weird issue where a user's STudent ID was not entered. This would search for a studentID of "" which matched that 
		// one outlier student with no studentID
		// fixed
		// %%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%% 11/8/15 %%%%%%%%%%%%%%%%%%%%%%%%%%%%
		
		if(empty($row[2])) { echo("<td></td>"); }
		else
		{
		        $trdsql = "SELECT `FirstName`, `LastName` FROM `Proj2Students` WHERE `StudentID` = '$row[2]'";
        		$trdrs = $COMMON->executeQuery($trdsql, "Advising Appointments");
			$trdrow = mysql_fetch_row($trdrs);
			echo("<td>".$trdrow[0]." ".$trdrow[1]."</td>");
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
		
        	$sql = "SELECT `FirstName`, `LastName` FROM `Proj2Students` WHERE `StudentID` = '$element'";
	        $rs = $COMMON->executeQuery($sql, "Advising Appointments");
        	$row = mysql_fetch_array($rs, MYSQL_NUM);
		$string .= $row[0]." ".$row[1]." (<b>$element</b>)<br>";
		
	}

	return $string;

}

?>
