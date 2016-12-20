<?php
session_start();
$debug = false;
include('../CommonMethods.php');
$COMMON = new Common($debug);

if($_POST["finish"] == 'Cancel'){
	$_SESSION["status"] = "none";
}
else{

	// mysql_real_escape_string( to protect from MySQL injection)
	$firstn = mysql_real_escape_string($_SESSION["firstN"]);
	$lastn = mysql_real_escape_string($_SESSION["lastN"]);
	$studid = mysql_real_escape_string($_SESSION["studID"]);
	$major = mysql_real_escape_string($_SESSION["major"]);
	$email = mysql_real_escape_string($_SESSION["email"]);
	$advisor = $_SESSION["advisor"];

	if($debug) { echo("Advisor -> $advisor<br>\n"); }

	$appointment = $_SESSION["appointment"];


	if(!isset($_SESSION["firstN"])) // for some reason, some empty rows getting placed
	{
			header('Location: index.php');
	}
	else if($_SESSION["studExist"] == false) 
	{
		$sql = "insert into Proj2Students (`FirstName`,`LastName`,`StudentID`,`Email`,`Major`) values ('$firstn','$lastn','$studid','$email','$major')";
		$rs = $COMMON->executeQuery($sql, $_SERVER["SCRIPT_NAME"]);
	}


	// ************************ Lupoli 9-1-2015
	// we have to check to make sure someone did not steal that spot just before them!! (deadlock)
	// if the spot was taken, need to stop and reset
	if( isStillAvailable($appointment, $advisor) ) // then good, take that spot
	{ } 
	else // spot was taken, tell them to pick another
	{
		if($debug == false) 
		{
			header('Location: 13StudDenied.php');
			return;
		}
	}

	
	//regular new schedule
	if($_POST["finish"] == 'Submit'){	
	// student scheduled for an individual session
	  $sql = "select * from Proj2Appointments where `id` = $appointment";
	  $rs = $COMMON->executeQuery($sql, $_SERVER["SCRIPT_NAME"]);
	  $row = mysql_fetch_row($rs);
	  $groupids = trim($row[4]);

	  $sql = "update `Proj2Appointments` set `EnrolledNum` = EnrolledNum+1, `EnrolledID` = '$groupids  $studid' where `id` = $appointment";
	  $rs = $COMMON->executeQuery($sql, $_SERVER["SCRIPT_NAME"]);
			
		
	
		$_SESSION["status"] = "complete";
	}
	elseif($_POST["finish"] == 'Reschedule'){
		//remove stud from EnrolledID
		$sql = "select * from Proj2Appointments where `EnrolledID` like '%$studid%'";
		$rs = $COMMON->executeQuery($sql, $_SERVER["SCRIPT_NAME"]);
		$row = mysql_fetch_row($rs);
		$oldAdvisorID = $row[2];
		$oldAppTime = $row[1];
		$newIDs = trim(str_replace($studid, "", $row[4]));
		
		$sql = "update `Proj2Appointments` set `EnrolledNum` = EnrolledNum-1, `EnrolledID` = '$newIDs' where `AdvisorID` = '$oldAdvisorID' and `Time` = '$oldAppTime'";
		$rs = $COMMON->executeQuery($sql, $_SERVER["SCRIPT_NAME"]);
	

	$sql = "select * from Proj2Appointments where `id` = $appointment";
	$rs = $COMMON->executeQuery($sql, $_SERVER["SCRIPT_NAME"]);
	$row = mysql_fetch_row($rs);                              
	$groupids = trim($row[4]);    

	$sql = "update `Proj2Appointments` set `EnrolledNum` = EnrolledNum+1, `EnrolledID` = '$groupids $studid' where `id` = $appointment";
	$rs = $COMMON->executeQuery($sql, $_SERVER["SCRIPT_NAME"]);
	
}
		$_SESSION["status"] = "resch";
	}

	//update stud status to ''
	$sql = "update `Proj2Students` set `Status` = '' where `StudentID` = '$studid'";
	$rs = $COMMON->executeQuery($sql, $_SERVER["SCRIPT_NAME"]);

if($debug == false) { header('Location: 12StudExit.php'); }



function isStillAvailable($appointment, $advisor)
{
	// advisor could be "Group"
	global $debug; global $COMMON;
	$sql = "";

	$sql = "select * from `Proj2Appointments` where `id` = $appointment";
	$rs = $COMMON->executeQuery($sql, $_SERVER["SCRIPT_NAME"]);
	$row = mysql_fetch_row($rs);

	// if max [1] =< EnrolledNum[0], then the spot was indeed taken
	if($row[6] > $row[5]) // then all good
	{ 
		if($debug) { echo("spot available\n<br>"); }
		return true; 
	}
	else // spot was taken
	{
		if($debug) { echo("spot NOT available\n<br>"); }	
		return false; 
	}

}

?>


