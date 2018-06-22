<?php

//connect to database
         $servername = 'localhost';
         $username = 'n01418213';
         $password = 'titan7dr';
         $database = 'n01418213';
         
         $conn = new mysqli($servername,$username,$password,$database);
         
         //check connection
         if ($conn->connect_error)
         {
            die("Connection failed: ") . $conn->connect_error;
         }
         else
         {
             echo "Connection Succeed.";
         }

?>

<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<title>Contact Forms with PHP</title>
		<meta charset="UTF-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0" /> 
                <link rel="stylesheet" type="text/css" href="../style.css"></link>	
        </head>
    
    	<body class="clearfix">
		<h1 style="text-align:center">Database Access and Modification with PHP</h1>
		<p style="text-align:center">This system simulates an airline route database.</p>
                <p style="text-align:center">Utilize the forms below to read, update, and delete and create new entries!</p>
		<hr />
                <p><strong>This is a test page.</strong></p>
        
                
                <hr />
		<h2>My ePortfolio Index</h2>
		<p><a href="../index.html">Andrew's ePortfolio Index</a></p>
	</body>
</html>