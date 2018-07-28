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

    $category = $_GET['category'];

    try {

        $conn = new PDO("mysql:host=$servername; dbname=$database",
        $username, $password);

        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        if($category != "allCats" && $category != "listGenres") {

            $stmt = $conn->prepare("SELECT * FROM product WHERE LOCATE('".$category."', genre1) > 0 UNION

            SELECT * FROM product WHERE LOCATE('".$category."', genre2) > 0 UNION

            SELECT * FROM product WHERE LOCATE('".$category."', genre3) > 0 UNION

            SELECT * FROM product WHERE LOCATE('".$category."', genre4) > 0 UNION

            SELECT * FROM product WHERE LOCATE('".$category."', genre5) > 0");

        }
        else if($category == "listGenres") {

            $stmt = $conn->prepare("SELECT DISTINCT genre1 FROM product WHERE genre1 <> 'NULL' UNION 
            SELECT DISTINCT genre2 FROM product WHERE genre2 <> 'NULL' UNION 
            SELECT DISTINCT genre3 FROM product WHERE genre3 <> 'NULL' UNION 
            SELECT DISTINCT genre4 FROM product WHERE genre4 <> 'NULL' UNION 
            SELECT DISTINCT genre5 FROM product WHERE genre5 <> 'NULL'");

        }
        else {

            $stmt = $conn->prepare("SELECT * FROM product"); 

        }

        $stmt->execute();

        while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {

            if($category == "listGenres") {
                if($row['genre1'] != "") {
                    echo "<button value='".sanitize($row['genre1'])."' onclick=\"getCategories(this.value, 'allgames')\">".sanitize($row['genre1'])."</button>";
                }
                if($row['genre2'] != "") {
                    echo "<button value='".sanitize($row['genre2'])."' onclick=\"getCategories(this.value, 'allgames')\">".sanitize($row['genre2'])."</button>";
                }
                if($row['genre3'] != "") {
                    echo "<button value='".sanitize($row['genre3'])."' onclick=\"getCategories(this.value, 'allgames')\">".sanitize($row['genre3'])."</button>";
                }
                if($row['genre4'] != "") {
                    echo "<button value='".sanitize($row['genre4'])."' onclick=\"getCategories(this.value, 'allgames')\">".sanitize($row['genre4'])."</button>";
                }
                if($row['genre5'] != "") {
                    echo "<button value='".sanitize($row['genre5'])."' onclick=\"getCategories(this.value, 'allgames')\">".sanitize($row['genre5'])."</button>";
                }
            }
            else {
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

    }

    catch(PDOException $e) {

        echo "Connection failed: ".$e->getMessage();
    }

    $conn = null;

?>