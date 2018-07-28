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
    header("location: ../home/login.php");
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
	<title>Template</title>
	<link rel="shortcut icon" href="../images/main_icon.png" />
	<link rel="stylesheet" type="text/css" href="../style.css">
	<link href="https://fonts.googleapis.com/css?family=Fjalla+One|Open+Sans:300,400" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css?family=Work+Sans" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
	<meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script src="./scripts.js"></script>
		<script src="./more.js"></script>
</head>
<body onload="getMyGames()">

	<div class="outer-whole">
		<img class="background-img" src="https://cdn.segmentnext.com/wp-content/uploads/2016/09/FFXVWallpaper.jpg">
		<div class="header">
			<div class="navbar-positioning">
				<div class="navbar">
					<div class="logos">	
						<a href="../home/index.php">
							<img id="logo-left" src="../images/main_icon.png">
						</a>		
					</div>
					<div class="logos">
						<a href="../home/index.php">
							<img href="index.php" id="logo-right" src="../images/GSP_icon.png">
						</a>
					</div>

					<ul class="navbar-left">
						
						<li><a href="../categories/categories.php">Categories</a></li>
						<li><a href="../new/new.php">New</a></li>
						<li><a href="../browse/browse.php">Browse All</a></li>
						<li><a href="../about/about.php">About Us</a></li>
						<li><a href="../deals/deals.php">Deals</a></li>
					</ul>
					<ul class="navbar-right">
						<div id="searchbar"><form accept-charset="utf-8">
								<input id="searchbox" type="text" placeholder="Search" onfocus="showResults();" oninput="searchGames(this.value, 'results');"></input>
    						</form>
						
						</div>
						<div id="overlay" onclick="hideResults();">
								<div id="results" class="container">
								<p id="r_default">Start typing to search by product name, genre, system or SKU number.</p>
								</div>
						</div>
                                                
				
						<?php
                                                //this will cause issues if the name is too long, it will cause
                                                //the div to drop to the next line
                                               // if ($loggedInUser)
                                                //{
                                                  //  echo "<li>";
                                                   // echo $greeting;
                                                   // echo "<a href='./logout.php'>LOGOUT</a>";
                                                   // echo "</li>";
                                               // }
                                               // else
                                               // {
                                               //     echo "<li><a href='./login.php'>LOGIN</a></li>";
                                               // }      
                                                ?>
					
						
					</ul>
					<figure class="cart">
						<a href="../cart/cart.php">
							<img src="../images/cart.png" id="logo-cart">
						</a>
						<figcaption><a href="../cart/cart.php">Cart</a></figcaption>
					</figure>
					<figure class="login">
						<a> 
							<img src="../images/user.png" id="logo-user">
						</a>
						<figcaption>
							<?php
                                                //this will cause issues if the name is too long, it will cause
                                                //the div to drop to the next line
                                                if ($loggedInUser)
                                                {
                                                   // echo "<li>";
                                                   // echo $greeting;
                                                    echo "<a href='../home/logout.php'>Log Out</a>";
                                                   // echo "</li>";
                                                }
                                                else
                                                {
                                                    echo "<a href='../home/login.php'>Log In</a>";
                                                }
                                                ?>
						</a></figcaption>
					</figure>

				</div>
			</div>
		</div>
		<div class="featured-event">
			<div class="featured-event-text">
				<h2>Sell 3 games and get 10% off your next order!</h2>
				<!--hardcode the link to a page showcasing the event (ie: page shows 4 games on it or something)-->
			</div>
		</div>
		<div class="welcome-banner">
			<div class="welcome-pos">
				<img class="welcome-img" src="https://vignette.wikia.nocookie.net/finalfantasy/images/a/aa/Final_Fantasy_XV_Logo.png/revision/latest?cb=20130625082542">
				<div class="welcome-text">
				Experience the ongoing franchise in this epic sequel!<br>
				FFXV is available now
				</div>
			</div>
		</div>
		<div class="inner-whole">
			
			<div class="inner-main-content">
				

                                
				<div class="container" id="cart">
					
					<p><?php echo $summaryText?><br /></p>
			                <div id ="cartContainer">
                   				 <?php echo $cartItems;?>
			                </div>
			                <div id ="confirmationText">
			                    <?php echo $confirmationText ?>
			                </div>

				</div>
				
			
			</div>
			
			<div class="footer">
				
				<div id="ft-col-1">
					<h2>Developer's Picks</h2>
					<a>The Last of Us</a><br>
					<a>Metal Gear Solid</a><br>
					<a>Horizon Zero Dawn</a><br>
					<a>God of War 4</a><br>
					<a>Ni No Kuni II</a><br>
				</div>
				<div id="ft-col-2">
                                	<img id="WRD_logo" src="../images/WRD_Icon.png">
                                </div>	
				<div id="ft-col-3">
                                	<h2>White Rabbit Developers</h2>
					
					<a href="http://139.62.210.151/~n01382327/cop4813/assign1/index.html">Connor Ackerman</a><br>
					<a href="http://139.62.210.151/~n00911966/cop4813/assign1/index.html">Eric Davis</a><br>
					<a href="http://139.62.210.151/~n00436223/cop4813/assign1/index.html">Travis Jones</a><br>
					<a href="http://139.62.210.151/~n00960527/cop4813/assign1/about_me.html">Elizabeth Ruby</a><br>
					<a href="http://139.62.210.151/~n01418213/cop4813/assign1/index.html">Andrew Wood</a><br>
                                </div>
				<div id="ft-col-4">
                                	<h2>Gaming Saver Pro</h2>
					<a href="../about/about.php">About</a><br>
					<a class="no">Careers</a><br>
					<a class="no">Future of Site</a><br>
                                </div>
				
			</div>
		</div>

	</div>

</body>
</html>

