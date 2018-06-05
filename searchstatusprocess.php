<!DOCTYPE html>
<html>
<head>
        <meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<title>Search Status Result Page</title>
</head>
    <body>
	<center><h1><font color="black">Status Information</font></h1></center>
	<br/>
	<?php
		
		if(isset($_GET["status"])) 
		{ 
        	//Get the database setting
			require_once("settings.php");
			//Set the database connection information
			$conn = mysqli_connect($host, $user, $pswd, $dbnm);

			//Set a button for user to go back to the previous page
			function returnbutton()
			{
				echo "<body>";
				echo "<form method='post' action='searchstatusform.php'>";
				echo "<br />";
				echo "<center><input type='submit' value='return' /></center>";
				echo "</form>";
				echo "</body>"; 
			}
	
			//To check database is connected or not
			if(!$conn) 
			{
				//Report error message
				echo "<center><font color='red'><p>Database connection failure</p></font></center>";
				echo "<br />";
				//Appear a button for return to the previous page 
				returnbutton();
			} 
			else 
			{
				//Check whether the table has already existed
				$conn2 = mysqli_connect($host, $user, $pswd, "information_schema");
				$queryCheckTableExists = "SELECT TABLE_NAME FROM TABLES WHERE TABLE_SCHEMA = 'ynd8757' AND TABLE_NAME = 'assign1'";
				$checkTableExists = mysqli_query($conn2, $queryCheckTableExists);
				if(mysqli_fetch_row($checkTableExists)[0] == "assign1")
				{
					//Get user input "status" information
					$status = $_GET["status"];
					//Process the "status" input information
					if(!preg_match('/^[a-zA-Z0-9 ,.!?]*$/', $status))
					{
						$status = "'";
					}
					$query = "select * from assign1 where status like '%$status%'";
					$result = mysqli_query($conn, $query);
					if(!$result) 
					{
						//Report error message
						echo "<center>Please enter the status only contain alphanumeric characters including spaces, comma, period (full stop), exclamation point and question mark</center>";
						echo "<br />";
						returnbutton();
						//echo "<p>Something is wrong with ", $query, "</p>";
					} 
					else 
					{
						//Create table to display the data
						echo "<table width='100%' border='5'>";
						echo "<tr><th>Status Code</th><th>Status</th><th>Share</th><th>Date</th><th>Permission</th></tr>";				
						while ($row = mysqli_fetch_row($result))
						{
							echo "<tr>";
							//get the "code" information from database
							if(strlen((string)$row[0]) == 1)
							{
								$row[0] = "S000" . (string)$row[0];
							}
							if(strlen((string)$row[0]) == 2)
							{
								$row[0] = "S00" . (string)$row[0];
							}
							if(strlen((string)$row[0]) == 3)
							{
								$row[0] = "S0" . (string)$row[0];
							}
							if(strlen((string)$row[0]) == 4)
							{
								$row[0] = "S" . (string)$row[0];
							}
							echo "<td>{$row[0]}</td>";
							echo "<td>{$row[1]}</td>";
							//get the "sharetype" information from the database
							if($row[2] == "p")
							{
								$row[2] = "Public";
							}
							else
							{
								if($row[2] == "f")
								{
									$row[2] = "Friends";
								}
								else
								{
									if($row[2] == "o")
									{
										$row[2] = "Only Me";
									}
									else
									{
										$row[2] = "";
									}
								}
							}
							echo "<td>{$row[2]}</td>";
							//get the "date" information from the database
 							$row[3] = (string)$row[3];
							$year = $row[3][0] . $row[3][1] . $row[3][2] . $row[3][3];
							$month = $row[3][5] . $row[3][6];
							$day = $row[3][8] . $row[3][9];
							switch($month)
							{
								case($month == "01"): $month = "January";
								break;
								case($month == "02"): $month = "February";
								break;
								case($month == "03"): $month = "March";
								break;
								case($month == "04"): $month = "April";
								break;
								case($month == "05"): $month = "May";
								break;
								case($month == "06"): $month = "June";
								break;
								case($month == "07"): $month = "July";
								break;
								case($month == "08"): $month = "August";
								break;
								case($month == "09"): $month = "September";
								break;
								case($month == "10"): $month = "October";
								break;
								case($month == "11"): $month = "November";
								break;
								case($month == "12"): $month = "December";
								break;
							}			
							$row[3] = $month . " " . $day . ", " . $year;
							echo "<td>{$row[3]}</td>";
							//get the "permission" data from database
							if($row[4] == 1)
							{
								$row[4] = "Allow Like";
							}
							else
							{
								$row[4] = "";
							}
							if($row[5] == 1)
							{
								$row[5] = "Allow Comment";
							}
							else
							{
								$row[5] = "";
							}
							if($row[6] == 1)
							{
								$row[6] = "Allow Share";
							}
							else
							{
								$row[6] = "";
							}
							echo "<td>{$row[4]} {$row[5]} {$row[6]}</td>";
							echo "</tr>";
						}
						echo "</table>";
					}
					//Close the database connection
					mysqli_close($conn);
				}
				else
				{
					//Report error message
					echo "<center><font color='red'>Table cannot be found within the database</font></center>";
					returnbutton();
					//Close the database connection				
					mysqli_close($conn);
				}
				//Close the database connection
				mysqli_close($conn2);
			}
		}
	?>
	<br/>
	<style>
	.return
	{
		position: fixed;
		top: 50%;
		left: 0px;
		width: 300px;
	}
	</style>
	<div class="return">
	<a href="searchstatusform.php">Return to Search Status Page</a>
	<br/>
	<br/>
	<a href="index.html">Return to Home Page</a>
	</div>
    </body>
</html>