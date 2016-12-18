<?php
ini_set('display_errors','1');
ini_set('display_startup_errors','1');
error_reporting (E_ALL);

session_start();

if(isset($_POST['Room'])) // then set new password
  {
    stage2($_POST);
  }
else // nothing set yet
  {
    stage1();
  }

function stage1(){
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <title>Update Room Number</title>
        <link rel='stylesheet' type='text/css' href='./css/standard.css'/>

     <script type="text/javascript">

 </script>
  </head>
   <body>
    <div id="login">
      <div id="form">
        <div class="top">
                <h2>Update Room Number</h2>
                <form action="AdminUpdateRoom.php" method="post" name="Create">
                <div class="field">
                        <label for="Room">Room Number</label>
                        <input id="Room" size="20" maxlength="50" type="text" name="Room" required>
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

  $sql = "UPDATE `Proj2Advisors` set `MeetingRoom` = '".$_SESSION['Room']."' WHERE `Username` = '".$_SESSION['UserN']."'";
  $rs = $COMMON->executeQuery($sql, $_SERVER["SCRIPT_NAME"]);

?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <title>Update Room Number</title>
   <link rel='stylesheet' type='text/css' href='../css/standard.css'/>
     </script>
  </head>
   <body>
    <div id="login">
      <div id="form">
        <div class="top">
   <h2>Updating of Room Number Complete</h2>
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