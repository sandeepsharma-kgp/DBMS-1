<?php
include 'dbconnect.php';

$data = mysql_real_escape_string(htmlentities(trim($_GET['data'])));
$query = "SELECT DISTINCT name,location,average_cost_for_two,p_key FROM restaurants WHERE cisines LIKE '%$data'";
$query_run = mysql_query($query);
$data = array();
while ($row = mysql_fetch_assoc($query_run)) {
	array_push($data, $row);
}
echo json_encode($data);

?>