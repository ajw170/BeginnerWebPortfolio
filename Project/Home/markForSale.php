<?php

session_start();
$productID = $_GET["productID"];
$buttonNum = $_GET["buttonNum"];
$loggedInUser = $_SESSION["username"];

$servername = 'localhost';
$dbUsername = 'group1';
$dbPassword = 'summer2018123432';
$database = 'group1';

$conn = new mysqli($servername,$dbUsername,$dbPassword,$database);

if ($conn->connect_error) {
    die("Connection failed: ") . $conn->connect_error;
}

$sql = "UPDATE product SET forSale = 1 WHERE productID = \"$productID\"";

$result = $conn->query($sql);

$conn->close();

//send response
$responseText = "For Sale! <button onclick=unMarkForSale(\"$productID\",$buttonNum)>Cancel</button>";

echo $responseText;

?>

