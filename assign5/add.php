<!---
Andrew Wood's ePortfolio
COP4813 - Summer 2018
index.html - PHP Introduction - Assignment 5
--->
<?php
    session_start();
    
    if ($_SESSION["name"] != "awood" or $_SESSION["password"] != "abc123")
    {
        header("location: index.php?error=2");
    }
    else 
    {
        $sessionName = $_SESSION["name"];
    } 
    
    $sessionName = $_SESSION["name"];
    $insistFill = "";
    $name = "";
    $email = "";
    $phone = "";
    $today = "";
    
?>

<?php
    if ($_SERVER["REQUEST_METHOD"] == "POST")
    {
        //check to see if any of the spots were empty.  If they were, display an error.
        if((empty($_POST["name"])) or (empty($_POST["email"])) or (empty($_POST["phone"])))
        {
            $insistFill = "You must enter a full entry.";
        }
        else
        {
            $name = $_POST["name"];
            $email = $_POST["email"];
            $phone = $_POST["phone"];
            $today = date("m/d/y");
            
            //check duplicates
            $isDuplicate = checkDuplicates($name,$email,$phone);
            if ($isDuplicate)
            {
                $insistFill = "You may not have duplicate entries.";
            }
            else
            {
            
                //Now, add the entries to the document
                $filename = "addressBook.txt";
                //open file for appending
                $fh = fopen($filename,'a') or die ("Fatal error!");
                fwrite($fh,$name);
                fwrite($fh,"|");
                fwrite($fh,$email);
                fwrite($fh,"|");
                fwrite($fh,$phone);
                fwrite($fh,"|");
                fwrite($fh,$today);
                fwrite($fh,"\n");
                fclose($fh);   

                $insistFill = "Entry Added!";
            }
        }
        
    }
    
    function checkDuplicates($name, $email, $phone)
    {
        $filename = "addressBook.txt";
        $fh = fopen($filename,'r') or die ("Fatal error!");
        //skip username and password lines
        fgets($fh);
        fgets($fh);
        
        //loop through entries checking for duplicates
        while ($line = fgets($fh))
        {
            $parseLine = explode("|",$line);
            $listName  = trim($parseLine[0]);
            $listEmail = trim($parseLine[1]);
            $listPhone = trim($parseLine[2]);
            
            //if all entries are the same
            if ($listName == $name and $listEmail == $email and $listPhone == $phone)
            {
                //it is a duplicate
                fclose($fh);
                return true;
            }
        }
       
        fclose($fh);
        return false; //default return value
    }
?>

<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <title>Process Command</title>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" /> 
        <link rel="stylesheet" type="text/css" href="../style.css"></link>	
    </head>
    <body class ="clearfix">
        <h1 style="text-align:center">Add Entry</h1>
        <p style="text-align:center">Add an entry to the Address Book!</p>
        <hr />
        <i>Logged in user: <?php echo $sessionName ?> </i>
        <p><a href="./logout.php">Logout</a></p>
        <hr />
        <p>Add an entry to the address book using the form below:</p>
         <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
            Full Name:<input type="text" name="name" /><br />
            Email Address:<input type="email" name="email" /><br />
            Phone Number:<input type="text" name="phone" /><br />
            <input type="submit" value="Add Entry" /> 
         </form>
        <p><span class ="errorPHP"><?php echo $insistFill ?></span></p>
        <p><a href="./admin.php">Return to Address Book</a></p>
    </body>
</html>
