<?php
session_start();
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
			
			$debug = true;
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
			if($_POST["type"] == 'Both'){
				echo("<h3>Group Appointments:</h3>");

				$sql = "SELECT `Time`, `Major`, `EnrolledNum`, `Max` FROM `Proj2Appointments` 
				WHERE `Time` LIKE '$date%' AND `AdvisorID` = $id AND `MAX` > 1 ORDER BY `Time` ";
        $rs = $COMMON->executeQuery($sql, "Advising Appointments");


	echo("<table border='1'><th colspan='4'>Group Appointments</th>\n");
	echo("<tr><td width='60px'>Time:</td><td>Majors Included:</td><td>students enrolled</td><td>Number of seats</td></tr>\n");

        while ($row = mysql_fetch_array($rs, MYSQL_NUM)) 
	{
		echo("<tr>");
		echo("<td>".date('g:i A', strtotime($row[0]))."</td>");
                echo("<td>".$row[1]."</td>");
		echo("<td>".$row[2]."</td>");
		echo("<td>".$row[3]."</td>");
		echo("</tr>");
	}
        echo("</table><br><br>");

/*	THIS SECTION REPLACED BY LUPOLI 8/18/15 for immediately above


        $row = mysql_fetch_array($rs, MYSQL_NUM); 
        if($row){
	
		
		echo("<table><th>Group Appointments</th>");


          echo("Time: ". date('l, F d, Y g:i A', strtotime($row[0])). "<br>Majors Included: ");
          if($row[1]){
            echo("$row[1] <br> Number of students enrolled: $row[2] <br> Number of seats: $row[3]"); 
          }
          else{
            echo("Available to all majors <br> Number of students enrolled: $row[2] <br> Number of seats: $row[3]"); 
          }
          echo("<br><br>");
          while ($row = mysql_fetch_array($rs, MYSQL_NUM)) {
            echo("Time: ". date('l, F d, Y g:i A', strtotime($row[0])). "<br>Majors Included: ");
            if($row[1]){
              echo("$row[1] <br> Number of students enrolled: $row[2] <br> Number of seats: $row[3]"); 
            }
            else{
              echo("Available to all majors <br> Number of students enrolled: $row[2] <br> Number of seats: $row[3]"); 
            }
            echo("</table><br><br>");
          }
        }
        else{
          echo("No results found");
          echo("<br><br>");
        }

*/

	echo("<h3>Individual Appointments:</h3>");
        $sql = "SELECT `Time`, `Major`, `EnrolledID` FROM `Proj2Appointments` 
        WHERE `Time` LIKE '$date%' AND `AdvisorID` = $id AND `MAX` = 1 ORDER BY `Time`";
        $rs = $COMMON->executeQuery($sql, "Advising Appointments");

	echo("<table border='1'><th colspan='4'>Individual Appointments</th>\n");
	echo("<tr><td width='60px'>Time:</td><td>Majors Included:</td><td>Student's name</td><td>Student ID</td></tr>\n");

        while ($row = mysql_fetch_array($rs, MYSQL_NUM)) 
	{
		echo("<tr>");
		echo("<td>".date('g:i A', strtotime($row[0]))."</td>");
                echo("<td>".$row[1]."</td>");
	        $trdsql = "SELECT `FirstName`, `LastName` FROM `Proj2Students` WHERE `StudentID` = '$row[2]'";
        	$trdrs = $COMMON->executeQuery($trdsql, "Advising Appointments");
		$trdrow = mysql_fetch_row($trdrs);
		echo("<td>".$trdrow[0]." ".$trdrow[1]."</td>");
		echo("<td>".$row[3]."</td>");
		echo("</tr>");
	}
        echo("</table><br><br>");



/*


        $row = mysql_fetch_array($rs, MYSQL_NUM);
        if($row){
          echo("Time: ". date('l, F d, Y g:i A', strtotime($row[0])). "<br>Majors included: "); 
          if($row[1]){
            echo("$row[1] <br> "); 
          }
          else{
            echo("Available to all majors <br> "); 
          }
          if($row[2]){
            $trdsql = "SELECT `FirstName`, `LastName` FROM `Proj2Students` WHERE `StudentID` = '$row[2]'";
            $trdrs = $COMMON->executeQuery($trdsql, "Advising Appointments");
            $trdrow = mysql_fetch_row($trdrs);
            echo("Enrolled: $trdrow[0] $trdrow[1]");
          }
          else{
            echo("Enrolled: Empty");
          }
          echo("<br><br>");
          while ($row = mysql_fetch_array($rs, MYSQL_NUM)){
            echo("Time: ". date('l, F d, Y g:i A', strtotime($row[0])). "<br>Majors Included: "); 
            if($row[1]){
              echo("$row[1] <br> "); 
            }
            else{
              echo("Available to all majors <br> "); 
            }
            if($row[2]){
              $trdsql = "SELECT `FirstName`, `LastName` FROM `Proj2Students` WHERE `StudentID` = '$row[2]'";
              $trdrs = $COMMON->executeQuery($trdsql, "Advising Appointments");
              $trdrow = mysql_fetch_row($trdrs);
              echo("Enrolled: $trdrow[0] $trdrow[1]");
            }
            else{
              echo("Enrolled: Empty");
            }
            echo("<br><br>");
          }
        }
        else{
          echo("No results found");
          echo("<br><br>");
        }
			}

			elseif($_POST["type"] == 'Individual'){
        echo("<h3>Individual Appointments for $FirstName $LastName:</h3>");
        $sql = "SELECT `Time`, `Major`FROM `Proj2Appointments` 
        WHERE `Time` LIKE '$date%' AND `AdvisorID` = '$id' ORDER BY `Time`";
        $rs = $COMMON->executeQuery($sql, "Advising Appointments");
        $row = mysql_fetch_array($rs, MYSQL_NUM);
        if($row){
          echo("Time: ". date('l, F d, Y g:i A', strtotime($row[0])). "<br>Majors Included: "); 
          if($row[1]){
            echo("$row[1] <br> "); 
          }
          else{
            echo("Available to all majors <br> "); 
          }
          if($row[2]){
            $trdsql = "SELECT `FirstName`, `LastName` FROM `Proj2Students` WHERE `StudentID` = '$row[2]'";
            $trdrs = $COMMON->executeQuery($trdsql, "Advising Appointments");
            $trdrow = mysql_fetch_row($trdrs);
            echo("Enrolled: $trdrow[0] $trdrow[1]");
          }
          else{
            echo("Enrolled: Empty");
          }
          echo("<br><br>");
          while ($row = mysql_fetch_array($rs, MYSQL_NUM)){
            echo("Time: ". date('l, F d, Y g:i A', strtotime($row[0])). "<br>Majors Included: "); 
            if($row[1]){
              echo("$row[1] <br> "); 
            }
            else{
              echo("Available to all majors <br> "); 
            }
            if($row[2]){
              $trdsql = "SELECT `FirstName`, `LastName` FROM `Proj2Students` WHERE `StudentID` = '$row[2]'";
              $trdrs = $COMMON->executeQuery($trdsql, "Advising Appointments");
              $trdrow = mysql_fetch_row($trdrs);
              echo("Enrolled: $trdrow[0] $trdrow[1]");
            }
            else{
              echo("Enrolled: Empty");
            }
            echo("<br><br>");
          }
        }
        else{
          echo("No results found");
          echo("<br><br>");
        }
			}

			elseif($_POST["type"] == 'Group'){
				echo("<h3>Group Appointments:</h3>");
        $sql = "SELECT `Time`, `Major`, `EnrolledNum`, `Max` FROM `Proj2Appointments` 
        WHERE `Time` LIKE '$date%' AND `AdvisorID` = '0' ORDER BY `Time`";
        $rs = $COMMON->executeQuery($sql, "Advising Appointments");
        $row = mysql_fetch_array($rs, MYSQL_NUM);
        if($row){
          echo("Time: ". date('l, F d, Y g:i A', strtotime($row[0])). "<br>Majors Included: ");
          if($row[1]){
            echo("$row[1] <br> Number of students enrolled: $row[2] <br> Number of seats: $row[3]"); 
          }
          else{
            echo("Available to all majors <br> Number of students enrolled: $row[2] <br> Number of seats: $row[3]"); 
          }
          echo("<br><br>");
          while ($row = mysql_fetch_array($rs, MYSQL_NUM)) {
            echo("Time: ". date('l, F d, Y g:i A', strtotime($row[0])). "<br>Majors Included: ");
            if($row[1]){
              echo("$row[1] <br> Number of students enrolled: $row[2] <br> Number of seats: $row[3]"); 
            }
            else{
              echo("Available to all majors <br> Number of students enrolled: $row[2] <br> Number of seats: $row[3]"); 
            }
            echo("<br><br>");
          }
        }
        else{
          echo("No results found");
          echo("<br><br>");
        }

/*
		}

		?>
		<form method="link" action="AdminUI.php">
			<input type="submit" name="next" class="button large go" value="Return to Home">
		</form>
	</div>
	</div>
	</div>
	</form>
  </body>
  
</html>
