<?php 

class Common
{	
	var $conn;
	var $debug; // this is set by a initiated value in the constructor
			
	function Common($debug)
	{
		$this->debug = $debug; 
		$rs = $this->connect("XXXXX"); // db name really here
		return $rs;
	}

// %%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%% */
	
	function connect($db)// connect to MySQL
	{
		$conn = @mysql_connect("XXXX", "XXXXX", "XXXXX") or die("<br> Could not connect to MySQL <br>");
		$rs = @mysql_select_db("XXXXX", $conn) or die("<br> Could not connect to $db database <br>");
		$this->conn = $conn; 
	}

// %%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%% */
	
	function executeQuery($sql, $filename) // execute query
	{
		if($this->debug == true) { echo("$sql <br>\n"); }
		$rs = mysql_query($sql, $this->conn) or die("<br> Could not execute query '$sql' in $filename <br>"); 
		return $rs;
	}			

} // ends class, NEEDED!!

?>
