<?php
//determine if there is a session
session_start();

$retrieveName = "";

if (empty($_SESSION["username"]))
{
    $retrieveName = "defaultDisplay";
}
else
{
    $retrieveName = $_SESSION["username"];
}

//establish database connection

$servername = 'localhost';
$dbUsername = 'group1';
$dbPassword = 'summer2018123432';
$database = 'group1';

$responseText = "";

$conn = new mysqli($servername,$dbUsername,$dbPassword,$database);

if ($conn->connect_error) {
    die("Connection failed: ") . $conn->connect_error;
}

//generate query based on status
if (strcmp($retrieveName,"defaultDisplay") === 0) //if its the default
{
    $sql = "SELECT * FROM product ORDER BY RAND() LIMIT 5";
}
else //we're logged in with a user
{
    $sql = "SELECT * FROM product WHERE username = \"$retrieveName\" LIMIT 5";
}

$result = $conn->query($sql);

if (!$result)
{
    die;
}
else
{
    //prepare statement to return
    while ($row = $result->fetch_assoc())
    {
        $responseText .= "<div class='container'>";
        $responseText .= "<table>";
        $responseText .= "<tr>";
        $responseText .= "<td>";
        $responseText .= $row["productName"];
        $responseText .= "</td>";
        $responseText .= "<td>";
        $responseText .= $row["system"];
        $responseText .= "</td>";
        $responseText .= "<td>";
        $responseText .= $row["rating"];
        $responseText .= "</td>";
        $responseText .= "</td>";
        $responseText .= "</tr>";
        $responseText .= "</table>";
        $responseText .= "</div>";
    } 
}

$conn->close();

echo $responseText;

?>
