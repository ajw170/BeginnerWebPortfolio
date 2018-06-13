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
?>

<?php
    if ($_SERVER["REQUEST_METHOD"] == "POST")
    {
        //get entry number to be modified
        $name = $_POST["name"];
        
         $filename = "addressBook.txt";
         $fh = fopen($filename,'r') or die ("Fatal error!");
                    
         //read entire contents of file into the array
         $fileLines = file($filename);
         fclose($fh);
         
         //remove the entry in the array that corresponds to the desired deletion value
         array_splice($fileLines, ($name + 1), 1);
        
         $fh = fopen($filename,'w') or die ("Fatal error!");
        //put everything from the $fileLines array back.
        for ($i = 0; $i < count($fileLines); ++$i)
        {
            fwrite($fh,$fileLines[$i]);
        }

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
        <h1 style="text-align:center">Delete Entry</h1>
        <p style="text-align:center">Delete an Address Book Entry!</p>
        <hr />
        <i>Logged in user: <?php echo $sessionName ?> </i>
        <p><a href="./logout.php">Logout</a></p>
        <hr />
        <p>Use the form below to delete an entry:</p>
        <?php
            //create reference to file
            $filename = "addressBook.txt";
            $fh = fopen($filename,'r') or die ("Fatal error!");
            //ignore first two lines of input which is the login info
            fgets($fh);
            fgets($fh);
            //output top portion of table
            $entryNum = 1; //start at first entry
        ?>
        
        <table class='schedule'>
        <tr><th>Select</th><th>Full Name</th><th>Email Address</th><th>Phone Number</th>
        <th>Date Added</th></tr>
        
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
        <?php
            //now add all the contacts from the file
            while ($line = fgets($fh))
            {
                $parseLine = explode("|",$line);
                $name  = trim($parseLine[0]);
                $email = trim($parseLine[1]);
                $phone = trim($parseLine[2]);
                $today = trim($parseLine[3]);

                echo "<tr><td><button value=$entryNum name='name' type='submit'>Delete</button></td>"
                . "<td>$name</td><td><a href='mailto:$email'>$email</a></td><td>$phone</td>"
                        . "<td>$today</td></tr>";
                
                ++$entryNum;
            }
            fclose($fh);
        ?>
        
        </form>
        </table>
        

        <p><a href="./admin.php">Return to Address Book</a></p>
    </body>
</html>