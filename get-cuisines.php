<?php
include 'dbconnect.php';


/*$query = $_GET['data'];

// Write your query
$response = json_encode($results);
echo $response;*/

$data = mysql_real_escape_string(htmlentities(trim($_GET['data'])));
// $c=$c."%";
$query = "SELECT DISTINCT name,location,average_cost_for_two FROM restaurants WHERE cisines  = '$data'";
$query_run = mysql_query($query);
$data = array();
while ($row = mysql_fetch_assoc($query_run)) {
	array_push($data, $row);
}
echo json_encode($data);

?>