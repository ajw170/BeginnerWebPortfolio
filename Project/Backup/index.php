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
	<link rel="stylesheet" type="text/css" href="style.css">
	<meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
        <script src="./scripts.js"></script>
</head>
<body onload="getMyGames()">

	<div class="outer-whole">
		<img class="background-img" src="https://cdn.segmentnext.com/wp-content/uploads/2016/09/FFXVWallpaper.jpg">
		<div class="header">
			<div class="navbar-positioning">
				<div class="navbar">
					<ul class="navbar-left">
						<li><a>ICON+NAME</a></li>
						<li><a>Categories</a></li>
						<li><a>New</a></li>
						<li><a>LINK3</a></li>
						<li><a>LINK4</a></li>
					</ul>
					<ul class="navbar-right">
						<li><a>SEARCH BAR</a></li>
                                                <?php
                                                //this will cause issues if the name is too long, it will cause
                                                //the div to drop to the next line
                                                if ($loggedInUser)
                                                {
                                                    echo "<li>";
                                                    echo $greeting;
                                                    echo "<a href='./logout.php'>LOGOUT</a>";
                                                    echo "</li>";
                                                }
                                                else
                                                {
                                                    echo "<li><a href='./login.php'>LOGIN</a></li>";
                                                }      
                                                ?>
						<li><a>CART</a></li>
					</ul>
				</div>
			</div>
		</div>
		<div class="featured-event">
			<div class="featured-event-text">
				Where do the featured events come from?
			</div>
		</div>
		<div class="welcome-banner">
			<div class="welcome-text">
				TRANSPARENT BACKGROUND, TEXT SHOWS ONLY welcome welcome welcome
				welcome welcome welcome
				welcome welcome welcome
			</div>
		</div>
		<div class="inner-whole">
			<div class="inner-header">Inner header</div>
			<div class="inner-main-content">
                                <div class ="container">
                                        <?php echo $myGamesAreaTitle; ?>
                                </div>
				
				<div id ="myGamesArea" class="content-left">
                                        
                                      <!--
					<div class="container">
                                               
						asldfj laksjd flkjsadlfj lksdj flkjasdlfkj aslkdjflksadj flkjsadf<br><hr>
					</div>
					<div class="container">
						Put features in these "container" divs<br>
						alskdjflkjsd
						asldfj laksjd flkjsadlfj lksdj flkjasdlfkj aslkdjflksadj flkjsadf<br><hr>
					</div>
					<div class="container">
						alskdjflkajsdflkjasdlkfjlkasjdf
						asdffkjasd;flkjalksdjflkajsd flsajd flkjsdlkfj lksajd flkjsadlkfj alskdjflkjsd
						asldfj laksjd flkjsadlfj lksdj flkjasdlfkj aslkdjflksadj flkjsadf<br><hr>
					</div>
					<div class="container">
						alskdjflkajsdflkjasdlkfjlkasjdf
						asdffkjasd;flkjalksdjflkajsd flsajd flkjsdlkfj lksajd flkjsadlkfj alskdjflkjsd
						asldfj laksjd flkjsadlfj lksdj flkjasdlfkj aslkdjflksadj flkjsadf<br><hr>
					</div>
                                        -->
                                      
				</div>
				<div class="vertical-line"><hr></div>
			
				<div class="content-right">
				
					<div class="container">
						More "container" divs<br>
						This time on the right side<br>
						xxxxx
						xxxxx x xxxxxx xxxxxxxx x xxx xxxxx
						xxxxx x xxxxxx xxxxxxxx x xxx xxxxx
						xxxxx x xxxxxx xxxxxxxx x xxx xxxxx<br><hr>
					</div>
					<div class="container">
						xxxx xxxxxxxx x xxx xxxx xxxxxxxx x xxx
						xxxx xxxxxxxx x xxx xxxx xxxxxxxx x xxx
						xxxx xxxxxxxx x xxx xxxx xxxxxxxx x xxx
						xxxx xxxxxxxx x xxx<br><hr>
					</div>
					<div class="container">
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
				<p>
					footer footer footer footer footer footer
					footer footer footer footer footer footer
					footer footer footer footer footer footer
					footer footer footer footer footer footer
					footer footer footer footer footer footer
				</p>
			</div>
		</div>

	</div>

</body>
</html>

