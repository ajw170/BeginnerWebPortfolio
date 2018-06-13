<!---
Andrew Wood's ePortfolio
COP4813 - Summer 2018
index.html - PHP Introduction - Assignment 5
--->

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<title>Contact Forms with PHP</title>
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
                <button type="button" onclick="window.location.href='./addRecord.php'">Add Record</button><br />
                
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
                    </tr>

                <?php
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
                        $row = $result->fetch_assoc();
                        //fetch the associative array
                        while ($row = $result->fetch_assoc())
                        {
                            echo "<tr>";
                            echo "<td><button value=$rowNum name='modifyButtonPress' type='submit' >Modify</button></td>";
                            echo "<td><button value=$rowNum name='deleteButtonPress' type='submit' >Delete</button></td>";
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
                            echo "</tr>";
                        }
 
                    }
                ?>
                </table>   
              
                <hr />
		<h2>My ePortfolio Index</h2>
		<p><a href="../index.html">Andrew's ePortfolio Index</a></p>
	</body>
</html>