<!---
Andrew Wood's ePortfolio
COP4813 - Summer 2018
index.html - AJAX - Assignment 7
--->

<?php
session_start();
$statusValue = "";
 
 //handler if one of the buttons is pressed
if ($_SERVER["REQUEST_METHOD"] == "POST")
{
    $routeToAccess = 0;
    $operation = "";
    
    //Get the name as the route ID, the value as the operation
    foreach($_POST as $name => $val)
    {
        $routeToAccess = $name;
        $operation = $val;
    }
    
    //if a delete was requested
    if ($operation == 'Delete')
    {
        //connect to database
        
        /*
         $servername = 'localhost';
         $username = 'n01418213';
         $password = 'titan7dr';
         $database = 'dbAssign6';
         * 
         */
         
         
       
         $servername = 'localhost';
         $username = 'n01418213';
         $password = 'titan7dr';
         $database = 'n01418213';
        
         
         $conn = new mysqli($servername,$username,$password,$database);
         
         //check connection
         if ($conn->connect_error) {
            die("Connection failed: ") . $conn->connect_error;
         }
         
         $sql = "DELETE FROM Routes WHERE routeID = $routeToAccess;";
         
         if ($conn->query($sql) === TRUE) 
         {
            $statusValue = "Record Deleted!";
         }       
         else 
         {
            $statusValue = "There was a problem deleting the entry.  Please check the input and try again." . " " . $conn->error;
         }
         
         $conn->close();
    }
    
    if ($operation == 'Modify')
    {
        //bring user to another page
        $_SESSION["routeToAccess"] = $routeToAccess;

        header("Location: ./modify.php");
    }
                       
}
?>

<!-- Script to handle the search bar with AJAX -->
<script>
    function filterResults(str)
    {
        var xhttp;
        xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function () {
            if (this.readyState === 4 && this.status === 200)
            {
                //sets the innerhtml to the table data
                document.getElementById("response").innerHTML = this.responseText;
            }
        };
        xhttp.open("POST","getResults.php",true); //asyncronouse
        xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhttp.send("value="+ str);
    }
</script>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">


<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<title>Airline Routes with AJAX Live Updates</title>
		<meta charset="UTF-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0" /> 
                <link rel="stylesheet" type="text/css" href="../style.css"></link>	
        </head>
    
    	<body class="clearfix" onload="filterResults('')">
		<h1 style="text-align:center">Database Access and Modification with PHP</h1>
		<p style="text-align:center">This system simulates an airline route database.</p>
                <p style="text-align:center">Utilize the forms below to read, update, and delete and create new entries!</p>
		<hr />
                <p><strong>Airline Route Table</strong></p>
                <p>
                <form action="">Search for routes using the 3 letter origin or destination code (e.g. PHX):
                    <input type="text" name="searchBar" onkeyup="filterResults(this.value)"></input>
                </form>
                </p>
                
                <div id="response"></div>
              
                <div align="center"><button type="button" onclick="window.location.href='./addRecord.php'">Add Record</button><br /></div>
                <p class="error"><?php echo $statusValue ?></p>
                <hr />
		<h2>My ePortfolio Index</h2>
		<p><a href="../index.html">Andrew's ePortfolio Index</a></p>
	</body>
</html>