<?php

session_start();

//we need to determine who is logged in (userID) and the items in the cart.
//If there is NOT a currently logged in user, they will be returned to the home page.
//extra comment

$loggedInUser = "";
$summaryText = "";
$cartItems = "";
$confirmationText = "";

if (empty($_SESSION["username"]))
{
    //return to the homepage
    header("location: ../index.php"); 
}
else //we're logged in
{
    $loggedInUser = $_SESSION["username"];
}

//determine if were returning from the post
if ($_SERVER["REQUEST_METHOD"] == "POST")
{
   
    $confirmationText = "Thanks!  Your order has been placed and will be delivered promptly.<br /><a href='../home/index.php'>Return Home</a>";
    
    //change ownership of items
    //prepare database
    $servername = 'localhost';
    $dbUsername = 'group1';
    $dbPassword = 'summer2018123432';
    $database = 'group1';

    $conn = new mysqli($servername,$dbUsername,$dbPassword,$database);

    if ($conn->connect_error) {
        die("Connection failed: ") . $conn->connect_error;
    }
    
    $cartArray = &$_SESSION["cartArray"];
    $joinedArray = "'" . join("','",$cartArray) . "'";
    $sql = "UPDATE product SET userName = \"$loggedInUser\" WHERE productID IN (" . $joinedArray . ")";
    $sql2 = "UPDATE product SET forSale = 0 WHERE productID IN (" . $joinedArray . ")";
    
    unset($_SESSION["cartArray"]);  
    
    $conn->query($sql);
    $conn->query($sql2);
    
    $conn->close();
}
else
{

    //determine which summary text to show
    if (empty($_SESSION["cartArray"]))
    {
        $summaryText = "Your cart is empty!  Return to the <a href='../home/index.php'>shop</a> to add games to your cart!";
    }
    else
    {
        $summaryText = "Your cart contains the following items:";

        //get reference to cart array - it's not empty
        $cartArray = &$_SESSION["cartArray"];

        //prepare database
        $servername = 'localhost';
        $dbUsername = 'group1';
        $dbPassword = 'summer2018123432';
        $database = 'group1';

        $conn = new mysqli($servername,$dbUsername,$dbPassword,$database);

        if ($conn->connect_error) {
            die("Connection failed: ") . $conn->connect_error;
        }

        $joinedArray = "'" . join("','",$cartArray) . "'";

        $sql = "SELECT * FROM product WHERE productID IN (" . $joinedArray . ")";

        $sqlTotal = "SELECT SUM(price) AS totalPrice FROM product WHERE productID IN (" . $joinedArray . ")";

        $result = $conn->query($sql);

        if (!$result)
        {
            die;
        }

        $resultTotal = $conn->query($sqlTotal);

        $totalPrice = $resultTotal->fetch_assoc()["totalPrice"];

        if (!$resultTotal)
        {
            die;
        }

        //prepare the cart items text
        $cartItems .= "<div class='container'>";
        $cartItems .= "<table>";
        $cartItems .= "<tr>";
        $cartItems .= "<th>";
        $cartItems .= "Product ID";       
        $cartItems .= "</th>";
        $cartItems .= "<th>";
        $cartItems .= "SKU Number";        
        $cartItems .= "</th>";
        $cartItems .= "<th>";
        $cartItems .= "Product Name";        
        $cartItems .= "</th>";
        $cartItems .= "<th>";
        $cartItems .= "System";        
        $cartItems .= "</th>";
        $cartItems .= "<th>";
        $cartItems .= "Price";        
        $cartItems .= "</th>";
        $cartItems .= "</tr>";

        while($row = $result->fetch_assoc())
        {
            $cartItems .= "<tr>";
            $cartItems .= "<td>";
            $cartItems .= $row["productID"];
            $cartItems .= "</td>";
            $cartItems .= "<td>";
            $cartItems .= $row["skuNumber"];
            $cartItems .= "</td>";
            $cartItems .= "<td>";
            $cartItems .= $row["productName"];
            $cartItems .= "</td>";
            $cartItems .= "<td>";
            $cartItems .= $row["system"];
            $cartItems .= "</td>";
            $cartItems .= "<td>";
            $cartItems .= $row["price"];
            $cartItems .= "</td>";
            $cartItems .= "</tr>";
        }

        $cartItems .= "<tr>";
        $cartItems .= "<td colspan=4>";
        $cartItems .= "Total Price";
        $cartItems .= "</td>";
        $cartItems .= "<td>";
        $cartItems .= "$" . $totalPrice;
        $cartItems .= "</td>";
        $cartItems .= "</tr>";

        $cartItems .= "</table>";
        $cartItems .= "</div>";

        $cartItems .= "<br />";
        $cartItems .= "<form action='" . htmlspecialchars($_SERVER["PHP_SELF"]) . "'method='post'>";
        $cartItems .= "<button type='submit'>Checkout</button><br>";
        $cartItems .= "<input type='button' value='Continue Shopping' onclick=window.location.href='../home/index.php'>";
        $cartItems .= "</form>"; 

        $conn->close();
    }
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
	<head>
		<title>Cart</title>
	</head>
	<body>
		<p><?php echo $summaryText?><br /></p>
                <div id ="cartContainer">
                    <?php echo $cartItems;?>
                </div>
                <div id ="confirmationText">
                    <?php echo $confirmationText ?>
                </div>
	</body>
</html>


