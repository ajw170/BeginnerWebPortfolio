<?php
session_start();
session_destroy();
//redirect back to home page
header("location: ./index.php");
?>