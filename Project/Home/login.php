<?php
//start the session for tracking purposes
session_start();
$nameErr = $passwordErr = "";
$wrongCredentials = "Invalid Username or Password.  Please try again.";

$username = "";
$password = "";

    //Check if the form has been submitted.  If it has, validate it.
    if (filter_input(INPUT_SERVER, "REQUEST_METHOD",FILTER_SANITIZE_SPECIAL_CHARS) == "POST")
    {
        if (empty($_POST["username"]))
        {
            $nameErr = "Username is required.";
        }
        else
        {
            //get username               
            $username = cleanData($_POST["username"]);
            //set session
        }

        if (empty($_POST["password"]))
        {
            $passwordErr = "Password is required.";
        }
        else
        {
            //get password
            $password = cleanData($_POST["password"]);
        }

    }
    function cleanData($data)
    {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);

        return $data;
    }

    $showHide = "display:none";

    //Now we're ready to see if the username and password are correct
    //we need to query the database to do so
    if ($username and $password)
    {
         $servername = 'localhost';
         $dbUsername = 'group1';
         $dbPassword = 'summer2018123432';
         $database = 'group1';
         
         $conn = new mysqli($servername,$dbUsername,$dbPassword,$database);
         
         if ($conn->connect_error) {
            die("Connection failed: ") . $conn->connect_error;
         }
         
         $realPassword = "fsdjfhdsjnbuidsfnoo4875r298342rfjh93hewio";
         
         //if the query fails
         //$sql = "SELECT password FROM login WHERE username = $username";
         
         $sql = "SELECT * FROM login WHERE userName = \"$username\"";
         $result = $conn->query($sql);
     
         if (!$result)  
         {
             $showHide = "display:block";
         }
         else
         {
            $row = $result->fetch_assoc();
            $realPassword = $row["password"];
         }

        //compare values
        if (!($password == $realPassword))
        {
            $showHide = "display:block";
        }
        else //successful login
        {
            //add session variable
            $_SESSION["username"] = $username;
            //redirect back to home page
            header("location: ./index.php");
        }
        
        $conn->close();
    }           
?>

<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <title>Login to Game System</title>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" /> 
        <link rel="stylesheet" type="text/css" href="./style.css"></link>
         <script src="./scripts.js"></script> 
    </head>
    
    <body class="inner-main-content">
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
            <span class="errorPHP">*</span>Username:<input type="text" name="username" value ="<?php echo $username ?>" />
            <span class="errorPHP"><?php echo $nameErr; ?></span><br />
            <span class="errorPHP">*</span>Password:<input type="password" name="password" />
            <span class="errorPHP"><?php echo $passwordErr; ?></span><br />
            <span class="errorPHP" style="<?php echo $showHide ?>"><?php echo $wrongCredentials ?></span><br />
            <input type="submit" value="Log In!" />
        </form>
    </body>
    
    
</html>

