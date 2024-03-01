    <?php

            session_start();

            include "../../Connect/connection.php";
            
            // Fetch data from the database
            $sql_gener_report = mysqli_query($con,"SELECT * from raw_material where quantity_consumed != 0"); // Adjust the column names and table name as needed

            // Generate Excel file content
            $excel_data = "Name \t Qty_stored \t Qty_consumed \t Qty_left \t Description \t Report_time \n"; // Header row
            
            while($row_gener_report =mysqli_fetch_assoc($sql_gener_report) ) {

                $qty_left_gen=$row_gener_report['quantity_stored']-$row_gener_report['quantity_consumed'];
                $gen_qty_stored=$row_gener_report['quantity_stored'].$row_gener_report['unit'];
                $gen_qty_consumed=$row_gener_report['quantity_consumed'].$row_gener_report['unit'];
                $gen_name=$row_gener_report['name'];
                $gen_descr=$row_gener_report['consumed_descr'];
                $gen_consumed_time=$row_gener_report['consumed_time'];

                // Format data as needed
                $excel_data .= $gen_name . "\t" . $gen_qty_stored . "\t" . $gen_qty_consumed . "\t" . $qty_left_gen.$row_gener_report['unit']. "\t".$gen_descr. "\t".$gen_consumed_time."\n";
            }
          

            // Send headers for Excel file download
            header("Content-type: application/vnd.ms-excel");
            header("Content-Disposition: attachment; filename=report.xls");

            // Output Excel data
            echo $excel_data;

            // Close connection
            $con->close();
    ?>