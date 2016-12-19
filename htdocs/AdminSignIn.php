<?php
session_start();

//print($_SESSION['agreement']);

?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <title>COEIT Engineering and Computer Science Advising - Advisor Sign In</title>
	<link rel='stylesheet' type='text/css' href='./css/standard.css'/>
  </head>
  <body>
    <div id="login">
    <a href="01StudSignIn.php"><div class="button large" style="margin: -40px 0px 0px 0px; padding-top: 10px; border: 3px #fff solid; border-radius: 10px;">Not an advisor? Student log-in here</div></a>
   
      <div id="form">
        <div class="top">
		<h1>UMBC COEIT Engineering and Computer Science Advising</h1>
		<h2>Advisor Sign In</h2>

    <?php
    if(!empty($_SESSION['UserVal']) && $_SESSION["UserVal"] == true){
        echo "<h3 style='color:red'>Invalid Username/Password combination</h3>";
      }
    ?>
        <form action="AdminProcessSignIn.php" method="POST" name="SignIn">

	    <div class="field">
	      <label for="UserN">Username</label>
	      <input id="UserN" size="20" maxlength="50" type="text" name="UserN" required autofocus>
	    </div>

	    <div class="field">
	      <label for="PassW">Password</label>
	      <input id="PassW" size="20" maxlength="50" type="password" name="PassW" required>
	    </div>

	    <div class="nextButton">
			<input type="submit" name="next" class="button large go" value="Next">
	    </div>
	</div>
	</form>
  </body>
  
</html>
