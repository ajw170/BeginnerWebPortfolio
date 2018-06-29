<?php
	
	//session_start();
    
    //Sanitize response from db
	function sanitize($output) {
    
		$output = stripslashes($output);
		$output = htmlspecialchars($output);
    
        if($output != "NULL") {
            return $output;
        }
        else {
            return;
        }
    }

    $servername = "localhost";
    $username = "group1";
    $password = "summer2018123432";
    $database = "group1";

    if(!is_null($_GET['productID'])) {
        $productID = $_GET['productID'];
    }
    
    $in1 = $_GET['in1'];

    try {

        $conn = new PDO("mysql:host=$servername; dbname=$database",
        $username, $password);

        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        //If productID isn't null, a single game with that ID needs to be displayed
        if(!is_null($productID)) {

            //$result = array($productID => $productID);

            $stmt = $conn->prepare("SELECT productName, rating, price, displayName, 
            genre1, genre2, genre3, genre4, genre5, skuNumber FROM product WHERE productID = '".$productID."'");

            $stmt->execute();
        }

        //If productID is null, the set of games matching a search string needs to be displayed
        else {

            $stmt = $conn->prepare("SELECT productName, system, rating, price, userName, genre1, 
            genre2, genre3, genre4, genre5, skuNumber FROM product WHERE LOCATE('".$in1."', productName) > 0 UNION
            
            SELECT productName, system, rating, price, userName, genre1, 
            genre2, genre3, genre4, genre5, skuNumber FROM product WHERE LOCATE('".$in1."', skuNumber) > 0 UNION

            SELECT productName, system, rating, price, userName, genre1, 
            genre2, genre3, genre4, genre5, skuNumber FROM product WHERE LOCATE('".$in1."', system) > 0 UNION
            
            SELECT productName, system, rating, price, userName, genre1, 
            genre2, genre3, genre4, genre5, skuNumber FROM product WHERE LOCATE('".$in1."', genre1) > 0 UNION

            SELECT productName, system, rating, price, userName, genre1, 
            genre2, genre3, genre4, genre5, skuNumber FROM product WHERE LOCATE('".$in1."', genre2) > 0 UNION

            SELECT productName, system, rating, price, userName, genre1, 
            genre2, genre3, genre4, genre5, skuNumber FROM product WHERE LOCATE('".$in1."', genre3) > 0 UNION

            SELECT productName, system, rating, price, userName, genre1, 
            genre2, genre3, genre4, genre5, skuNumber FROM product WHERE LOCATE('".$in1."', genre4) > 0 UNION

            SELECT productName, system, rating, price, userName, genre1, 
            genre2, genre3, genre4, genre5, skuNumber FROM product WHERE LOCATE('".$in1."', genre5) > 0");    

            $stmt->execute();
        }

        //echo "<table>";

        while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {

            echo 
            "<div class='r_container'>
                <h2 id='r_title'>".sanitize($row['productName'])."</h2>
                <p id='r_sys'>".sanitize($row['system'])."</p>
                <p id='r_rating'>".sanitize($row['rating'])."</p>
                <p id='r_price'>".sanitize($row['price'])."</p>
                <p id='r_seller'>Seller: ".sanitize($row['userName'])."</p>
                <p id='r_genre'>Tags: ".sanitize($row['genre1'])." ".sanitize($row['genre2'])." ".sanitize($row['genre3'])." 
                ".sanitize($row['genre4'])." ".sanitize($row['genre5'])."</p>
                <p id='r_SKU'>SKU Number: ".sanitize($row['skuNumber'])."</p>
                <hr>
            </div>";
        }

        //echo "</table>";
    }

    catch(PDOException $e) {

        echo "Connection failed: ".$e->getMessage();
    }

    $conn = null;

?>