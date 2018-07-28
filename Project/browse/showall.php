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

    $productID = $_GET['productID'];

    try {

        $conn = new PDO("mysql:host=$servername; dbname=$database",
        $username, $password);

        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        if($productID != "displayAll") {

            $stmt = $conn->prepare("SELECT * FROM product WHERE productID='".$productID."'");

        }
        
        else {

            $stmt = $conn->prepare("SELECT * FROM product");

        }

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
                </div>
            </div>";
        }

    }

    catch(PDOException $e) {

        echo "Connection failed: ".$e->getMessage();
    }

    $conn = null;

?>