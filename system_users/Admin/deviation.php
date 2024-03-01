<?php
    // Include the database connection file
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

    // Calculate mean, median, and standard deviation for stored quantities
    $stored_quantities = array_values($data_stored);
    $mean_stored = array_sum($stored_quantities) / count($stored_quantities);
    $median_stored = median($stored_quantities);
    $std_deviation_stored = round(std_deviation($stored_quantities), 2);

    // Calculate mean, median, and standard deviation for consumed quantities
    $consumed_quantities = array_values($data_consumed);
    $mean_consumed = array_sum($consumed_quantities) / count($consumed_quantities);
    $median_consumed = median($consumed_quantities);
    $std_deviation_consumed = round(std_deviation($consumed_quantities), 2);

    // Construct analytics array
    $analytics = array(
        'stored' => array(
            'mean' => $mean_stored,
            'median' => $median_stored,
            'std_deviation' => $std_deviation_stored
        ),
        'consumed' => array(
            'mean' => $mean_consumed,
            'median' => $median_consumed,
            'std_deviation' => $std_deviation_consumed
        )
    );

    // Convert analytics data to JSON format
    echo json_encode($analytics);

    // Close the database connection
    $con->close();

    // Function to calculate the median
    function median($arr) {
        sort($arr);
        $count = count($arr);
        $middle = floor($count / 2);
        if ($count % 2 == 0) {
            return ($arr[$middle - 1] + $arr[$middle]) / 2;
        } else {
            return $arr[$middle];
        }
    }

    // Function to calculate standard deviation
    function std_deviation($arr) {
        $mean = array_sum($arr) / count($arr);
        $variance = 0.0;
        foreach ($arr as $value) {
            $variance += pow($value - $mean, 2);
        }
        return sqrt($variance / (count($arr) - 1));
    }
?>

    <div class="card-body">
        <h2>Stored Raw Materials Analytics</h2>
        <p>Mean: <?php echo $stored_mean; ?></p>
        <p>Median: <?php echo $stored_median; ?></p>
        <p>Standard Deviation: <?php echo $stored_std_deviation; ?></p>

        <h2>Consumed Raw Materials Analytics</h2>
        <p>Mean: <?php echo $consumed_mean; ?></p>
        <p>Median: <?php echo $consumed_median; ?></p>
        <p>Standard Deviation: <?php echo $consumed_std_deviation; ?></p>
    </div>