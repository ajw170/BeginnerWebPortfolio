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

    $in1 = $_GET['in1'];

    try {

        $conn = new PDO("mysql:host=$servername; dbname=$database",
        $username, $password);

        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $stmt = $conn->prepare("SELECT productID, forSale, productName, `system`, rating, price, userName, genre1, 
            genre2, genre3, genre4, genre5, skuNumber FROM product WHERE LOCATE('".$in1."', productName) > 0 UNION
            
            SELECT productID, forSale, productName, `system`, rating, price, userName, genre1, 
            genre2, genre3, genre4, genre5, skuNumber FROM product WHERE LOCATE('".$in1."', skuNumber) > 0 UNION

            SELECT productID, forSale, productName, `system`, rating, price, userName, genre1, 
            genre2, genre3, genre4, genre5, skuNumber FROM product WHERE LOCATE('".$in1."', `system`) > 0 UNION
            
            SELECT productID, forSale, productName, `system`, rating, price, userName, genre1, 
            genre2, genre3, genre4, genre5, skuNumber FROM product WHERE LOCATE('".$in1."', genre1) > 0 UNION

            SELECT productID, forSale, productName, `system`, rating, price, userName, genre1, 
            genre2, genre3, genre4, genre5, skuNumber FROM product WHERE LOCATE('".$in1."', genre2) > 0 UNION

            SELECT productID, forSale, productName, `system`, rating, price, userName, genre1, 
            genre2, genre3, genre4, genre5, skuNumber FROM product WHERE LOCATE('".$in1."', genre3) > 0 UNION

            SELECT productID, forSale, productName, `system`, rating, price, userName, genre1, 
            genre2, genre3, genre4, genre5, skuNumber FROM product WHERE LOCATE('".$in1."', genre4) > 0 UNION

            SELECT productID, forSale, productName, `system`, rating, price, userName, genre1, 
            genre2, genre3, genre4, genre5, skuNumber FROM product WHERE LOCATE('".$in1."', genre5) > 0");    

            $stmt->execute();

        while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {

            echo 
            "<div class='r_container'>
                <img src='../images/".sanitize($row['productName']).".png' alt='Cover Art'>
                <div class='r_text'>
                <h2 id='r_title'>".sanitize($row['productName'])."</h2>
                <p id='r_sys'>".sanitize($row['system'])."</p>
                <p id='r_rating'>".sanitize($row['rating'])."</p>
                <p id='r_price'>".sanitize($row['price'])."</p>
                <p id='r_seller'>Seller: ".sanitize($row['userName'])."</p>
                <p id='r_genre'>Tags: ".sanitize($row['genre1'])." ".sanitize($row['genre2'])." ".sanitize($row['genre3'])." 
                ".sanitize($row['genre4'])." ".sanitize($row['genre5'])."</p>
                <p id='r_SKU'>SKU Number: ".sanitize($row['skuNumber'])."</p>
                
                <p><button>Add to Cart!</button></p>
                    
                </div>
            </div>";
        }

    }

    catch(PDOException $e) {

        echo "Connection failed: ".$e->getMessage();
    }

    $conn = null;

?>