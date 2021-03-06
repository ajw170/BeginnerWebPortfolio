<?php
//check to see if there is a session.  If there is a session, set the appropriate name.
session_start();
$loggedInUser = "";
$myGamesAreaTitle = "";
//if a session is currently active, display welcome message
if (!empty($_SESSION["username"]))
{   
    $myGamesAreaTitle = "My Games";
    $loggedInUser = $_SESSION["username"];
}
else
{
    $myGamesAreaTitle = "Selected games owned by our users:";
}

if ($loggedInUser)
{
    //get the user's display name
    $servername = 'localhost';
    $dbUsername = 'group1';
    $dbPassword = 'summer2018123432';
    $database = 'group1';

    $conn = new mysqli($servername,$dbUsername,$dbPassword,$database);

    if ($conn->connect_error) {
       die("Connection failed: ") . $conn->connect_error;
    }
    
    $sql = "SELECT fName FROM userData WHERE userName = \"$loggedInUser\"";
    $result = $conn->query($sql);
    if ($result) //if query success
    {
        $friendlyName = $result->fetch_assoc()["fName"];
    }
    else
    {
        $friendlyName = $loggedInUser;
    }
    
    $greeting = "Welcome, " . $friendlyName;
    
    $conn->close();
}
else
{
    $greeting = "";
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
<head>
	<title>Deals</title>
	<link rel="shortcut icon" href="../images/main_icon.png" />
	<link rel="stylesheet" type="text/css" href="../style.css">
	<link href="https://fonts.googleapis.com/css?family=Fjalla+One|Open+Sans:300,400" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css?family=Work+Sans" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
	<meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script src="../home/scripts.js"></script>
		<script src="../home/more.js"></script>
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
				

                                <div class="content-left">
					

					<div class="deals" id="deal1">
						<script>displayGame("9781450424554DannySnart06272018", "deal1")</script>
					</div>
                                        <div class="deals" id="deal2">
                                                <script>displayGame("9781544105758DannySnart06272018", "deal2")</script>
                                        </div> 
                                 	<div class="deals" id="deal3">
                                                <script>displayGame("9785421551242AndrewHill06272018", "deal3")</script>
                                        </div> 
                                        
                                                

				</div>
				<div class="vertical-line"><hr></div>
			
			<!--	<div class="content-right" id="results">-->
				<div class="content-right">
					<!--<div class=container" id="results">
						Search Results:<br>
					</div>-->
					<div class="container" id ="trueGamerz">
						<a href="http://truegamerzexpo.com/">
							<img src="http://truegamerzexpo.com/wp-content/uploads/2018/02/TRUEGAMER.jpg">
						</a>
					</div>	
					<br>
					<br>
					<hr>
					<div class="container">
						<h2>ACTION GAMES!</h2><br>
						<p> We have a large selection of Action-Packed games! Here are just a few of our games:<br>
Fallout, Far-Cry, Skyrim, Grand Theft Auto 5, Verdun, Reciever and PayDay
<br>Remember, these are a select few of our inventory. In order to view more games go to the Browse All page or simply search for them.</p>
<br><hr>
					</div>
					<div class="container">
						<h2>FANTASY GAMES!</h2><br>
						<p>Searching for the perfect Fantasy game? Then we have the game for you! Here are just a few of our games:<br>
Skyrim, Darkest Dungeon, Mario Kart, and Mario Party.
<br>Remember, these are a select few of our inventory. In order to view more games go to the Browse All page or simply search for them.</p>
<br><hr>
					</div>
					<div class="container">
						<h2>SCIFI GAMES!</h2><br>
						<p>If Sci-Fi games are more your style, we can guarantee that you will leave this site with a new game. Here are just a few of our games:<br>
Fallout, Verdun, and Reciever.
<br>Remember, these are a select few of our inventory. In order to view more games go to the Browse All page or simply search for them.</p>
<br><hr>
					</div>
				
				

					 <div class="container">
                                                <p><i>If you don't see your game today, just check back soon!<br>
						 You never know what will be here. The inventory is consistently changing.</i></p><br><hr>
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

