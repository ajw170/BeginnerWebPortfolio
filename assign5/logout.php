<!---
Andrew Wood's ePortfolio
COP4813 - Summer 2018
index.html - PHP Introduction - Assignment 5
--->
<?php

session_start();

if ($_SESSION["name"] != "awood")
{
    header("location: index.php?error=2");
}
else 
{
    $sessionName = $_SESSION["name"];
    session_destroy();
}

?>

<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <title>Logout</title>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" /> 
        <link rel="stylesheet" type="text/css" href="../style.css"></link>	
    </head>
    <body class ="clearfix">
        <p>Goodbye, <?php echo $sessionName ?>.</p>
        <p><a href="./index.php">Return to Login Page<a></p>
    </body>
</html>