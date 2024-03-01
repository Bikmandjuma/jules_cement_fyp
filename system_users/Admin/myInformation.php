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
      $user_image=$row_user_info['image'];
      $user_name=$row_user_info['name'];
      $user_phone=$row_user_info['phone'];
      $user_email=$row_user_info['email'];
    }

    $update_user_info=null;;
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $name_x=test_input($_POST['name']);
        $email_x=test_input($_POST['email']);
        $phone_x=test_input($_POST['phone']);

        
        if (isset($_POST['edit_info'])) {
            $sql="UPDATE admin SET name='$name_x',phone='$phone_x',email='$email_x' WHERE a_id='$users_id'";

            $query=mysqli_query($con,$sql);

            if ($query == 1) {
                ?>
                  <script>          
                    setTimeout(function(){
                        var required=document.getElementById('update_data');
                            required.style.display="block";
                            required.style.display="none";
                            window.location.href='myInformation.php';
                    },4000);

                  </script>
                <?php

                $update_user_info='<p style="background-color:teal;color:white;padding:10px;border-radius:5px;text-align:center;" id="update_data"><b>Data updated successfully !</b></p>';
            }
        }
    }

    function test_input($data){
        $data=trim($data);
        $data=stripslashes($data);
        $data=htmlspecialchars($data);
        return $data;
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
        <img src="../../assets/img/admin/<?php echo $user_image;?>" title="user image" style="width:40px;height:40px;border-radius:50%;" class="navbar-brand-img h-100" alt="main_logo">
        <span class="ms-1 font-weight-bold text-white"><?php echo $user_name;?></span>
      </a>
    </div>
    <hr class="horizontal light mt-0 mb-2">
    <div class="collapse navbar-collapse  w-auto " id="sidenav-collapse-main">
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link text-white" href="#" onclick="window.location.href='home.php'">
            <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
              <i class="fas fa-tachometer-alt"></i>
              <!-- <i class="material-icons opacity-10">dashboard</i> -->
            </div>
            <span class="nav-link-text ms-1">Dashboard</span>
          </a>
        </li>
    
        <li class="nav-item">
          <a class="nav-link text-white " href="#" onclick="window.location.href='users.php'">
            <span class="nav-link-text ms-1"><i class="fas fa-users"></i>&nbsp;&nbsp;Users</span>
          </a>
        </li>
       <!--  <li class="nav-item">
          <a class="nav-link text-white " href="#" onclick="window.location.href='report.php'">
            <span class="nav-link-text ms-1"> <i class="far fa-file-alt"></i>&nbsp;&nbsp;Reports</span>
          </a>
        </li> -->

        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle text-white" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
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
          <a class="nav-link text-white active bg-gradient-info" onclick="window.location.href='myInformation.php'" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
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
            <li class="breadcrumb-item text-sm text-dark active" aria-current="page">My information</li>
          </ol>
          <h6 class="font-weight-bolder mb-0">My information</h6>
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
        <div class="col-xl-3 col-sm-4"></div>
        <div class="col-xl-6 col-sm-4">
          <?php echo $update_user_info;?>
          <div class="card card-primary card-outline">
                    <div class="card-header text-center" style="font-size:20px; box-shadow:0px 4px 8px 0px rgba(0, 0, 0, 0.2);"><i class="fa fa-address-card"></i>&nbsp;My information </div>
                    <div class="card-body" style="overflow: auto;">

                      <div class="row">
                          <div class="col-md-12 text-center">
                              <img onclick="window.location.href='profile.php';" src="../../assets/img/admin/<?php echo $user_image;?>" class="img-circle elevation-2" alt="User Image" style="width:100px;height:100px;border-radius:50%;border:1px solid skyblue;z-index: 1;display: relative;margin-top:1px; ">

                          </div>

                      </div>           
                      
                      <hr>

                      <div class="row">
                          <div class="col-md-6 pt-3">
                            <span id="my_data"><p><b>Name :&nbsp;</b></p><p class="text-info"><b><?php echo $user_name;?></b></p></span>
                          </div>

                          <div class="col-md-6 pt-3">
                            <span id="my_data"><p><b>Phone :&nbsp;</b></p><p class="text-info"><b><?php echo $user_phone;?></b></p></span>
                          </div>
                      </div>
                      <div class="row">
                          <div class="col-md-6 pt-3">
                            <span id="my_data"><p><b>Email :&nbsp;</b></p><p class="text-info"><b><?php echo $user_email;?></b></p></span>
                          </div>
                          <div class="col-md-6 pt-3">
                            <span id="my_data"><p><b>Role :&nbsp;</b></p><p class="text-info"><b>Admin</b></p></span>
                          </div>
                      </div>

                      <hr>

                      <div class="row">
                        <div class="col-md-12 pt-3 text-center">
                          <a href="#" data-bs-toggle="modal" data-bs-target="#EditInfoModal" data-backdrop="static" data-keyboard="false"><button class="btn btn-info float-right"><i class="fa fa-edit"></i>&nbsp;Edit info</button></a>
                        </div>
                      </div>
                    
                    </div>
                  </div>

        </div>
        <div class="col-xl-3 col-sm-4"></div>
      </div>

      <!--start of edit modal -->

      <div class="modal fade" id="EditInfoModal" tabindex="-1" aria-labelledby="logoutModalLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="logoutModalLabel">Edit your information</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
              <form method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>">
                                
                  <div class="row">
                      <div class="col-md-12">
                          <div class="input-group input-group-outline mt-2" style="padding-right:30px;padding-left:30px;">
                            <input type="text" name="name" placeholder="name" value="<?php echo $user_name;?>" class="form-control" required>
                          </div>

                          <div class="input-group input-group-outline mt-2" style="padding-right:30px;padding-left:30px;">
                            <input type="number"  name="phone" value="<?php echo $user_phone;?>" class="form-control" required>
                          </div>

                          <div class="input-group input-group-outline mt-2" style="padding-right:30px;padding-left:30px;">
                            <input type="text" name="email" value="<?php echo $user_email;?>" class="form-control" required>
                          </div>
                          
                      </div>
                  </div>

                  <div class="row mt-2">
                      <div class="col-md-4"></div>
                          <div class="col-md-4">
                              <button style="margin-top:6px;" class="btn btn-info" type="submit" name="edit_info"><i class="fa fa-save"></i> Save change</button>
                          </div>
                      <div class="col-md-4"></div>
                  </div>

              </form>

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