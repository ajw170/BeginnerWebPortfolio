<?php
//obtain variables
session_start();
$productID = $_GET["productID"];
$buttonNum = $_GET["buttonNum"]; //not sure if this is needed

//add them to the session array

//first, check to see if session ariable is not empty
if (!(empty($_SESSION["cartArray"])))
{
    //if it's not empty, search the array to ensure the value doesn't already exist.
    $key = array_search($productID, $_SESSION["cartArray"]);
    if ($key === false)
    {
        array_push($_SESSION["cartArray"],$productID);    
    }
}
else ///if the session array doesn't yet exist, push value.
{
    //create the session Variable
    $_SESSION["cartArray"] = [];
    array_push($_SESSION["cartArray"],$productID);
}

//now, echo the response text
$responseText = "Added to Cart! <br /><button onclick=removeFromCart(\"$productID\",$buttonNum)>Remove</button>";

echo $responseText;

?>