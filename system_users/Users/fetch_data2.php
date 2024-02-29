<?php

// Include the database connection file
// include 'db_connection.php';
include "../../Connect/connection.php";

// Fetch data for stored raw materials
$sql_stored = "SELECT name, quantity_stored FROM raw_material";
$result_stored = $con->query($sql_stored);

// Fetch data for consumed raw materials
$sql_consumed = "SELECT name, quantity_consumed FROM raw_material";
$result_consumed = $con->query($sql_consumed);

// Prepare data for JSON encoding
$data_stored = array();
while ($row = $result_stored->fetch_assoc()) {
    $data_stored[$row['name']] = $row['quantity_stored'];
}

$data_consumed = array();
while ($row = $result_consumed->fetch_assoc()) {
    $data_consumed[$row['name']] = $row['quantity_consumed'];
}

// Calculate analytics for stored raw materials
$stored_analytics = array();
foreach ($data_stored as $name => $quantity) {
    $stored_analytics[$name] = array(
        'quantity' => $quantity,
        'consumed' => isset($data_consumed[$name]) ? $data_consumed[$name] : 0,
        // You can add more analytics as needed
    );
}

// Convert data to JSON format
echo json_encode($stored_analytics);

// Close the database connection
$con->close();

?>
