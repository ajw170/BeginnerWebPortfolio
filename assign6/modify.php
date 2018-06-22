<!---
Andrew Wood's ePortfolio
COP4813 - Summer 2018
index.html - PHP Introduction - Assignment 6
--->

<?php
    session_start();
    $routeToModify = $_SESSION["routeToAccess"];
    $statusValue = "";
    $error = 0;
    
    //this indicates we'd be modifying the record
    if ($_SERVER["REQUEST_METHOD"] == "POST")
    {
        //obtain values from the form
        $orig = filter_input(INPUT_POST,'originCode',FILTER_SANITIZE_STRING);
        $dest = filter_input(INPUT_POST,'destinationCode',FILTER_SANITIZE_STRING);
        $distance = filter_input(INPUT_POST,'routeDistance',FILTER_SANITIZE_NUMBER_INT);
        $duration = filter_input(INPUT_POST,'duration',FILTER_SANITIZE_NUMBER_INT);
        $isDeployed = filter_input(INPUT_POST,'isActive',FILTER_SANITIZE_STRING);
        $isETOPS = filter_input(INPUT_POST,'isETOPS',FILTER_SANITIZE_STRING);
        
        //SPECIAL CASE
       // $bodyArray = $_POST['bodyClassification'];
        $bodyArray = filter_input(INPUT_POST,'bodyClassification',FILTER_DEFAULT,FILTER_REQUIRE_ARRAY);
        //need narrow body vs. widebody
        $isNarrowBody = 0;
        $isWideBody = 0;
        
        $routeClass = filter_input(INPUT_POST,'RouteClass',FILTER_SANITIZE_STRING);
        
        //convert numeric values of bools to 1 or 0
        if ($isDeployed == "Y")
        {
            $isDeployed = 1;
        }
        else
        {
            $isDeployed = 0;
        }
        
        if ($isETOPS == "Y")
        {
           $isETOPS = 1;
        }
        else
        {
            $isETOPS = 0;
        }
        
        //check to avoid errors if no boxes were checked
        if (is_array($bodyArray))
        {
            if (in_array('Widebody', $bodyArray))
            {
                    $isWideBody = 1;
            }
            if (in_array('Narrowbody', $bodyArray))
            {
                    $isNarrowBody = 1;
            }
        }
        
        //insert the values into the database
        /*
         $servername = 'localhost';
         $username = 'n01418213';
         $password = 'titan7dr';
         $database = 'dbAssign6';
         * 
         */
         
         $servername = 'localhost';
         $username = 'n01418213';
         $password = 'titan7dr';
         $database = 'n01418213';
                    
         //create new connection to database
         $conn = new mysqli($servername,$username,$password,$database);
         
         //check connection
         if ($conn->connect_error) {
            die("Connection failed: ") . $conn->connect_error;
         }
         
         //now generate the query
         //$sql = "UPDATE Routes SET origin_code=\"$orig\" WHERE routeID=$routeToModify";
         $sql = $conn->prepare("UPDATE Routes SET origin_code = ? WHERE routeID= ?");
         $sql->bind_param("si",$orig,$routeToModify);
         if(!$sql->execute())
         {
             $error = 1;
         }
        
         $sql = $conn->prepare("UPDATE Routes SET dest_code=? WHERE routeID=?");
         $sql->bind_param("si",$dest,$routeToModify);
         if(!$sql->execute())
         {
             $error = 1;
         }
        
         $sql = $conn->prepare("UPDATE Routes SET route_distance=? WHERE routeID=?");
         $sql->bind_param("ii",$distance,$routeToModify);
         if(!$sql->execute())
         {
             $error = 1;
         }
         
         $sql = $conn->prepare("UPDATE Routes SET duration_mins=? WHERE routeID=?");
         $sql->bind_param("ii",$duration,$routeToModify);
         if(!$sql->execute())
         {
             $error = 1;
         }
         
         $sql = $conn->prepare("UPDATE Routes SET is_Active=? WHERE routeID=?");
         $sql->bind_param("ii",$isDeployed,$routeToModify);
         if(!$sql->execute())
         {
             $error = 1;
         }
         
         $sql = $conn->prepare("UPDATE Routes SET is_ETOPS=? WHERE routeID=?");
         $sql->bind_param("ii",$isETOPS,$routeToModify);
         if(!$sql->execute())
         {
             $error = 1;
         }
         
         $sql = $conn->prepare("UPDATE Routes SET is_NarrowBody=? WHERE routeID=?");
         $sql->bind_param("ii",$isNarrowBody,$routeToModify);
         if(!$sql->execute())
         {
             $error = 1;
         }
         
         $sql = $conn->prepare("UPDATE Routes SET is_WideBody=? WHERE routeID=?");
         $sql->bind_param("ii",$isWideBody,$routeToModify);
         if(!$sql->execute())
         {
             $error = 1;
         }
         
         $sql = $conn->prepare("UPDATE Routes SET RouteClass=? WHERE routeID=?");
         $sql->bind_param("si",$routeClass,$routeToModify);
         if(!$sql->execute())
         {
             $error = 1;
         }
               
         if (!$error) 
         {
            $statusValue = "Record Modified!";
         }       
         else 
         {
            $statusValue = "There was a problem modifying the record.  Please check the input and try again." . " " . $conn->error;
         }
         
         $conn->close();
    }
    //display values currently contained
    else
    {
        /*
        $servername = 'localhost';
        $username = 'n01418213';
        $password = 'titan7dr';
        $database = 'dbAssign6';
         * */
         
        
        $servername = 'localhost';
        $username = 'n01418213';
        $password = 'titan7dr';
        $database = 'n01418213';
        //create new connection to database
        $conn = new mysqli($servername,$username,$password,$database);

        //check connection
        if ($conn->connect_error) 
        {
            die("Connection failed: ") . $conn->connect_error;
        }

        //select entire table
        $sql = "SELECT * FROM Routes WHERE routeID=$routeToModify;";

        //if the query did not return an error
        if ($result = $conn->query($sql))
        {
            $row = $result->fetch_assoc();

            $orig = $row["origin_code"];
            $dest = $row["dest_code"];
            $distance = $row["route_distance"];
            $duration = $row["duration_mins"];
            $isDeployed = $row["is_Active"];
            $isETOPS = $row["is_ETOPS"];
            $isNarrowBody = $row["is_NarrowBody"];
            $isWideBody = $row["is_WideBody"];
            $routeClass = $row["RouteClass"];

        }
    }

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <title>Modify Record</title>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" /> 
        <link rel="stylesheet" type="text/css" href="../style.css"></link>	
    </head>
    <body class ="clearfix">
        <h1 style="text-align:center">Modify Record</h1>
        <hr />
        <p>Note: Only 3 letter Airport Codes are valid.</p>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
             Origin Code:
             <input type="text" name="originCode" value="<?php echo $orig?>"</input><br />
             Destination Code:
             <input type="text" name="destinationCode" value="<?php echo $dest?>"</input><br />
             Route Distance:
             <input type="number" name="routeDistance" value="<?php echo $distance?>"</input><br />
             Flight Duration (Minutes):
             <input type="number" name="duration" value="<?php echo $duration?>"</input><br />
             Currently Deployed:<br />
             <input type="radio" name="isActive" value="Y" <?php if($isDeployed){echo "checked";} ?>>Yes</input></br>
             <input type="radio" name="isActive" value="N" <?php if(!$isDeployed){echo "checked";} ?>>No</input></br>
             Overwater Certification:<br />
             <input type="radio" name="isETOPS" value="Y" <?php if($isETOPS){echo "checked";} ?>>ETOPS Certified</input></br>
             <input type="radio" name="isETOPS" value="N" <?php if(!$isETOPS){echo "checked";} ?>>No Certification</input></br>
             Airframe Eligibility:<br />
             <input type="checkbox" name="bodyClassification[]" value="Widebody" <?php if($isNarrowBody){echo "checked";} ?>>Widebody<br />
             <input type="checkbox" name="bodyClassification[]" value="Narrowbody" <?php if($isWideBody){echo "checked";} ?>>Narrowbody<br />
             Route Class:<br />
            <select name="RouteClass">
                <option value="A" <?php if($routeClass == "A"){echo "selected";} ?>>A</option>
                <option value="B" <?php if($routeClass == "B"){echo "selected";} ?>>B</option>
                <option value="C" <?php if($routeClass == "C"){echo "selected";} ?>>C</option>
            </select><br />
            <input type="submit" value="Modify Record" /> 
         </form>

        <p class="error"><?php echo $statusValue ?></p>
        <p><a href="./index.php">Return to Route Database</a></p>
    </body>
</html>