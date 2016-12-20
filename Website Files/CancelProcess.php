<?php
session_start();
//$debug = false;
//include('../CommonMethods.php');
//$COMMON = new Common($debug);


//$firstn = $_SESSION["firstN"];
//$lastn = $_SESSION["lastN"];
//$studid = $_SESSION["studID"];
//$major = $_SESSION["major"];
//$email = $_SESSION["email"];

$studEmail = "schu1@umbc.edu";

//$sql = "select `EnrolledID` from `Proj2Appoints` where `AdvisorID`";
//$rs = $COMMON->executeQuery($sql, $_SERVER["SCRIPT_NAME"]);
//$row = mysql_fetch_row($rs);
//$oldAdvisorID = $row[2];
//$oldAppTime = $row[1];
//$newIDs = str_replace($studid, "", $row[4]);

//$sql = "update `Proj2Appointments` set `EnrolledNum` = EnrolledNum-1, `EnrolledID` = '$newIDs' where `AdvisorID` = '$oldAdvisorID' and `Time` = '$oldAppTime'";
//$rs = $COMMON->executeQuery($sql, $_SERVER["SCRIPT_NAME"]);

$msg = "test";
//$msg = wordwrap($msg, 70);



mail($studEmail, "COEIT Advising - Changes to your advising schedule.", $msg);

//if(){


//}

?>