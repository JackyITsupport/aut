<html>
<head>
<title>Post Status Result Page</title>
</head>
<body>
<h1>Post Status Result</h1>
<br>
<?php
	//Get database setting
	require_once("settings.php");
	//Set the database connecting information
	$conn = mysqli_connect($host, $user, $pswd, $dbnm);
	
	//Create function so that the user can go back to the previous page
	function returnbutton()
	{
		echo "<body>";
		echo "<form method='post' action='poststatusform.php'>";
		echo "<br />";
		echo "<center><input type='submit' value= 'return' /></center>";
		echo "</form>";
		echo "</body>"; 
	}
	//Report error postion message
	function  position($position)
	{
		echo "<br>";
		echo "<center><font color='red'>(The line " . $position . " of table has an error)</font></center>";
		echo "<br>";
		echo "<br>";
	}
	//To check the database is connected or not
	if(!$conn) 
	{
		echo "<center><font color='red'><p>Database connection failure</p></font></center>";
		echo "<br />";
		returnButton();
	} 
	else 
	{
		//Get the data from post status form
		$code = $_POST["code"];
		$status = $_POST["status"];
		$sharetype = $_POST["sharetype"];
		$date = $_POST["date"];
		$like = $_POST["like"];
		$comment = $_POST["comment"];
		$share = $_POST["share"];
		
		//Store the user input data and create the table in the database
		$queryCreateTable = "create table if not exists `assign1` (`code` INT(4) NOT NULL, `status` VARCHAR(255) NOT NULL DEFAULT 'None', `sharetype` VARCHAR(1) NULL DEFAULT 'N', `date` DATE NOT NULL, `like` INT(1) NULL DEFAULT '0', `comment` INT(1) NULL DEFAULT '0', `share` INT(1) NULL DEFAULT '0', PRIMARY KEY (`code`)) COLLATE='utf8_general_ci' ENGINE=InnoDB"; 
		
		mysqli_query($conn, $queryCreateTable);

		//Chenk user input for the "status code" is empty or not 
		if(empty($_POST['code']))
		{	
			//Report error message
			echo "<center>Please enter the Status Code</center>";
			echo "<br />";
			position(1);
		}
		else
		{
			//Check code format
			$newCode = preg_replace("/[^S(\d{4})]/", "", $code);
			if((strlen($newCode) != strlen($code)) || (strlen($code) != 5) || ($code[0] != "S"))
			{
				//Report error message
				$code = "Clear";
				echo "<center>Please check the Status Code format like S0000</center>";
				echo "<br />";
				position(1);
			}
			else
			{
				//change the 'code' part into database readable code
				$code = $newCode[1] . $newCode[2] . $newCode[3] . $newCode[4];
				$queryCheckExists = "select code from assign1 where code like $code";
				$checkExists = mysqli_query($conn, $queryCheckExists);
				$checkCode = "";
				$row = mysqli_fetch_row($checkExists);
				if(strlen((string)$row[0]) == 1)
				{
					$checkCode = "000" . (string)$row[0];
				}
				else
				{
					if(strlen((string)$row[0]) == 2)
						$checkCode = "00" . (string)$row[0];
					else
					{
						if(strlen((string)$row[0]) == 3)
							$checkCode = "0" . (string)$row[0];
						else
							$checkCode = (string)$row[0];
					}
				}
				//Check for the duplicate code
				if($checkCode == (string)$code)
				{
					//Report error message
					$code = "Clear";
					echo "<center>Please check the Status Code which is duplicate within the database</center>";
					echo "<br />";
					position(1);
				}
			}
		}
		//Check user input "status" is empty or not
		if(empty($_POST['status']))
		{	
			//Report error message
			$code = "Clear";
			echo "<center>Please enter the Status</center>";
			echo "<br />";
			position(2);
		}
		else
		{
			//Check the length of user input
			if(strlen($status) > 255)
			{
				//Report error message
				$code = "Clear";
				echo "<center>Please do not enter more than 255 alphanumeric characters<center>";
				echo "<br />";
				position(2);
			}
			else
			{
				//user regular expression to check the user input "status" format is correct or not
				if(!preg_match('/^[a-zA-Z0-9 ,.!?]*$/', $status))
				{
					//Report error message
					$code = "Clear";
					echo "<center>Please enter the status only contain alphanumeric characters including spaces, comma, period (full stop), exclamation point and question mark</center>";
					echo "<br />";
					position(2);
				}
			}
		}
		//Check the user input "sharetype" is empty or not, and if it is empty then set the value as "N", stand for none
		if(empty($_POST['sharetype']))
		{
			$sharetype = "N";			
		}
		//Check user input "date" is empty or not
		if(empty($_POST['date']))
		{	
			//Report error message
			$code = "Clear";
			echo "<center>Please enter the Date</center>";
			echo "<br />";
			position(4);
		}
		else
		{
			//Check the date format is correct or not
			if((strlen($date) == 8) && ($date[2] == "/" && $date[5] == "/") && (is_numeric($date[0]) && is_numeric($date[1]) && is_numeric($date[3]) && is_numeric($date[4]) && is_numeric($date[6]) && is_numeric($date[7])))
			{
				//change the 'date' part into database readable code
				$newDate = "20" . $date[6] . $date[7] . "-" . $date[3] . $date[4] . "-" . $date[0] . $date[1];
				$date = $newDate;
				
			}
			else
			{
				//Report error message
				$code = "Clear";
				echo "<center>Please check the Date format like DD/MM/YY</center>";
				echo "<br />";
				position(4);
			}
		}
		//Check user input "permission" is empty or not, if it is not empty, set value as 1, else as 0 
		if(!empty($_POST['like']))
		{
			$like = 1;			
		}
		else
		{
			$like = 0;
		}
		if(!empty($_POST['comment']))
		{
			$comment = 1;			
		}
		else
		{
			$comment = 0;
		}
		if(!empty($_POST['share']))
		{
			$share = 1;			
		}
		else
		{
			$share = 0;
		}

		//Save user input data into database
		$query = "INSERT INTO `assign1` (`code`, `status`, `sharetype`, `date`, `like`, `comment`, `share`) VALUES ($code, '$status', '$sharetype', '$date', $like, $comment, $share)";

		$result = mysqli_query($conn, $query);
		
		if(!$result) 
		{
			//Display a button for user to return to the previous page 
			returnbutton();
			//echo "<p>Something is wrong with ", $query, "</p>";
		} 
		else
		{
			//Check date data is correct or not
			$queryCheckDate = "select date from assign1 where code = $code";
			$checkDateResult = mysqli_query($conn, $queryCheckDate);
			$dateResult = mysqli_fetch_row($checkDateResult);
			//If date data is incorrect, delete the data of this time
			if((($dateResult[0][5] == "0") && ($dateResult[0][6] == "0")) || (($dateResult[0][8] == "0") && ($dateResult[0][9] == "0")))
			{
				$queryDelete = "delete from assign1 where code = $code";

				$deleteResult = mysqli_query($conn, $queryDelete);
				//Report error message
				echo "<center>Please check the month or day of the Date is correct</center>";
				echo "<br />";
				position(4);
				returnbutton();
				//echo "<p>Something is wrong with ", $query, "</p>";
			}
			else
			{
				//Report success message
				echo "<center><strong><font size = '5' color = 'turquoise'>Congratulations! Post Success!</font></strong></center>";
				echo "<br>";
				returnbutton();
			}
		} 
		//Close connection with database
		mysqli_close($conn);
	}
?>
<br />
<style>
.bottom
{
	position: fixed;
    top: 50%;
    left: 0px;
    width: 300px;
}
</style>
<div class="return">
<a href="poststatusform.php">Return to Post Status Page</a>
<br/>
<br/>
<a href="index.html">Return to Home Page</a>
</div>
</body>
</html>




