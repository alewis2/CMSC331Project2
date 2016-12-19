<?php
session_start();
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
          <h1>Removed Appointment</h1><br>
		  <div class="field">
          <?php

    if($_POST["checkbox"] == null){
      header('Location: AdminEditInd.php');
    }
    else{
      $ind = $_POST["checkbox"];
      $debug = false;
      include('../CommonMethods.php');
      $COMMON = new Common($debug);

      echo("<b>Deleted the following appointment(s): </b><br><table>");
      
      
for($x = 0; $x < count($ind); $x++){
  echo("<tr><td><br>");
    
  
  $sql = "SELECT * FROM `Proj2Appointments` WHERE `id`=$ind[$x]";
  $rs = $COMMON->executeQuery($sql, "Advising Appointments");         
  $row = mysql_fetch_row($rs);

  $sql = "SELECT * FROM `Proj2Advisors` WHERE `id`=$row[2]";
  $rs = $COMMON->executeQuery($sql, "Advising Appointments"); 
  $rod = mysql_fetch_row($rs);         
  $adv = $rod[0];                      
  $studDelete = false;                              

  echo("<b>Time: ". date('l, F d, Y g:i A', strtotime($row[1])). "</b><br>");
  echo("<b>Advisor</b>: $rod[1] $rod[2]<br>");                               
  echo("<b>Majors included</b>: ");                                          
  if($row[3]){                                                        
    echo("$row[3]<br>");                                              
  }                                                                   
  else{                                                               
    echo("Available to all majors<br>");                              
  }                                                                   
  echo("<b>Students enrolled</b>: ");   

  // Student updating + email notification
  if($row[4]){
    $sql = "SELECT `FirstName`, `LastName`, `Email` FROM `Proj2Students` WHERE `StudentID`='$row[4]'";
    $rs = $COMMON->executeQuery($sql, "Advising Appointments");
    $ros = mysql_fetch_row($rs);
    $std = $ros[0] . " " . $ros[1];
    $eml = $ros[2];
    echo("$std");
    
    $sql = "UPDATE `Proj2Students` SET `Status`='C' WHERE `StudentID`  = '$row[4]'";                         
    $rs = $COMMON->executeQuery($sql, "Advising Appointments");      
    $message = "The following appointment has been deleted by the administration of your advisor: " . "\r\n" .                                     
      "Time: $row[0]" . "\r\n" .                                     
      "Advisor: $row[1] $row[2]" . "\r\n" .                          
      "Student: $std" . "\r\n" .
      "To schedule for a new appointment, please log back into the UMBC COEIT Engineering and Computer Science Advising webpage."."\r\n"."http://coeadvising.umbc.edu  -> COEIT Advising Scheduling \r\n
 Reminder, this is only accessible on campus.";                             
    mail($eml, "Your Advising Appointment Has Been Deleted", $message);
    $studDelete = true;
  }
  else{
    echo("None");
  }

  //Deleting appointment
  $sql = "DELETE FROM `Proj2Appointments` WHERE `id`=$row[0]";  
  $rs = $COMMON->executeQuery($sql, "Advising Appointments"); 
  
  echo("</td>");
  
}
echo("</table>");
    }
			?>
			<br><br>
			<form method="link" action="AdminEditInd.php">
    <input type="submit" name="home" class="button large go" value="Return to Home">
    </form>
    </div>
    </div>    
    </div>
    <div class="bottom">
    <?php
    if($studDelete){
      echo "<p style='color:red'>Student(s) have been notified of the cancellation.</p>";
    }
?>
</div>
</div>
</form>
</body>
  
</html>
