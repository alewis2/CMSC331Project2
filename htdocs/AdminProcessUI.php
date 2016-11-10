<?php
session_start();

if($_POST["next"] == 'Schedule appointments'){
	header('Location: AdminScheduleApp.php');
}
elseif($_POST["next"] == 'Print schedule for a day'){
	header('Location: AdminPrintSchedule.php');
}
elseif($_POST["next"] == 'Edit appointments'){
	header('Location: AdminEditApp.php');
}
elseif($_POST["next"] == 'Search for an appointment'){
	header('Location: AdminSearchApp.php');
}
elseif($_POST["next"] == 'Create new Admin Account'){
	header('Location: AdminCreateNewAdv.php');
}
elseif($_POST["next"] == 'Update Password'){
	header('Location: AdminUpdatePassword.php');
}
else {  header('Location: AdminUI.php'); }







	



?>