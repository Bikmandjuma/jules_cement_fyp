<?php
    // Include the database connection file
    include "../../Connect/connection.php";

    // Fetch data for stored raw materials
    $sql_stored = "SELECT name, quantity_stored, unit FROM raw_material";
    $result_stored = $con->query($sql_stored);

    // Fetch data for consumed raw materials
    $sql_consumed = "SELECT name, quantity_consumed, unit FROM raw_material";
    $result_consumed = $con->query($sql_consumed);

    // Prepare data for JSON encoding
    $data_stored = array();
    while ($row = $result_stored->fetch_assoc()) {
        $data_stored[$row['name']] = array(
            'quantity' => $row['quantity_stored'],
            'unit' => $row['unit']
        );
    }

    $data_consumed = array();
    while ($row = $result_consumed->fetch_assoc()) {
        $data_consumed[$row['name']] = array(
            'quantity' => $row['quantity_consumed'],
            'unit' => $row['unit']
        );
    }

    // Calculate analytics for stored raw materials
    $stored_analytics = array();
    foreach ($data_stored as $name => $item) {
        $stored_analytics[$name] = array(
            'quantity' => $item['quantity'],
            'unit' => $item['unit'],
            'consumed' => isset($data_consumed[$name]) ? $data_consumed[$name]['quantity'] : 0,
            // You can add more analytics as needed
        );
    }

    // Convert data to JSON format
    echo json_encode($stored_analytics);

    // Close the database connection
    $con->close();

?>