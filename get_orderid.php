<?php
include 'dbconnect.php';

$data = mysql_real_escape_string(htmlentities(trim($_POST['data'])));
$description = mysql_real_escape_string(htmlentities(trim($_POST['description'])));
$time = date("h:i:s");
$query = "INSERT INTO orders (userid,order_time,description) VALUES ('$data','$time','$description')";
$query_run = mysql_query($query);
$query = "SELECT last_insert_id() from orders";

if (mysql_query($query)) {
    $last_id = mysql_insert_id();
}
// $query_run = mysql_query($query);

echo "TRACK".$last_id;

?>