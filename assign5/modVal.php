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
    
    $name = "";
    $email = "";
    $phone = "";
    $insistFill = "";
?>

<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <title>Process Command</title>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" /> 
        <link rel="stylesheet" type="text/css" href="../style.css"></link>	
    </head>
    
    <body class ="clearfix">
        <h1 style="text-align:center">Modify Entry</h1>
        <p style="text-align:center">Modify and Address Book Entry!</p>
        <hr />
        <i>Logged in user: <?php echo $sessionName ?> </i>
        <p><a href="./logout.php">Logout</a></p>
        <hr />
        <p>Modify the Contact Entry Below:</p>
        
        <?php
            //IF THE POST WAS CALLED FROM THIS!!! PAGE
            if ($_SERVER["REQUEST_METHOD"] == "POST")
            {
                //get entry number to be modified THESE VALUES HAVE THE NEW VALUES!!!!!
                $name = $_POST["name"];
                $email = $_POST["email"];
                $phone = $_POST["phone"];
                
                $numberToModify = $_SESSION["modVal"];
                
                 //check duplicates
                $isDuplicate = checkDuplicates($name,$email,$phone);
                if ($isDuplicate)
                {
                    $insistFill = "You may not have duplicate entries.";
                }
                else
                {
                   //open file to read it all into an array
                    $filename = "addressBook.txt";
                    $fh = fopen($filename,'r') or die ("Fatal error!");
                    
                    //read entire contents of file into the array
                    $fileLines = file($filename);
                    fclose($fh);
                    
                    //now, it is in the array. access the line that is needing to be replaced.
                    $string_to_modify = $fileLines[$numberToModify + 1];
                    
                    //access current values...
                    $line = $string_to_modify;
                    $parseLine = explode("|",$line);
                    $originalName = $parseLine[0];
                    $originalEmail = $parseLine[1];
                    $originalPhone = $parseLine[2];
                    $originalDate = $parseLine[3];
                    
                    //the new date to insert
                    $today = date("m/d/y") . "\n";
                    
                    //now, replace string with new information
                    $newString = str_replace($originalName, $name, $string_to_modify);
                    $newString = str_replace($originalEmail, $email, $newString);
                    $newString = str_replace($originalPhone, $phone, $newString);
                    $newString = str_replace($originalDate, $today, $newString);
                    
                    //now, repalace the value in the array
                    $fileLines[$numberToModify + 1] = $newString;
                    
                    //finally, overrite the file
                    $fh = fopen($filename,'w') or die ("Fatal error!");
                    //put everything from the $fileLines array back.
                    for ($i = 0; $i < count($fileLines); ++$i)
                    {
                        fwrite($fh,$fileLines[$i]);
                    }

                    $insistFill = "Entry Modifed!";
                }
            }
            else //IT WAS NOT! CALLED FROM THIS PAGE
            {
                $numberToModify = $_SESSION["modVal"];
                $filename = "addressBook.txt";
                $fh = fopen($filename,'r') or die ("Fatal error!");
                //ignore first two lines of input which is the login info
                fgets($fh);
                fgets($fh);
                for ($i = 1; $i < $numberToModify; ++$i)
                {
                    fgets($fh); //move down a line
                }
                //now, get the actual line to modify
                $line = fgets($fh);
                $parseLine = explode("|",$line);
                $name  = trim($parseLine[0]);
                $email = trim($parseLine[1]);
                $phone = trim($parseLine[2]);
                fclose($fh);
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

         <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
            Full Name:<input type="text" name="name" value="<?php echo $name?>" /><br />
            Email Address:<input type="email" name="email" value="<?php echo $email?>" /><br />
            Phone Number:<input type="text" name="phone" value="<?php echo $phone?>" /><br />
            <input type="submit" value="Modify Entry" /> 
         </form>
        <p><span class ="errorPHP"><?php echo $insistFill ?></span></p>
         
        <p><a href="./admin.php">Return to Address Book</a></p>
    </body>
</html>