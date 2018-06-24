<!---
Andrew Wood's ePortfolio
COP4813 - Summer 2018
index.html - AJAX - Assignment 7
--->

<?php
//start session to preserve variables
session_start();

//simple test response text
$value = filter_input(INPUT_POST,'value',FILTER_SANITIZE_STRING);

//populate array with
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


$result = $conn->query($sql);
if (!$result)
{
    echo "Database Query Failed!";
    return;
}

$originArray = [];
$destinationArray = [];


$totalResults = 0;
//create arrays that contain only the origin and destination codes
while ($row = $result->fetch_assoc())
{
    ++$totalResults;
    array_push($originArray,$row["origin_code"]);
    array_push($destinationArray,$row["dest_code"]);
}

$positionsToDisplay = [];

//determine which rows to keep based on current value
//THIS IS THE STRING WE'RE SEARCHING FOR!
//Also, we convert to uppercase
$findString = strtoupper($value);

if (strlen($findString) > 0)
{
    for ($i = 0; $i < count($originArray); ++$i)
    {
        $pos = strpos($originArray[$i],$findString);
        if ($pos !== false) //if the substring was found
        {
            array_push($positionsToDisplay,$i);
        }
    }

    for ($i = 0; $i < count($destinationArray); ++$i)
    {
        $pos = strpos($destinationArray[$i],$findString);
        if ($pos !== false) //if the substring was found
        {
            array_push($positionsToDisplay,$i);
        }
    }
}
else //display everything
{
    for ($i = 0; $i < $totalResults; ++$i)
    {
        array_push($positionsToDisplay,$i);
    }
}

//remove duplicates
$positionsToDisplay = array_unique($positionsToDisplay);
//order from smallest to biggest
sort($positionsToDisplay);

//now display only the rows with indexes contained in the positions to display array

    echo "<table class='schedule'>";
    echo "<tr>";
    echo "<th colspan='2'>Option</th>";
    echo "<th>Route ID</th>";
    echo "<th>Origin Code</th>";
    echo "<th>Destination Code</th>";
    echo "<th>Route Distance</th>";
    echo "<th>Duration (mins)</th>";
    echo "<th>Is Active</th>";
    echo "<th>ETOPS Certified</th>";
    echo "<th>Narrowbody Eligible</th>";
    echo "<th>Widebody Eligible</th>";
    echo "<th>Route Class</th>";
    echo "</tr>";
    
    $result->data_seek(0);
    
    $counter = 0;
    while ($row = $result->fetch_assoc())
    {
        //if the current row is not in the array, skip displaying the row
        if (!(in_array($counter,$positionsToDisplay)))
        {
            ++$counter;
            continue;
        }
        echo "<tr>";
        echo "<td><form action='./index.php' method='post'><input type='submit' value='Modify' name='$row[routeID]'></input></form></td>";
        echo "<td><form action='./index.php' method='post'><input type='submit' value='Delete' name='$row[routeID]'></input></form></td>";
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
        ++$counter;
    }
    echo "</table>";    

//close the connection for good measure
$conn->close();

?>