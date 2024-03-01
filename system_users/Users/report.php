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

    $users_id=$_SESSION['u_id'];
    $sql_user_info="SELECT * FROM users where u_id=".$users_id."";
    $query_user_info=mysqli_query($con,$sql_user_info);
    while ($row_user_info=mysqli_fetch_assoc($query_user_info)) {
      $user_name=$row_user_info['name'];
      $user_image=$row_user_info['image'];
    }

    $data_inserted=$high_qty_consumed=null;

    if ($_SERVER["REQUEST_METHOD"] == "POST"){

        if (isset($_POST['SubmitfileStorage'])) {
            $raw_mat_id=$_POST['Raw_material'];
            $unit=test_input($_POST['unit']);
            $description=test_input($_POST['description']);
            $quantity_consumed=test_input($_POST['quantity_consumed']);

            // date_default_timezone_set("Afrika/Kigali");
            $hours=date("H:i:s");
            $r_date=date("Y-m-d");

            $reg_date=$r_date." ".$hours;

            //check if quantity consumed is less than stored one
            $sql_id_qty=mysqli_query($con,"SELECT rm_id,unit,quantity_consumed,quantity_stored FROM raw_material where rm_id=".$raw_mat_id." ");

            while ($qty_id_row=mysqli_fetch_assoc($sql_id_qty)) {
              $qty_stored=$qty_id_row['quantity_stored'];
              $qty_consumed=$qty_id_row['quantity_consumed'];
              $qty_unit=$qty_id_row['unit'];
            }

            $new_qty_consumed=$qty_consumed+$quantity_consumed;
            $qty_left_in_stored=$qty_stored-$qty_consumed;

            if ($new_qty_consumed > $qty_stored) {
                // display message
                $high_qty_consumed='<p style="background-color:red;color:white;padding:10px;border-radius:5px;text-align:center;" id="high_qty_consumed">you entered higher quantity only <b>'.$qty_left_in_stored.$qty_unit.'</b> left in stored !</p><br>';

                ?>

                  <script type="text/javascript">
                    setTimeout(function(){
                      var high_qty_consumed=document.getElementById('high_qty_consumed');
                          high_qty_consumed.style.display="block";
                          high_qty_consumed.style.display="none";
                    },5000);
                  </script>

                <?php
            }else{

              //not insert new qty in existed one
              $sql_qty_exist=mysqli_query($con,"SELECT * FROM raw_material where rm_id=".$raw_mat_id." and raw_material.quantity_consumed != 0");

              $sql_qty_exist_count=mysqli_num_rows($sql_qty_exist);

              if ($sql_qty_exist_count != 0) {

                    $sql = "UPDATE raw_material SET quantity_consumed='$new_qty_consumed',consumed_descr='$description',unit='$unit',consumed_time='$reg_date',user_fk_id='$users_id' where rm_id=".$raw_mat_id."";
                      
                    if (mysqli_query($con, $sql)) {
                        $data_inserted='<p style="background-color:teal;color:white;padding:10px;border-radius:5px;text-align:center;" id="report_added">Report saved well !</p><br>';

                        ?>

                            <script type="text/javascript">
                              setTimeout(function(){
                                var data_added=document.getElementById('report_added');
                                data_added.style.display="block";
                                data_added.style.display="none";
                              },5000);
                            </script>

                        <?php
                    }

              }else{

                    $sql = "UPDATE raw_material SET quantity_consumed='$quantity_consumed',consumed_descr='$description',unit='$unit',consumed_time='$reg_date',user_fk_id='$users_id' where rm_id=".$raw_mat_id."";
                      
                    if (mysqli_query($con, $sql)) {
                        $data_inserted='<p style="background-color:teal;color:white;padding:10px;border-radius:5px;text-align:center;" id="report_added">Report saved well !</p><br>';

                        ?>

                            <script type="text/javascript">
                              setTimeout(function(){
                                var data_added=document.getElementById('report_added');
                                data_added.style.display="block";
                                data_added.style.display="none";
                              },5000);
                            </script>

                        <?php

                    }

              }
            
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
  <aside class="sidenav navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-start ms-3   bg-gradient-info" id="sidenav-main">
    <div class="sidenav-header">
      <i class="fas fa-times p-3 cursor-pointer text-white opacity-5 position-absolute end-0 top-0 d-none d-xl-none" aria-hidden="true" id="iconSidenav"></i>
      <a class="navbar-brand m-0" href="#" target="_blank">
        <img src="../../assets/img/users/<?php echo $user_image;?>" title="user image" style="width:40px;height:40px;border-radius:50%;" class="navbar-brand-img h-100" alt="main_logo">
        <span class="ms-1 font-weight-bold text-white"><?php echo $user_name;?></span>
      </a>
    </div>
    <hr class="horizontal light mt-0 mb-2">
    <div class="collapse navbar-collapse  w-auto " id="sidenav-collapse-main">
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link text-white" href="#" onclick="window.location.href='home.php'">
            <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
              <i class="material-icons opacity-10">dashboard</i>
            </div>
            <span class="nav-link-text ms-1">Dashboard</span>
          </a>
        </li>
    
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle text-white active bg-gradient-dark" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            <span class="nav-link-text ms-1"><i class="fa fa-tools"></i>&nbsp;&nbsp;Manage stuff</span>
          </a>
          <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
            <li><a class="dropdown-item" href="#" onclick="window.location.href='raw_material.php'"><i class="fa fa-building"></i>&nbsp;&nbsp;Raw_material</a></li>
            <li><a class="dropdown-item" href="#" onclick="window.location.href='report.php'"><i class="fa fa-file-alt"></i>&nbsp;&nbsp;Report</a></li>
            <li><a class="dropdown-item" href="#" onclick="window.location.href='file_storage.php'"><i class="fa fa-image"></i>&nbsp;&nbsp;File_storage</a></li>
          </ul>
        </li>

        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle text-white" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            <span class="nav-link-text ms-1"><i class="fa fa-cogs"></i>&nbsp;&nbsp;Settings</span>
          </a>
          <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
            <li><a class="dropdown-item" href="#" onclick="window.location.href='myInformation.php'"><i class="fa fa-address-card"></i>&nbsp;&nbsp;My info</a></li>
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
        <div class="col-xl-4 col-sm-6"></div>
        <div class="col-xl-4 col-sm-6 mb-xl-0 mb-4">
            <?php
                echo $data_inserted.$high_qty_consumed;
            ?>
            <div class="card z-index-0 fadeIn3 fadeInBottom">
              
              <div class="card-header p-0 position-relative mt-n4 z-index-2">
                <div class="bg-gradient-primary shadow-primary border-radius-lg py-3 pe-1">
                  <h4 class="text-white font-weight-bolder text-center mt-2 mb-0">Report form</h4>
                </div>
              </div>

              <div class="card-body">

                <form role="form" class="text-start" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" method="POST" enctype="multipart/form-data">

                    <div class="row">
                        <div class="col-xl-6 col-sm-6 mb-xl-0 mb-4">
                            <div class="input-group input-group-outline">

                            <select name="Raw_material" class="form-control" required>
                              <option value="">Select raw material</option>
                              <?php 
                                  
                                  $raw_mater_sql=mysqli_query($con,"SELECT * from raw_material");
                                  while ($row_select_raw_mater=mysqli_fetch_assoc($raw_mater_sql)) {
                                    $rm_id=$row_select_raw_mater['rm_id'];
                                    $rm_name=$row_select_raw_mater['name'];
                                    echo "<option value='".$rm_id."'>".$rm_name."</option>";
                                  }
                              ?>
                            </select>
                          </div>
                        </div>
                        <div class="col-xl-6 col-sm-6 mb-xl-0 mb-4">
                            <div class="input-group input-group-outline">
                              <label class="form-label">Quantity consumed</label>
                              <input type="number" class="form-control" name="quantity_consumed" required>
                            </div> 
                        </div>
                        
                    </div>
                    
                    <div class="row">
                        <div class="col-xl-6 col-sm-6 mb-xl-0 mb-4">
                            <div class="input-group input-group-outline mt-4">
                              <select name="unit" class="form-control" required>
                                <option>Select unit</option>
                                <option value="Kg">Kilogram (kg)</option>
                                <option value="t">Metric ton (t) or tonne</option>
                                <option value="lb">Pound (lb)</option>
                              </select>
                          </div>
                        </div>
                        <div class="col-xl-6 col-sm-6 mb-xl-0 mb-4">
                            <div class="input-group input-group-outline mt-4">
                              <textarea type="text" class="form-control" name="description" placeholder="description"></textarea>
                            </div> 
                        </div>
                        
                    </div>
                        
                    <div class="text-center mx-5" style="margin-top:-4px;">
                        <button type="submit" class="btn bg-gradient-info w-100 my-4 mb-2" name="SubmitfileStorage"><i class="far fa-save"></i> Save report</button>
                    </div>

                </form>
              </div>
            </div>

        </div>
        <div class="col-xl-4 col-sm-6 mb-xl-0 mb-4"></div>

        <!--displaying the data from file storage-->

        <!-- <div class="col-xl-2 col-sm-6 mb-xl-0 mb-4"></div> -->
        <div class="col-xl-12 col-sm-6 mb-xl-0 mb-4">
            
            <div class="card mt-3">
              <div class="card-header pb-0">
                <div class="row">
                  <div class="col-lg-12 col-7 text-center">
                    <h6>Report data</h6>

                    <button class="btn btn-success" onclick="window.location.href='generate_report.php'" style="float:right;margin-top: -30px;" id="generate_report_btn_id">Generate report</button>
                  </div>
                </div>
              </div>
              <div class="card-body px-0 pb-2">
                <div class="table-responsive">
                  <table class="table align-items-center mb-0 text-center table-bordered table-striped" id="example1">
                    <thead class="text-center">
                      <tr>
                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">N<sup>o</sup></th>
                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">name</th>
                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Description</th>
                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Qty_stored</th>
                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Qty_consumed</th>
                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Qty_left_in_store</th>
                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Time_ago</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                          $report_data=mysqli_query($con,"SELECT * from raw_material where quantity_consumed != 0 and raw_material.user_fk_id=".$users_id." ");

                          $report_data_count=mysqli_num_rows($report_data);
                          $count=1;
                          while ($report_row=mysqli_fetch_assoc($report_data)) {
                            $report_id=$report_row['rm_id'];
                            $report_name=$report_row['name'];
                            $quantity_stored=$report_row['quantity_stored'];
                            $quantity_consumed=$report_row['quantity_consumed'];
                            $report_rdate=$report_row['consumed_time'];
                            $report_descr=$report_row['consumed_descr'];
                            $report_unit=$report_row['unit'];

                            // Your timestamp or date string
                            $timestamp = $report_rdate;

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

                                  
                            echo '      
                              <tr>
                                <td class="text-center">
                                  '.$count++.'
                                </td>
                                <td>
                                  '.$report_name.'
                                </td>
                                <td class="align-middle text-center">
                                  '.$report_descr.'
                                </td>
                                <td class="align-middle text-center">
                                  '.$quantity_stored.$report_unit.'
                                </td>
                                <td class="align-middle text-center">
                                  '.$quantity_consumed.$report_unit.'
                                </td>
                                <td class="align-middle text-center text-info">
                                  '.$quantity_stored-$quantity_consumed.$report_unit.'
                                </td>
                                
                                <td class="align-middle text-center">
                                  '.$timeAgo.'
                                </td>
                                  
                              </tr>
                            ';

                        }

                        if ($report_data_count == 0) {
                                echo '<tr><td colspan="7" class="text-center">No report\'s data found in table !</td></tr>';
                            ?>
                              <script>
                                document.getElementById('generate_report_btn_id').style.display='none';
                              </script>
                            <?php
                        }

                      ?>
                      
                    </tbody>
                  </table>
                </div>
              </div>
            </div>

        </div>
        <!-- <div class="col-xl-2 col-sm-6 mb-xl-0 mb-4"></div> -->

      </div>
      
  </main>
  
  <!--   Core JS Files   -->
  <script src="../../assets/js/core/popper.min.js"></script>
  <script src="../../assets/js/core/bootstrap.min.js"></script>
  <script src="../../assets/js/plugins/perfect-scrollbar.min.js"></script>
  <script src="../../assets/js/plugins/smooth-scrollbar.min.js"></script>
  <script src="../../assets/js/plugins/chartjs.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/5.10.1/main.min.js"></script>

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

  <!-- DataTables  & Plugins -->
  <script src="../../assets/plugins/datatables/jquery.dataTables.min.js"></script>
  <script src="../../assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
  <script src="../../assets/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
  <script src="../../assets/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
  <script src="../../assets/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
  <script src="../../assets/plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
  <script src="../../assets/plugins/datatables-buttons/js/buttons.html5.min.js"></script>
  <script src="../../assets/plugins/datatables-buttons/js/buttons.print.min.js"></script>
  <script src="../../assets/plugins/datatables-buttons/js/buttons.colVis.min.js"></script>
  <script>
  $(function () {
    $("#example1").DataTable({
      "responsive": true, "lengthChange": false, "autoWidth": false,
      "buttons": ["excel"]
    }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
    $('#example2').DataTable({
      "paging": true,
      "lengthChange": false,
      "searching": false,
      "ordering": true,
      "info": true,
      "autoWidth": false,
      "responsive": true,
    });
  });
</script>
</body>

</html>