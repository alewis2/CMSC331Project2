<?php
ini_set('display_errors','1');
ini_set('display_startup_errors','1');
error_reporting (E_ALL);

session_start();

if(isset($_POST['PassW'])) // then set new password
{
	stage2($_POST);
}
else // nothing set yet
{
	stage1();
}


// %%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%


function stage1()
{
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <title>Create New Admin</title>
	<link rel='stylesheet' type='text/css' href='./css/standard.css'/>

     <script type="text/javascript">

function checkPass()
{
    //Store the password field objects into variables ...
    var pass1 = document.getElementById('PassW');
    var pass2 = document.getElementById('ConfP');
    //Store the Confimation Message Object ...
    var message = document.getElementById('confirmMessage');
    //Set the colors we will be using ...
    var goodColor = "#66cc66";
    var badColor = "#ff6666";
    //Compare the values in the password field 
    //and the confirmation field
    if(pass1.value == pass2.value){
        //The passwords match. 
        //Set the color to the good color and inform
        //the user that they have entered the correct password 
        pass2.style.backgroundColor = goodColor;
        message.style.color = goodColor;
        message.innerHTML = "Passwords Match!"
    }else{
        //The passwords do not match.
        //Set the color to the bad color and
        //notify the user.
        pass2.style.backgroundColor = badColor;
        message.style.color = badColor;
        message.innerHTML = "Passwords Do Not Match!"
    }
} 
     </script>
  </head>
   <body>
    <div id="login">
      <div id="form">
        <div class="top">
		<h2>Update Password</h2>
		<form action="AdminUpdatePassword.php" method="post" name="Create">
		<div class="field">
	     		<label for="PassW">Password</label>
	      		<input id="PassW" size="20" maxlength="50" type="password" name="PassW" required>
	   	</div>	

		<div class="field">
	     		<label for="ConfP">Confirm Password</label>
	      		<input id="ConfP" size="20" maxlength="50" type="password" name="ConfP" onkeyup="checkPass(); return false;" required>
	   	</div>	
		<br>

		<div class="nextButton">
			<input type="submit" name="next" class="button large go" value="Submit">
	    </div>
		</form>
		<form method="link" action="AdminUI.php">
			<input type="submit" name="home" class="button large" value="Cancel">
		</form>

	</div>
	</div>
	</div>
  </body>
</html>

<?php
}


function stage2($x)
{

$debug = false;
include('../CommonMethods.php');
$COMMON = new Common($debug);

if($debug) { echo("password given is: ".$x['PassW']."."); }

$sql = "UPDATE `Proj2Advisors` set `password` = '".md5($x['PassW'])."' WHERE `Username` = '".$_SESSION['UserN']."'";
$rs = $COMMON->executeQuery($sql, $_SERVER["SCRIPT_NAME"]);

?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <title>Create New Admin</title>
	<link rel='stylesheet' type='text/css' href='../css/standard.css'/>
     </script>
  </head>
   <body>
    <div id="login">
      <div id="form">
        <div class="top">
		<h2>Updating of Password Complete</h2>
		<form method="link" action="AdminUI.php">
			<input type="submit" name="home" class="button large" value="Home">
		</form>

	</div>
	</div>
	</div>
  </body>
</html>

<?php

}