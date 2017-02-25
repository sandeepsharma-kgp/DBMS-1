<?php
include 'dbconnect.php';


$c = mysql_real_escape_string(htmlentities(trim($_GET['query'])));
// $c=$c."%";
$query = "SELECT cisines FROM restaurants WHERE cisines LIKE '%{$c}%'";
$query_run = mysql_query($query);
$data = array();
while ($row = mysql_fetch_array($query_run)) {
	$tmp = trim($row['cisines']);
	array_push($data, $tmp);
}
$response = array_unique($data, SORT_REGULAR);
echo json_encode($response);
?>