<!---
Andrew Wood's ePortfolio
COP4813 - Summer 2018
index.html - PHP Introduction - Assignment 5
--->
<?php
//check to see if the session is valid
session_start();

if ($_SESSION["name"] != "awood")
{
    header("location: index.php?error=2");
}
else 
{
    $sessionName = $_SESSION["name"];
} 
?>

<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <title>Address Book</title>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" /> 
        <link rel="stylesheet" type="text/css" href="../style.css"></link>	
    </head>
    <body class ="clearfix">
        <h1 style="text-align:center">Address Book</h1>
        <p style="text-align:center">Welcome to the Address Book!</p>
        <hr />
        <i>Logged in user: <?php echo $sessionName ?> </i>
        <p><a href="./logout.php">Logout</a></p>
        <hr />
        <p>Please select an option:</p>
        <button type="button" onclick="window.location.href='./add.php'">Add New Contact</button><br />
        <button type="button">Modify Existing Contact</button><br />
        <button type="button">Delete Contact</button><br />
        <hr />
        <p>Address Book Entries:</p>
        <?php
            //create reference to file
            $filename = "addressBook.txt";
            $fh = fopen($filename,'r') or die ("Fatal error!");
            //ignore first two lines of input which is the login info
            fgets($fh);
            fgets($fh);
            echo "<table class='schedule'>";
            echo "<tr><th>Full Name</th><th>Email Address</th><th>Phone Number</th>"
            . "<th>Date Added</th></tr>";
            
            $numEntries = 0;
            
            //now add all the contacts from the file
            while ($line = fgets($fh))
            {
                $parseLine = explode("|",$line);
                $name  = trim($parseLine[0]);
                $email = trim($parseLine[1]);
                $phone = trim($parseLine[2]);
                $today = trim($parseLine[3]);
                echo "<tr><td>$name</td><td>$email</td><td>$phone</td>"
                        . "<td>$today</td></tr>";
                ++$numEntries;
            }
            echo "</table>";
            echo "<p>Number of Entries: $numEntries</p>";
            fclose($fh);
        ?>
    </body>    
</html>

