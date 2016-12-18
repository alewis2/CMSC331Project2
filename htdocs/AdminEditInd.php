<?php
session_start();
$debug = false;
include('../CommonMethods.php');
$COMMON = new Common($debug);

?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <title>Edit Individual Appointment</title>
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
          <h2>Select which appointment you would like to change: </h2>
		  <div class="field">
		  
          <?php


            $sql = "SELECT * FROM `Proj2Appointments` WHERE `AdvisorID` != '0' and `Time` > '".date('Y-m-d H:i:s')."' ORDER BY `Time`";
$rs = $COMMON->executeQuery($sql, "Advising Appointments"); 


            
if($rs != null){
  echo("<form action=\"AdminConfirmEditInd.php\" method=\"post\" na\
me=\"Confirm\">");

  // Table begins                                                   
  echo("<table>");
  echo("<tr class='tableTop'><td width='300px'>Time</td><td width='\
150px'>Majors</td><td>Students</td></tr>\n");
  
  while($row = mysql_fetch_array($rs)){
    $secsql = "SELECT `FirstName`, `LastName` FROM `Proj2Advisors` WHERE `id` = '$row[2]'";
    $secrs = $COMMON->executeQuery($secsql, "Advising Appointments");
    $secrow = mysql_fetch_row($secrs);

    if($row[4]){
                $trdsql = "SELECT `FirstName`, `LastName` FROM `Proj2Students` WHERE `StudentID` = '$row[4]'";
                $trdrs = $COMMON->executeQuery($trdsql, "Advising Appointments");
                $trdrow = mysql_fetch_row($trdrs);
    }

    // Time and Advisor
    echo("<tr><td>");

    // MEssing around with this
    echo("<label for='$row[0]'><input type=\"checkbox\" id='$row[0]' name=\"IndApp\" required value=\"row[]=$row[1]&row[]=$secrow[0]&row[]=$secrow[1]&row[]=$row[3]&row[]=$row[4]\">");
    echo(" ".date('l, F d, Y g:i A', strtotime($row[1])). "</label><br>
(Advisor: ".getAdvisorName($row[2]).")<br>");

    echo("<td>");
    if($row[3]){
      echo("$row[3]");
    }
    else{
      echo("Available to all majors");
    }
    echo("</td>");


    if($row[4]){ 
      echo("<td>$trdrow[0] $trdrow[1]</td>");
    }
    else{
      echo("<td>Empty</td>");
    }
    echo("</tr>");


}
  echo("</table>");

  
              echo("<div class=\"nextButton\">");
              echo("<input type=\"submit\" name=\"next\" class=\"button large go\" value=\"Delete Appointment\">");
              echo("</div>");
			  echo("</form>");
			  echo("<form method=\"link\" action=\"AdminUI.php\">");
              echo("<input type=\"submit\" name=\"next\" class=\"button large\" value=\"Cancel\">");
              echo("</form>");
            }
            else{
              echo("<br><b>There are currently no individual appointments scheduled at the current moment.</b>");
              echo("<br><br>");
			  echo("</td</tr>");
              echo("<form method=\"link\" action=\"AdminUI.php\">");
              echo("<input type=\"submit\" name=\"next\" class=\"button large go\" value=\"Return to Home\">");
              echo("</form>");
            }
          ?>
		  
	</div>
	</div>
	<div class="bottom">
		<p style='color:red'>Please note that individual appointments can only be removed from schedule.</p>
	</div>
	</div>
	<?php include('./workOrder/workButton.php'); ?>

	</div>
  </body>
  
</html>

<?php

function getAdvisorName($id)
{
	global $debug; global $COMMON;
	
	$sql = "SELECT * FROM `Proj2Advisors` WHERE `id` = $id";
        $rs = $COMMON->executeQuery($sql, "Advising Appointments");
        $row = mysql_fetch_array($rs); 
	return $row[1]." ".$row[2];
}

?>
