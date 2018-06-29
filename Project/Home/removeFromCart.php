<?php
//obtain variables
session_start();
$productID = $_GET["productID"];
$buttonNum = $_GET["buttonNum"]; //not sure if this is needed

//add them to the session array

//first, check to see if it already exists -- should never be able to get here
if ((empty($_SESSION["cartArray"])))
{
    die;
}
else 
{
    $cartArray = &$_SESSION["cartArray"];
    
    //ensure element exists
    $key = array_search($productID, $cartArray);
    if ($key !== false) //if the key is found (desired behavior)
    {
        unset($cartArray[$key]);
    }
    
}

//now, echo the response text
$responseText = "Removed from Cart! <br /><button onclick=addToCart(\"$productID\",$buttonNum)>Add to Cart</button>";

echo $responseText;

?>

