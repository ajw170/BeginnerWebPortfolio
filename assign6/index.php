<!---
Andrew Wood's ePortfolio
COP4813 - Summer 2018
index.html - PHP Introduction - Assignment 5
--->

<?php
session_start();
 $statusValue = "";
 
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
         * */
         
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

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">


<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<title>Airline Routes</title>
		<meta charset="UTF-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0" /> 
                <link rel="stylesheet" type="text/css" href="../style.css"></link>	
        </head>
    
    	<body class="clearfix">
		<h1 style="text-align:center">Database Access and Modification with PHP</h1>
		<p style="text-align:center">This system simulates an airline route database.</p>
                <p style="text-align:center">Utilize the forms below to read, update, and delete and create new entries!</p>
		<hr />
                <p><strong>Airline Route Table</strong></p>
                
                <table class="schedule">
                    <tr>
                        <th colspan="2">Option</th>
                        <th>Route ID</th>
                        <th>Origin Code</th>
                        <th>Destination Code</th>
                        <th>Route Distance</th>
                        <th>Duration (mins)</th>
                        <th>Is Active</th>
                        <th>ETOPS Certified</th>
                        <th>Narrowbody Eligible</th>
                        <th>Widebody Eligible</th>
                        <th>Route Class</th>
                    </tr>

                <?php
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
                    $database = 'dbAssign6';
                    
                    //create new connection to database
                    $conn = new mysqli($servername,$username,$password,$database);
                    
                    //check connection
                    if ($conn->connect_error) {
                        die("Connection failed: ") . $conn->connect_error;
                    }
                    
                    //select entire table
                    $sql = "SELECT * FROM Routes";

                    //if the query did not return an error
                    if ($result = $conn->query($sql))
                    {
                        $rowNum = 0;
                        //fetch the associative array
                        while ($row = $result->fetch_assoc())
                        {
                            echo "<tr>";
                            echo "<td><form action='$_SERVER[PHP_SELF]' method='post'><input type='submit' value='Modify' name='$row[routeID]'></input></form></td>";
                            echo "<td><form action='$_SERVER[PHP_SELF]' method='post'><input type='submit' value='Delete' name='$row[routeID]'></input></form></td>";
                            echo "<td>" . $row['routeID'] . "</td>";
                            echo "<td>" . $row['origin_code'] . "</td>";
                            echo "<td>" . $row['dest_code'] . "</td>";
                            echo "<td>" . $row['route_distance'] . "</td>";
                            echo "<td>" . $row['duration_mins'] . "</td>";
                            echo "<td>";
                            $output = ($row['is_Active'] == 1) ? "Yes" : "No";
                            echo "$output</td>";
                            echo "<td>";
                            $output = ($row['is_ETOPS'] == 1) ? "Yes" : "No";
                            echo "$output</td>";
                            echo "<td>";
                            $output = ($row['is_NarrowBody'] == 1) ? "Yes" : "No";
                            echo "$output</td>";
                            echo "<td>";
                            $output = ($row['is_WideBody'] == 1) ? "Yes" : "No";
                            echo "$output</td>";
                            echo "<td>" . $row['RouteClass'] . "</td>";
                            echo "</tr>";
                            ++$rowNum;
                        }
 
                    }
                    
                //close the connection for good measure
                $conn->close();
                ?>
                </table>
                
                <div align="center"><button type="button" onclick="window.location.href='./addRecord.php'">Add Record</button><br /></div>
                <p class="error"><?php echo $statusValue ?></p>
                <p><a href="./ER_Diagram.png">Link to Database ER Diagram</a></p>
                <hr />
		<h2>My ePortfolio Index</h2>
		<p><a href="../index.html">Andrew's ePortfolio Index</a></p>
	</body>
</html>