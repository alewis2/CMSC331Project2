<?php

/* Had to make sure sessions was enabled. Some help here:

https://wiki.umbc.edu/pages/viewpage.action?pageId=46563550

cd /afs/umbc.edu/public/web/sites/coeadvising/prod/php/session/

/usr/bin/fs sa /afs/umbc.edu/public/web/sites/coeadvising/prod/php/session/ web.coeadvising all


then edit .htaccess file here in the same directory

*/


session_start();

include('../CommonMethods.php');
$debug = false;
$Common = new Common($debug);

$_SESSION["UserN"] = strtoupper($_POST["UserN"]);
$_SESSION["PassW"] = md5($_POST["PassW"]);   // MD5 here!!!!!!!
$_SESSION["UserVal"] = false;

$user = $_SESSION["UserN"];
$pass = $_SESSION["PassW"];

$sql = "SELECT * FROM `Proj2Advisors` WHERE `Username` = '$user' AND `Password` = '".$pass."'";
$rs = $Common->executeQuery($sql, "Advising Appointments");
$row = mysql_fetch_row($rs);

if($row){
	if($debug) { echo("<br>".var_dump($_SESSION)."<- Session variables above<br>"); }
	else 
	{ 
		if($debug == false) { header('Location: AdminUI.php'); }
		else { echo("accepted"); }
	}
}
else{
	$_SESSION["UserVal"] = true;
	
	if($debug == false) 
	{ 
		header('Location: AdminSignIn.php');  

	}
	else { echo("not accepted"); }
}

?>