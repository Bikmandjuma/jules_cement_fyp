<?php

// Sample data (you can replace this with your actual data source)
$data = [10, 20, 30, 40, 50];

// Calculate average
$average = array_sum($data) / count($data);

// Output the result as JSON
echo json_encode(['average' => $average]);
?>