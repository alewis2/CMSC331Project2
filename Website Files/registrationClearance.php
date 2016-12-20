<?php
session_start();

$_SESSION["agreement"] = "no";
//print($_SESSION["agreement"]);

?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <title>UMBC COEIT Engineering and Computer Science Advising - Registration Clearance</title>
    <link rel='stylesheet' type='text/css' href='./css/standard.css'/>

  </head>
  <body>
    <div id="login" style="margin-top: 30px;">
        <a href="AdminSignIn.php"><div class="button large" style="margin: -40px 0px 0px 0px; padding-top: 10px; border: 3px #fff solid; border-radius: 10px;">Not a student? Advisor log-in here</div></a>
        <div class="top">
  <br><h2>Registration Clearance</h2><br>

Every semester students must meet with an advisor in order to obtain registration clearance.<br> 
Please review the following video and slide presentations prior to scheduling your appointment, so that if you have any questions they can be addressed during your appointment.<br>

<br><br><b>Reading Your Degree Audit (Video)</b><br>
<center><iframe width="560" height="315" src="https://www.youtube.com/embed/3RkgyK7PHF4?rel=0" frameborder="0" allowfullscreen></iframe></center>

<br><br>

     <a href="http://advising.coeit.umbc.edu/gateway-information/">Gateway Requirements, Repeat Policy, and necessary grades (Website) </a><br><br>
<a href="http://registrar.umbc.edu/files/2014/07/Verification-of-Transferability.pdf">Taking a Course Off-Campus (PDF)</a><br><br>

        <form action="ClearanceProcess.php" method="post" name="Clearance">
	  <h3><input type="checkbox" required name="agreement" value="yes">
<b>I have reviewed the Degree Audit video, gateway requirements, repeat policy, grade requirements, and information about withdrawing from courses.</b>
</input></h3>

<center>

	    <div class="nextButton">
<input type="submit" name="next" class="button large go" value="Schedule your advising appointment">
	    </div>
</center>
	</form>

	</div></div><br><br>
  </body>
  
</html>
