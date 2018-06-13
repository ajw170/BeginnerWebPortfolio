<!---
Andrew Wood's ePortfolio
COP4813 - Summer 2018
index.html - PHP Introduction - Assignment 6
--->

<?php
    $statusValue = "";
    //if the page was accessed by posting
    if ($_SERVER["REQUEST_METHOD"] == "POST")
    {
        //obtain values from the form
        $orig = filter_input(INPUT_POST,'originCode',FILTER_SANITIZE_STRING);
        $dest = filter_input(INPUT_POST,'destinationCode',FILTER_SANITIZE_STRING);
        $distance = filter_input(INPUT_POST,'routeDistance',FILTER_SANITIZE_NUMBER_INT);
        $duration = filter_input(INPUT_POST,'duration',FILTER_SANITIZE_NUMBER_INT);
        $isActive = filter_input(INPUT_POST,'isActive',FILTER_SANITIZE_STRING);
        $isETOPS = filter_input(INPUT_POST,'isETOPS',FILTER_SANITIZE_STRING);
        
        //SPECIAL CASE
       // $bodyArray = $_POST['bodyClassification'];
        $bodyArray = filter_input(INPUT_POST,'bodyClassification',FILTER_DEFAULT,FILTER_REQUIRE_ARRAY);
        //need narrow body vs. widebody
        $isNarrowBody = 0;
        $isWideBody = 0;
        
        $routeClass = filter_input(INPUT_POST,'RouteClass',FILTER_SANITIZE_STRING);
        
        //convert numeric values of bools to 1 or 0
        if ($isActive == "Y")
        {
            $isActive = 1;
        }
        else
        {
            $isActive = 0;
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
         $servername = 'localhost';
         $username = 'n01418213';
         $password = 'titan7dr';
         $database = 'dbAssign6';
                    
         //create new connection to database
         $conn = new mysqli($servername,$username,$password,$database);
         
         //check connection
         if ($conn->connect_error) {
            die("Connection failed: ") . $conn->connect_error;
         }
         
         //now generate the query
         $sql = "INSERT INTO Routes (origin_code,dest_code,route_distance,duration_mins,is_Active,
             is_ETOPS,is_NarrowBody,is_WideBody,RouteClass) VALUES (\"$orig\",\"$dest\",$distance,$duration,$isActive,
                 $isETOPS,$isNarrowBody,$isWideBody,\"$routeClass\");";
         
         if ($conn->query($sql) === TRUE) 
         {
            $statusValue = "Record Added!";
         }       
         else 
         {
            $statusValue = "There was a problem adding the entry.  Please check the input and try again." . " " . $conn->error;
         }
         
         $conn->close();

    }
    //not posting updated data
    else
    {
        $statusValue = "";
        $orig = "";
        $dest = "";
        $distance = null;
        $duration = null;
        $isActive = null;
        $isETOPS = null;
        $body = null;
        $routeClass = "";
    }
?>

<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <title>Add Record</title>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" /> 
        <link rel="stylesheet" type="text/css" href="../style.css"></link>	
    </head>
    <body class ="clearfix">
        <h1 style="text-align:center">Add Record</h1>
        <hr />
        <p>Add a record to the Route database using the form below.</p>
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
             <input type="radio" name="isActive" value="Y" checked>Yes</input></br>
             <input type="radio" name="isActive" value="N">No</input></br>
             Overwater Certification:<br />
             <input type="radio" name="isETOPS" value="Y" checked>ETOPS Certified</input></br>
             <input type="radio" name="isETOPS" value="N">No Certification</input></br>
             Airframe Eligibility:<br />
             <input type="checkbox" name="bodyClassification[]" value="Widebody">Widebody<br />
             <input type="checkbox" name="bodyClassification[]" value="Narrowbody">Narrowbody<br />
             Route Class:<br />
            <select name="RouteClass">
                <option value="A">A</option>
                <option value="B">B</option>
                <option value="C">C</option>
            </select>
            <input type="submit" value="Add Record" /> 
         </form>
        <p class="error"><?php echo $statusValue ?></p>
        <p><a href="./index.php">Return to Route Database</a></p>
    </body>
</html>
