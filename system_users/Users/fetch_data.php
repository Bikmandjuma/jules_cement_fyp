<?php

  // Include the database connection file
  include "../../Connect/connection.php";

  // Fetch analytical data from the database
  // $sql = "SELECT metric, value FROM analytics_data";
  $sql="SELECT raw_material.name as metric,raw_material.quantity as value from report inner join raw_material on raw_material.rm_id=report.rm_fk_id";

  $result = $con->query($sql);

  // Prepare data for JSON encoding 
  $data = array();
  $sum=0;
  while ($row = $result->fetch_assoc()) {
      $data[$row['metric']][] = $row['value'];
  }

  // Convert data to JSON format
  echo json_encode($data);
  // print_r($data);

  // Close the database connection
  // $conn->close();

?>
