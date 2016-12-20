<?php
session_start();
$_SESSION["Delete"] = false;
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <title>Edit Group Appointment</title>
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
          <h1>Edit Group Appointment</h1>
		  <h2>Select an appointment to change</h2>
		  <div class="field">
          <?php
            $debug = false;
            include('../CommonMethods.php');
            $COMMON = new Common($debug);

            $sql = "SELECT * FROM `Proj2Appointments` WHERE `Max` > '1' ORDER BY `Time` LIMIT 30";
            $rs = $COMMON->executeQuery($sql, "Advising Appointments");
            
if($rs != null){
  echo("<form action=\"AdminProcessEditGroup.php\" method=\"post\" name=\"Confirm\">");
  
  echo("<table>");
  echo("<tr class='tableTop'><td width='330px'>Time</td><td width='100px'>Majors</td><td width='10px'>Students Enrolled</td><td width='10px'>Max Enrollment</td></tr>\n");

  while($row = mysql_fetch_array($rs)){
    echo("<tr><td>  <label for='$row[0]'><input type=\"radio\" id='$row[0]' name=\"GroupApp\" required value=\"row[]=$row[1]&row[]=$row[3]&row[]=$row[5]&row[]=$row[6]\">");
    echo(" ".date('l, F d, Y g:i A', strtotime($row[1])). "</label>
(Advisor: ".getAdvisorName($row[2]).")<br><br>");

    if($row[3]){
      echo("<td>".$row[3]."</td>"); 
    }
    else{
      echo("<td>Available to all majors</td>"); 
    }
  
    echo("<td>$row[5]</td><td>$row[6]");
    echo("</label>");
    echo("</form>");
 
    echo("</td></tr>\n");
  }

  echo("</table><br><br>");

  echo("<div class=\"nextButton\">");
  echo("<input type=\"submit\" name=\"next\" class=\"button large\" value=\"Edit Appointment\">");
  echo("<input style=\"margin-left: 10px\" type=\"submit\" name=\"next\" class=\"button large\" value=\"Delete Appointment\">");
  echo("</div>");
}
else{
  echo("There are currently no group meetings available.");
}

  echo("</form>");
  echo("<form method=\"link\" action=\"AdminUI.php\">");
  echo("<br><br><input type=\"submit\" name=\"next\" class=\"button large go\" value=\"Return to Home\">");
echo("</form>");

          ?>
  </div>
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