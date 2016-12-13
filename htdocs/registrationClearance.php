<? php
session_start();

$_SESSION["agreement"] = "no";

?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <title>COEIT Engineering and Computer Science Advising - Registration Clearance</title>
    <link rel='stylesheet' type='text/css' href='./css/standard.css'/>

  </head>
  <body>
        <a href="AdminSignIn.html"><div class="button large" style="margin: 15px 500px -70px 400px; z-index: -1; border: 3px solid #fff">Not a student? Advisor log-in here</div></a>

    <div id="login" style="margin-top: 30px;">
        <div class="top">
		<h2>Registration Clearance</h2><br>

Every semester students must meet with an advisor in order to obtain registration clearance.<br> 
Please review the following video and slide presentations prior to scheduling your appointment, so that if you have any questions they can be addressed during your appointment.<br>

<br><br><b>Reading Your Degree Audit (Video)</b><br>
<center><iframe width="560" height="315" src="https://www.youtube.com/embed/3RkgyK7PHF4?rel=0" frameborder="0" allowfullscreen></iframe></center>

<br><br>

     <a href="http://advising.coeit.umbc.edu/gateway-information/">Gateway Requirements, Repeat Policy, and nessesary grades. (not PDF link yet) </a><br><br>
<a href="http://registrar.umbc.edu/files/2014/07/Verification-of-Transferability.pdf">Taking a Course Off-Campus (PDF LINK)</a><br><br>

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
