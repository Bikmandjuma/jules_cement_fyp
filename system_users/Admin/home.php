<?php
    session_start();
    
    if (!isset($_SESSION['email'])) {
      ?>
        <script type="text/javascript">
          window.location.href="../../Sign_in.php";
        </script>
      <?php
    }
    
    include "../../php_code/codes.php";
    include "../../Connect/connection.php";
    
    $cement=new Cement;

    $users_id=$_SESSION['a_id'];
    $sql_user_info="SELECT * FROM admin where a_id=".$users_id."";
    $query_user_info=mysqli_query($con,$sql_user_info);
    while ($row_user_info=mysqli_fetch_assoc($query_user_info)) {
      $admin_image=$row_user_info['image'];
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
        <span class="ms-1 font-weight-bold text-white"><?php echo $_SESSION['name'];?></span>
      </a>
    </div>
    <hr class="horizontal light mt-0 mb-2">
    <div class="collapse navbar-collapse  w-auto " id="sidenav-collapse-main">
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link text-white active bg-gradient-info" href="#" onclick="window.location.href='home.php'">
            <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
              <i class="material-icons opacity-10">dashboard</i>
            </div>
            <span class="nav-link-text ms-1">Dashboard</span>
          </a>
        </li>
    
        <li class="nav-item">
          <a class="nav-link text-white " href="#" onclick="window.location.href='users.php'">
            <!-- <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
              <i class="material-icons">users</i>
            </div> -->
            <span class="nav-link-text ms-1"><i class="fas fa-users"></i>&nbsp;&nbsp;Users</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-white " href="#" onclick="window.location.href='report.php'">
            <span class="nav-link-text ms-1"> <i class="far fa-file-alt"></i>&nbsp;&nbsp;Reports</span>
          </a>
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
            <li class="breadcrumb-item text-sm text-dark active" aria-current="page">Dashboard</li>
          </ol>
          <h6 class="font-weight-bolder mb-0">Dashboard</h6>
        </nav>
        <div class="collapse navbar-collapse mt-sm-0 mt-2 me-md-0 me-sm-4" id="navbar">
          <!-- <div class="ms-md-auto pe-md-3 d-flex align-items-center">
            <div class="input-group input-group-outline">
              <label class="form-label">Type here...</label>
              <input type="text" class="form-control">
            </div>
          </div> -->
          <?php
            require 'search.php';
          ?>
          <ul class="navbar-nav  justify-content-end">
           <!--  <li class="nav-item d-flex align-items-center">
              <a class="btn btn-outline-primary btn-sm mb-0 me-3" target="_blank" href="https://www.creative-tim.com/builder/material?ref=navbar-dashboard">Online Builder</a>
            </li> -->
            <li class="nav-item d-flex align-items-center">
              <a href="#" class="nav-link text-body font-weight-bold px-0" data-bs-toggle="modal" data-bs-target="#logoutModal">
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
        <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
          <div class="card">
            <div class="card-header p-3 pt-2">
              <div class="icon icon-lg icon-shape bg-gradient-dark shadow-dark text-center border-radius-xl mt-n4 position-absolute">
                <i class="fa fa-users"></i>
              </div>
              <div class="text-end pt-1">
                <p class="text-sm mb-0 text-capitalize">Users (employee)</p>
                <h4 class="mb-0"><?php echo $cement->users_counts();?></h4>
              </div>
            </div>
            <hr class="dark horizontal my-0">
            <div class="card-footer p-3">
              <p class="mb-0"><span class="text-success text-sm font-weight-bolder"><?php echo $cement->users_counts();?></span> all users</p>
            </div>
          </div>
        </div>
        <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
          <div class="card">
            <div class="card-header p-3 pt-2">
              <div class="icon icon-lg icon-shape bg-gradient-primary shadow-primary text-center border-radius-xl mt-n4 position-absolute">
                <i class="far fa-file-alt"></i>
              </div>
              <div class="text-end pt-1">
                <p class="text-sm mb-0 text-capitalize">Report</p>
                <h4 class="mb-0"><?php echo $cement->report_count_on_admin();?></h4>
              </div>
            </div>
            <hr class="dark horizontal my-0">
            <div class="card-footer p-3">
              <p class="mb-0"><span class="text-success text-sm font-weight-bolder"><?php echo $cement->report_count_on_admin();?> </span>all report</p>
            </div>
          </div>
        </div>
        <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
          <div class="card">
            <div class="card-header p-3 pt-2">
              <div class="icon icon-lg icon-shape bg-gradient-success shadow-success text-center border-radius-xl mt-n4 position-absolute">
                <!-- <i class="far fa-material"></i> -->
                <i class="fas fa-gem"></i>
              </div>
              <div class="text-end pt-1">
                <p class="text-sm mb-0 text-capitalize">Raw materials</p>
                <h4 class="mb-0"><?php echo $cement->raw_materials_count();?></h4>
              </div>
            </div>
            <hr class="dark horizontal my-0">
            <div class="card-footer p-3">
              <p class="mb-0"><span class="text-danger text-sm font-weight-bolder"><?php echo $cement->raw_materials_count();?></span> all Raw materials</p>
            </div>
          </div>
        </div>
        <div class="col-xl-3 col-sm-6">
          <div class="card">
            <div class="card-header p-3 pt-2">
              <div class="icon icon-lg icon-shape bg-gradient-info shadow-info text-center border-radius-xl mt-n4 position-absolute">
                <!-- <i class="far fa-online-users"></i> -->
                <i class="fas fa-user-circle"></i>
              </div>
              <div class="text-end pt-1">
                <p class="text-sm mb-0 text-capitalize">Online users</p>
                <h4 class="mb-0"><?php echo $cement->oncline_users_counts();?></h4>
              </div>
            </div>
            <hr class="dark horizontal my-0">
            <div class="card-footer p-3">
              <p class="mb-0"><span class="text-success text-sm font-weight-bolder"><?php echo $cement->oncline_users_counts();?> </span>all online users</p>
            </div>
          </div>
        </div>
      </div>
      <div class="row mt-4">
        
        <div class="col-lg-12 col-md-12 mt-1 mb-4">
          <div class="card z-index-2  ">
            <div class="card-header p-0 position-relative mt-n1 mx-3 z-index-2 bg-transparent">
              <div class="shadow-success border-radius-lg py-3 pe-1">
                <div class="chart">
                  <!-- <canvas id="chart-line" class="chart-canvas" height="170"></canvas> -->
                  <canvas id="rawMaterialsChart" width="800" height="170"></canvas>
                </div>
              </div>
            </div>
            <div class="card-body">
              <h6 class="mb-0 ">analytics of stored and consumed Raw materials </h6>
              <p class="text-sm "><span class="font-weight-bolder">Stored data is in sky blue while consumed data is in pink</span></p>
              <hr class="dark horizontal">
              <div class="d-flex">
                <i class="material-icons text-sm my-auto me-1"></i>
                <p class="mb-0 text-sm">Analytic chart updated <b><?php echo $timeAgo;?></b> !</p>
              </div>
            </div>
          </div>
        </div>

      </div>
      
  </main>
    
    <script>
        // Fetch data from fetch_data.php using AJAX
        var xhr = new XMLHttpRequest();
        xhr.open('GET', 'fetch_analytic_data.php', true);
        xhr.onload = function() {
            if (xhr.status >= 200 && xhr.status < 300) {
                // Parse JSON response
                var data = JSON.parse(xhr.responseText);

                // Extract names and quantities
                var names = Object.keys(data);
                var quantities = Object.values(data).map(function(item) { return item.quantity; });
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
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  
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