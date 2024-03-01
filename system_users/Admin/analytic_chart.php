<?php
    session_start();
    
    if (!isset($_SESSION['email'])) {
      ?>
        <script type="text/javascript">
          window.location.href="../../Sign_in.php";
        </script>
      <?php
    }
        
    include_once('../../Connect/connection.php');
    include_once '../../php_code/codes.php';
    $cement=new Cement;

    $user_id=$_SESSION['a_id'];

    $sql_user_info="SELECT * FROM admin where a_id=".$user_id."";
    $query_user_info=mysqli_query($con,$sql_user_info);
    while ($row_user_info=mysqli_fetch_assoc($query_user_info)) {
      $admin_image=$row_user_info['image'];
      $admin_name=$row_user_info['name'];

    }

    //fetch time ago of consumation
    $time_cons_sql=mysqli_query($con,"SELECT * from raw_material where consumed_time is not NULL");
    while ($row_time_Cons=mysqli_fetch_assoc($time_cons_sql)) {
        $time_ago=$row_time_Cons['consumed_time'];
    }

    // Your timestamp or date string
    $timestamp = $time_ago;

    // Create DateTime objects for the current time and the timestamp
    $currentDateTime = new DateTime();
    $timestampDateTime = new DateTime($timestamp);

    // Calculate the difference
    $difference = $currentDateTime->diff($timestampDateTime);

    // Format the difference as "X time ago"
    if ($difference->y > 0) {
        $timeAgo = $difference->y . ' year' . ($difference->y > 1 ? 's' : '') . ' ago';
    } elseif ($difference->m > 0) {
        $timeAgo = $difference->m . ' month' . ($difference->m > 1 ? 's' : '') . ' ago';
    } elseif ($difference->d > 0) {
        $timeAgo = $difference->d . ' day' . ($difference->d > 1 ? 's' : '') . ' ago';
    } elseif ($difference->h > 0) {
        $timeAgo = $difference->h . ' hour' . ($difference->h > 1 ? 's' : '') . ' ago';
    } elseif ($difference->i > 0) {
        $timeAgo = $difference->i . ' minute' . ($difference->i > 1 ? 's' : '') . ' ago';
    } else {
        $timeAgo = 'just now';
    }

?>
<!DOCTYPE html>
<html lang="en">

<?php require 'head.php';?>

<body class="g-sidenav-show  bg-gray-200">
  <aside class="sidenav navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-start ms-3   bg-gradient-dark" id="sidenav-main">
    <div class="sidenav-header">
      <i class="fas fa-times p-3 cursor-pointer text-white opacity-5 position-absolute end-0 top-0 d-none d-xl-none" aria-hidden="true" id="iconSidenav"></i>
      <a class="navbar-brand m-0" href="#" target="_blank">
        <img src="../../assets/img/admin/<?php echo $admin_image;?>" title="user image" style="width:40px;height:40px;border-radius:50%;" class="navbar-brand-img h-100" alt="main_logo">
        <span class="ms-1 font-weight-bold text-white"><?php echo $admin_name;?></span>
      </a>
    </div>
    <hr class="horizontal light mt-0 mb-2">
    <div class="collapse navbar-collapse  w-auto " id="sidenav-collapse-main">
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link text-white" href="#" onclick="window.location.href='home.php'">
            <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
              <!-- <i class="material-icons opacity-10">dashboard</i> -->
              <i class="fas fa-tachometer-alt"></i>

            </div>
            <span class="nav-link-text ms-1">Dashboard</span>
          </a>
        </li>
    
        <li class="nav-item">
          <a class="nav-link text-white" href="#" onclick="window.location.href='users.php'">
            <!-- <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
              <i class="material-icons">users</i>
            </div> -->
            <span class="nav-link-text ms-1"><i class="fas fa-users"></i>&nbsp;&nbsp;Users</span>
          </a>
        </li>

        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle text-white active bg-gradient-info" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            <span class="nav-link-text ms-1"><i class="fa fa-eye"></i>&nbsp;&nbsp;View stuff</span>
          </a>
          <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
             <li><a class="dropdown-item" href="#" onclick="window.location.href='raw_material.php'"><i class="fas fa-gem"></i>&nbsp;&nbsp;Raw materials</a></li>
            <li><a class="dropdown-item" href="#" onclick="window.location.href='report.php'"><i class="fa fa-file-alt"></i>&nbsp;&nbsp;Report</a></li>
            <li><a class="dropdown-item" href="#" onclick="window.location.href='analytic_chart.php'"><i class="fa fa-list-alt"></i>&nbsp;&nbsp;Analytics chart</a></li>
          </ul>

        </li>

        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle text-white" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            <span class="nav-link-text ms-1"><i class="fa fa-cogs"></i>&nbsp;&nbsp;Settings</span>
          </a>
          <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
            <li><a class="dropdown-item" href="#" onclick="window.location.href='profile.php'"><i class="fa fa-image"></i>&nbsp;&nbsp;Profile picture</a></li>
            <li><a class="dropdown-item" href="#" onclick="window.location.href='password.php'"><i class="fa fa-key"></i>&nbsp;&nbsp;Password</a></li>
          </ul>
        </li>

        <li class="nav-item">
          <a class="nav-link text-white" onclick="window.location.href='myInformation.php'" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            <span class="nav-link-text ms-1"><i class="fa fa-address-card"></i>&nbsp;&nbsp;My info</span>
          </a>
        </li>

      </ul>
    </div>

  </aside>
  <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
    <!-- Navbar -->
    <nav class="navbar navbar-main navbar-expand-lg px-0 mx-4 shadow-none border-radius-xl" id="navbarBlur" data-scroll="true">
      <div class="container-fluid py-1 px-3">
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
            <li class="breadcrumb-item text-sm"><a class="opacity-5 text-dark" href="javascript:;">Pages</a></li>
            <li class="breadcrumb-item text-sm text-dark active" aria-current="page">Analytic_chart_data</li>
          </ol>
          <h6 class="font-weight-bolder mb-0">Analytic_chart_data</h6>
        </nav>
        <div class="collapse navbar-collapse mt-sm-0 mt-2 me-md-0 me-sm-4" id="navbar">
          <?php
            require 'search.php';
          ?>
          <ul class="navbar-nav  justify-content-end">
            <li class="nav-item d-flex align-items-center">
              <a href="#" class="nav-link text-body font-weight-bold px-0"  data-bs-toggle="modal" data-bs-target="#logoutModal">
                <i class="fa fa-user me-sm-1"></i>
                <span class="d-sm-inline d-none">Logout</span>
              </a>
            </li>
          </ul>
        </div>
      </div>
    </nav>
    <!-- End Navbar -->
    <div class="container-fluid py-4">
      
      <div class="row">
        <div class="col-xl-12 col-sm-12 mb-xl-0 mb-4">
                
                <div class="card z-index-2  ">
                  <div class="card-header p-0 position-relative mt-n1 mx-3 z-index-2 bg-transparent">
                    <div class="row mt-3">
                      <div class="col-lg-12 col-7 text-center">
                        <h6>Analytics chart data</h6>
                      </div>
                    </div>
                    <div class="shadow-success border-radius-lg py-3 pe-1">
                      <div class="chart">
                        <canvas id="rawMaterialsChart" width="800" height="170"></canvas>
                      </div>
                    </div>
                  </div>
                  <div class="card-body">
                    <h6 class="mb-0 ">analytics of stored and consumed Raw materials </h6>
                    <p class="text-sm "><span class="font-weight-bolder">Stored data are in sky blue while consumed data are in pink</span></p>
                    <hr class="dark horizontal">
                    <div class="d-flex">
                      <i class="material-icons text-sm my-auto me-1"></i>
                      <p class="mb-0 text-sm">Analytic chart updated <b><?php echo $timeAgo;?></b> !</p>
                    </div>
                  </div>

                  <!---->
                  <div class="card-body">
                    <?php
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
                        $json_data = json_encode($analytics);

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

                        // Split JSON data into paragraphs
                        $stored_mean = $analytics['stored']['mean'];
                        $stored_median = $analytics['stored']['median'];
                        $stored_std_deviation = $analytics['stored']['std_deviation'];

                        $consumed_mean = $analytics['consumed']['mean'];
                        $consumed_median = $analytics['consumed']['median'];
                        $consumed_std_deviation = $analytics['consumed']['std_deviation'];
                    ?>

                        <!-- Your HTML content goes here -->
                        <div class="card-body">
                          <div class="row">
                            <!-- <div class="col-md-2"></div> -->
                            <div class="col-md-7">
                                    
                                <div class="card text-center" style="box-shadow:1px solid rgba(2, 8, 4, 1.0);">
                                  <h5>Stored Raw Materials Analytics</h5>
                                  <p>Mean: <strong><?php echo $stored_mean; ?></strong></p>
                                  <p>Median: <strong><?php echo $stored_median; ?></strong></p>
                                  <p>Standard Deviation: <strong><?php echo $stored_std_deviation; ?></strong></p>

                                  <h5>Consumed Raw Materials Analytics</h5>
                                  <p>Mean: <strong><?php echo $consumed_mean; ?></strong></p>
                                  <p>Median: <strong><?php echo $consumed_median; ?></strong></p>
                                  <p>Standard Deviation: <strong><?php echo $consumed_std_deviation; ?></strong></p>
                                </div>


                            </div>
                            <div class="col-md-5">
                              <p>
                                In summary, <b>mean</b>, <b>median</b>, and <b>deviation</b> are important statistical measures used in raw materials mining analytics to characterize and understand the distribution, central tendency, and variability of raw material quantities, providing valuable insights for decision-making and resource management in mining operations
                              </p>
                            </div>
                          </div>
                        </div>


                  </div>
                  <!---->
                </div>

              </div>
            </div>

      </div>


    </div>
      
  </main>
  
  <script>
    function deletefn(raw_material_id){
        var confirmation=confirm("are you sure you want to delete this raw material's data ?");
        if (confirmation) {
            window.location.href='delete_raw_material.php?raw_material_id='+raw_material_id+'';
        }

        return confirmation;
    }
  
        // Fetch data from fetch_data.php using AJAX
        var xhr = new XMLHttpRequest();
        xhr.open('GET', 'fetch_analytic_data.php', true);
        xhr.onload = function() {
            if (xhr.status >= 200 && xhr.status < 300) {
                // Parse JSON response
                var data = JSON.parse(xhr.responseText);

                // Extract names and quantities
                // var names = Object.keys(data);
                // var quantities = Object.values(data).map(function(item) { return item.quantity; });
                // var consumed = Object.values(data).map(function(item) { return item.consumed; });

                // Extract names, quantities, and units
                var names = Object.keys(data);
                var quantities = Object.values(data).map(function(item) { return item.quantity; });
                var units = Object.values(data).map(function(item) { return item.unit; });
                var consumed = Object.values(data).map(function(item) { return item.consumed; });


                // Create chart data
                var ctx = document.getElementById('rawMaterialsChart').getContext('2d');
                var rawMaterialsChart = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: names,
                        datasets: [
                            {
                                label: 'Stored',
                                data: quantities,
                                backgroundColor: 'rgba(54, 162, 235, 0.2)',
                                borderColor: 'rgba(54, 162, 235, 1)',
                                borderWidth: 1
                            },
                            {
                                label: 'Consumed',
                                data: consumed,
                                backgroundColor: 'rgba(255, 99, 132, 0.2)',
                                borderColor: 'rgba(255, 99, 132, 1)',
                                borderWidth: 1
                            }
                        ]
                    },
                    options: {
                        scales: {
                            yAxes: [{
                                ticks: {
                                    beginAtZero: true
                                }
                            }]
                        }
                    }
                });
            }
        };
        xhr.send();
    </script>

  <!--   Core JS Files   -->
  <script src="../../assets/js/core/popper.min.js"></script>
  <script src="../../assets/js/core/bootstrap.min.js"></script>
  <script src="../../assets/js/plugins/perfect-scrollbar.min.js"></script>
  <script src="../../assets/js/plugins/smooth-scrollbar.min.js"></script>
  <script src="../../assets/js/plugins/chartjs.min.js"></script>
  
  <script>
    var win = navigator.platform.indexOf('Win') > -1;
    if (win && document.querySelector('#sidenav-scrollbar')) {
      var options = {
        damping: '0.5'
      }
      Scrollbar.init(document.querySelector('#sidenav-scrollbar'), options);
    }
  </script>
  <!-- Github buttons -->
  <script async defer src="https://buttons.github.io/buttons.js"></script>
  <!-- Control Center for Material Dashboard: parallax effects, scripts for the example pages etc -->
  <script src="../../assets/js/material-dashboard.min.js?v=3.0.4"></script>
</body>

</html>