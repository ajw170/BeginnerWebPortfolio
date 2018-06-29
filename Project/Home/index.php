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
	<title>Template</title>
	<link rel="stylesheet" type="text/css" href="../style.css">
	<link href="https://fonts.googleapis.com/css?family=Fjalla+One|Open+Sans:300,400" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css?family=Work+Sans" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
	<meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
        <script src="./scripts.js"></script>
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
						<li><a>New</a></li>
						<li><a>Browse All</a></li>
						<li><a>About Us</a></li>
						<li><a>Deals</a></li>
					</ul>
					<ul class="navbar-right">
						<div id="searchbar"><form accept-charset="utf-8">
								<input type="text" placeholder="Search" oninput="javascript:searchGames(this.value, 'results')"></input>
    						</form>
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
				"featured-event-text": SHOWS AN EVENT SUCH AS A SALE ITEM(ie: "Assassins Creed Bundle on Sale now!")
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
				<div class="inner-header">Inner header</div>

                                <div class="content-left">
					

					<!--DIV FOR SLIDESHOW-->
                                        <div class="container" id="slideshow_cont">
                                               
                                                <div class="slideshow">
                                                        <a href="asdf.html"><img class="mySlides" src="http://assets.vg247.com/current//2016/06/skyrim_special_edition_screen_2-600x338.jpg" ></a>
                                                        <img class="mySlides" src="http://www.rockstarnexus.com/media/news/1236063307.png">
                                                        <img class="mySlides" src="http://sm.ign.com/ign_nordic/gallery/f/far-cry-5-/far-cry-5-first-screenshots_admj.jpg">
							<img class="mySlides" src="http://vaultguides.com/wp-content/uploads/2015/11/fallout-4-graphics.jpg">
							<img class="mySlides" src="https://simsvip.com/wp-content/uploads/2016/05/TS4_GP3_Screenshot_2.jpg">	
							<img class="mySlides" src="https://www.technobuffalo.com/wp-content/uploads/2014/02/mario-kart-8-1-2-470x310@2x.jpg">
                                                </div>
                                                <br><hr>


                                                <script>
                                                        var myIndex = 0;
                                                        carousel();

                                                        function carousel() {
                                                            var i;
                                                            var x = document.getElementsByClassName("mySlides");
                                                            for (i = 0; i < x.length; i++) {
                                                               x[i].style.display = "none";  
                                                            }
                                                            myIndex++;
                                                            if (myIndex > x.length) {myIndex = 1}    
                                                            x[myIndex-1].style.display = "block";  
                                                            setTimeout(carousel, 8000); // Change image every 2 seconds
                                                        }
                                                        </script>

                                        </div>

					<div class="container">
						<?php echo $myGamesAreaTitle; ?>
                                   		 <div id="myGamesArea"></div>
						<br><hr>
					</div>
                                        
                                       
                                    
                                        <div class="container">
						<h2 id= "GFS_title">For Sale</h2>
						<div id="gamesForSale">
	                	                        <!-- this will be handled by getMyGames.js -->
        		                                THIS SHOULD BE REPLACED
                                		        <script>getGamesForSale();</script>
						</div>
						<br><hr>
                                  
                                        </div>
					
					<div class="container">
						<h2>New Releases</h2><br>
						<iframe src="https://www.gamespot.com/videos/embed/6444668/" width="480" height="270" scrolling="no" frameborder="0" webkitallowfullscreen="" mozallowfullscreen="" allowfullscreen=""></iframe>


						<br><hr>
					</div>
					<div class="container">
						<h2>Battlefield 5 Closed Alpha Gameplay</h2><br>
						<iframe src="https://www.gamespot.com/videos/embed/6444812/" width="480" height="270" scrolling="no" frameborder="0" webkitallowfullscreen="" mozallowfullscreen="" allowfullscreen=""></iframe>
						<br><hr>
					</div>
					<div class="container">
						alskdjflkajsdflkjasdlkfjlkasjdf
						asdffkjasd;flkjalksdjflkajsd flsajd flkjsdlkfj lksajd flkjsadlkfj alskdjflkjsd
						asldfj laksjd flkjsadlfj lksdj flkjasdlfkj aslkdjflksadj flkjsadf<br><hr>
					</div>
                                        <div class="container">
                                              	TOP TEN GAMES!<br>
						(Hard coded list)<br> 
						asldfj laksjd flkjsadlfj lksdj flkjasdlfkj aslkdjflksadj flkjsadf<br><hr>
					</div>
                                                

				</div>
				<div class="vertical-line"><hr></div>
			
			<!--	<div class="content-right" id="results">-->
				<div class="content-right">
					<div class=container" id="results">
						Search Results:<br>
					</div>
					<div class="container" id ="trueGamerz">
						<a href="http://truegamerzexpo.com/">
							<img src="http://truegamerzexpo.com/wp-content/uploads/2018/02/TRUEGAMER.jpg">
						</a>
					</div>	
					<div class="container">
						ACTION GAMES!<br>
						<br>
						xxxxx
						xxxxx x xxxxxx xxxxxxxx x xxx xxxxx
						xxxxx x xxxxxx xxxxxxxx x xxx xxxxx
						xxxxx x xxxxxx xxxxxxxx x xxx xxxxx<br><hr>
					</div>
					<div class="container">
						FANTASY GAMES!<br>
						xxxx xxxxxxxx x xxx xxxx xxxxxxxx x xxx
						xxxx xxxxxxxx x xxx xxxx xxxxxxxx x xxx
						xxxx xxxxxxxx x xxx xxxx xxxxxxxx x xxx
						xxxx xxxxxxxx x xxx<br><hr>
					</div>
					<div class="container">
						SCIFI GAMES!<br>
						yyyyy y y  y yyyy y yyy y y yy y y
						yyyyy y y  y yyyy y yyy y y yy y y
						yyyyy y y  y yyyy y yyy y y yy y y
						yyyyy y y  y yyyy y yyy y y yy y y<br><hr>
					</div>
				
				

					 <div class="container">
                                                yyyyy y y  y yyyy y yyy y y yy y y
                                                yyyyy y y  y yyyy y yyy y y yy y y
                                                yyyyy y y  y yyyy y yyy y y yy y y
                                                yyyyy y y  y yyyy y yyy y y yy y y<br><hr>
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
					
					<a href="../about/about.php">Connor Ackerman</a><br>
					<a href="../about/about.php">Eric Davis</a><br>
					<a href="../about/about.php">Travis Jones</a><br>
					<a href="../about/about.php">Elizabeth Ruby</a><br>
					<a href="../about/about.php">Andrew Wood</a><br>
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

