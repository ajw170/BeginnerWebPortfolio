<!---
Andrew Wood's ePortfolio
COP4813 - Summer 2018
index.html - PHP Introduction - Assignment 5
--->
<?php
    //start session so I can redirect users to other page while maintaining information
    session_start();
    //global variables
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<title>Contact Forms with PHP</title>
		<meta charset="UTF-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0" /> 
                <link rel="stylesheet" type="text/css" href="../style.css"></link>	
        </head>
    
    	<body class="clearfix">
		<h1 style="text-align:center">Contact Forms with PHP</h1>
		<p style="text-align:center">The contact form application allows you to add, modify, and delete contacts from
                    an address book system.</p>
                <p style="text-align:center">Make sure you input the correct user name and password to access the system!</p>
		<hr />
                
                <?php
                    $nameErr = $passwordErr = "";
                    $wrongCredentials = "Invalid Username or Password.  Please try again.";
                    $name = "";
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
                            $name = cleanData($_POST["username"]);
                            //set session
                            $_SESSION["name"] = $name;
                            $_SESSION["password"] = "";
                        }
                        
                        if (empty($_POST["password"]))
                        {
                            $passwordErr = "Password is required.";
                        }
                        else
                        {
                            //get password
                            $password = cleanData($_POST["password"]);
                            $_SESSION["password"] = $password;
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
                    //we need to read the first two lines in the txt file
                    //if we're supplied with a username and password
                    if ($name and $password)
                    {
                        //open the file to see if the username and password are correct
                        $fileName = "addressBook.txt";
                        $fh = fopen($fileName,'r') or die("Error opening file");
                        $uname = trim(fgets($fh));  //remove newline character
                        $pass = trim(fgets($fh)); //remove newline character
                        fclose($fh);
                        
                        //compare values
                        if (!(($name == $uname) and ($pass == $password)))
                        {
                            $wrongCredentials = "Invalid Username or Password.  Please try again.";
                            $showHide = "display:block";
                        }
                        else //direct user to the address book
                        {
                            header("location: admin.php");
                            $showHide = "display:none";
                        }
                    }           
                ?>
                
                <?php
                    $noSession = "display:block";
                
                    //used if the page is redirected back
                    if (isset($_GET["error"])) //if there is an error
                    {
                        $error = $_GET["error"];
                        if ($error == 2)
                        {
                            $noSesson = "display:block";
                        }
                    }
                    else
                    {
                        $noSession = "display:none";
                    }
                ?>
                
                <p>Welcome to the Address Book system!  Please enter a valid username and password for access.</p>
                <p class = "errorPHP" style="<?php echo $noSession?>">You must be logged in with valid credentials.</p>
                <p><span class="errorPHP">* required field</span></p>
                <p>
                    <!-- Once the data is submitted, the information is returned to the page itself -->
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
                        <span class="errorPHP">*</span>Username:<input type="text" name="username" value ="<?php echo $name ?>" />
                        <span class="errorPHP"><?php echo $nameErr; ?></span><br />
                        <span class="errorPHP">*</span>Password:<input type="password" name="password" />
                        <span class="errorPHP"><?php echo $passwordErr; ?></span><br />
                        <span class="errorPHP" style="<?php echo $showHide ?>"><?php echo $wrongCredentials ?></span><br />
                        <input type="submit" value="Log In!" />
                    </form>
                </p>
                
                

                
                
                <hr />
		<h2>My ePortfolio Index</h2>
		<p><a href="../index.html">Andrew's ePortfolio Index</a></p>
	</body>
</html>





