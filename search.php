<?php
include 'dbconnect.php';


$query = $_GET['cuisine'];
$results = ["Google","Microsoft","Emc2","Accenture","Oracle","Samsung","Apple","Infosys","Wipro","TCS","Dell","Amazon","Google","Microsoft","Emc2","Accenture","Oracle","Samsung","Apple","Infosys","Wipro","TCS","Dell","Amazon"];

// Write your query
$response = json_encode($results);
echo $response;
?>