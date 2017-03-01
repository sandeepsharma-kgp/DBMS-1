<?php
include 'dbconnect.php';

$data = mysql_real_escape_string(htmlentities(trim($_POST['data'])));
$tracking_id = mysql_real_escape_string(htmlentities(trim($_POST['tracking_id'])));
$oid = (int)(explode("K",$tracking_id)[1]);
$query = "SELECT order_time FROM orders WHERE userid  = '$data' and orderid='$oid'";
$query_run = mysql_query($query);

$row = mysql_fetch_row($query_run);

// $data = array();

$status = "NA";
if (empty($row) || is_null($row)) {
	$status = "Track ID invalid!";

} else {
	$time = date("h:i:s");
	$row[0] = date($row[0]);
	$time_diff = (strtotime($time) - strtotime($row[0])) / 60;

	if ($time_diff > 0 && $time_diff < 20 ) {
		$status = "Preparing!";
	} else if ($time_diff > 20 && $time_diff < 40 ) {
		$status = "Dispatched!";
	} else if ($time_diff > 40) {
		$status = "Delivered!";
	}
}

// echo "Times: ".$time." ".$row[0]." Time Difference: ".$time_diff." Status: ".$status;
echo $status;

?>