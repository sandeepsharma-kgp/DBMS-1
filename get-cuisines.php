<?php
include 'dbconnect.php';


$query = $_GET['data'];

// Write your query
$response = json_encode($results);
echo $response;
?>