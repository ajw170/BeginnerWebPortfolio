
<?php

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

//if we are logged in, we will show games for sale plus an add to cart button.
//if we are not logged in, we will only show games for sale without the add button.

$servername = 'localhost';
$dbUsername = 'group1';
$dbPassword = 'summer2018123432';
$database = 'group1';

$responseText = "";

$conn = new mysqli($servername,$dbUsername,$dbPassword,$database);

if ($conn->connect_error) {
    die("Connection failed: ") . $conn->connect_error;
}

$sql = "SELECT * FROM product WHERE forSale = 1 AND userName != '$retrieveName'";

$result = $conn->query($sql);

if (!$result)
{
    die;
}

$buttonNum = 1;
$responseText .= "<table>";
$responseText .= "<tr>";
$responseText .= "<th>";
$responseText .= "Title";
$responseText .= "</th>";
$responseText .= "<th>";
$responseText .= "Price";
$responseText .= "</th>";
$responseText .= "<th>";
$responseText .= "Sold By";
$responseText .= "</th>";
$responseText .= "</tr>";

while ($row = $result->fetch_assoc())
{
        $responseText .= "<tr>";
        $responseText .= "<td>";
        $responseText .= $row["productName"];
        $responseText .= "</td>";
        $responseText .= "<td>";
        $responseText .= $row["price"];
        $responseText .= "</td>";
        $responseText .= "<td>";
        $responseText .= $row["userName"];
        $responseText .= "</td>";
        
        if (strcmp($retrieveName,"defaultDisplay") === 0) //if not logged in
        {
            $responseText .= "</tr>";
            continue;
        }
        else
        {
            $productID = $row["productID"];
            $productName = $row["productName"];
            $responseText .= "<td id='cartButton";
            $responseText .= "$buttonNum" . "'";
            
            //check to see whetehr the productID is already in the cart, if it is, display remove button
            //this section prevents confusing results due to page reloads in the same session
            if (!(empty($_SESSION["cartArray"])))
            {
                $key = array_search($productID, $_SESSION["cartArray"]);
                if ($key === false) //if the item is NOT found in the existing cart
                {
                    $responseText .= "><button value=\"$productID\" onclick='addToCart(\"$productID\",$buttonNum)'>Add to Cart</button></td>";   
                }
                else //the iteam WAS found in the cart already
                {
                    $responseText .= "><button onclick=removeFromCart(\"$productID\",$buttonNum)>Remove</button></td>";
                    
                }
            }
            else //it was empty
            {
                $responseText .= "><button value=\"$productID\" onclick='addToCart(\"$productID\",$buttonNum)'>Add to Cart</button></td>";  
            }
            $responseText .= "</tr>";
        }
        ++$buttonNum;
}

$responseText .= "<table>";

$conn->close();

echo $responseText;
?>