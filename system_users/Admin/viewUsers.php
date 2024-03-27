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

    $users_id=$_SESSION['a_id'];
    $sql_user_info="SELECT * FROM admin where a_id=".$users_id."";
    $query_user_info=mysqli_query($con,$sql_user_info);
    while ($row_user_info=mysqli_fetch_assoc($query_user_info)) {
      $admin_image=$row_user_info['image'];
      $admin_name=$row_user_info['name'];
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
        <img src="../../assets/img/admin/<?php echo $admin_image;?>" title="user image" style="width:40px;height:40px;border-radius:50%;" class="navbar-brand-img img-circle" alt="main_logo">
        <span class="ms-1 font-weight-bold text-white"><?php echo $admin_name;?></span>
      </a>
    </div>
    <hr class="horizontal light mt-0 mb-2">
    <div class="collapse navbar-collapse  w-auto " id="sidenav-collapse-main">
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link text-white" href="#" onclick="window.location.href='home.php'">
            <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
              <i class="fas fa-tachometer-alt"></i>
            </div>
            <span class="nav-link-text ms-1">Dashboard</span>
          </a>
        </li>
    
        <li class="nav-item">
          <a class="nav-link text-white active bg-gradient-info" href="#" onclick="window.location.href='users.php'">
            
            <span class="nav-link-text ms-1"><i class="fas fa-users"></i>&nbsp;&nbsp;Users</span>
          </a>
        </li>
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
            <li class="breadcrumb-item text-sm text-dark active" aria-current="page">Manager-users</li>
          </ol>
          <h6 class="font-weight-bolder mb-0">Manager-users</h6>
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
        <div class="col-xl-2 col-sm-6 mb-xl-0 mb-4">
          <button class="btn btn-info" onclick="window.location.href='users.php'"><i class="fa fa-user"></i>&nbsp;Add new User</button>
        </div>
        <div class="col-xl-8 col-sm-6 mb-xl-0 mb-4">
          
            <div class="card">
              <div class="card-header pb-0">
                <div class="row">
                  <div class="col-lg-12 col-7 text-center">
                    <h6>All users - list</h6>
                  </div>
                </div>
              </div>
              <div class="card-body px-0 pb-2">
                <div class="table-responsive">
                  <table class="table align-items-center mb-0">
                    <thead class="text-center">
                      <tr>
                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Image</th>
                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Name</th>
                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Phone</th>
                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Email</th>
                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Action</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                          $users_data=mysqli_query($con,"SELECT * from users order by u_id desc");
                          $count_users=mysqli_num_rows($users_data);

                          while ($user_row=mysqli_fetch_assoc($users_data)) {
                            $user_id=$user_row['u_id'];
                            $name_data=$user_row['name'];
                            $phone_data=$user_row['phone'];
                            $email_data=$user_row['email'];
                            $image_data=$user_row['image'];
                                  
                            echo '      
                              <tr>
                                <td class="text-center">
                                  <div class="text-center">
                                    <div class="justify-content-center">
                                      <img src="../../assets/img/users/'.$image_data.'" style="border:1px solid skyblue;" class="avatar avatar-sm me-3" alt="atlassian">
                                    </div>
                                  </div>
                                </td>
                                <td>
                                  '.$name_data.'
                                </td>
                                <td class="align-middle text-center text-sm">
                                  '.$phone_data.'
                                </td>
                                <td class="align-middle text-center">
                                  '.$email_data.'
                                </td>
                                <td class="align-middle text-center">
                                  ';?>
                                  <i class="far fa-edit text-info" id="eye_id" onclick="window.location.href='update_user.php?user_id=<?php echo $user_id;?>'" title="update <?php echo $name_data;?>'s data"></i>&nbsp;&nbsp;&nbsp;<i class="fa fa-trash text-danger" id="eye_id" onclick="deletefn('<?php echo $user_id;?>')" title="delete <?php echo $name_data;?>'s data"></i>
                                  <?php
                                '</td>

                              </tr>
                            ';

                        }

                        if ($count_users == 0) {
                            echo '<tr><td class="text-center" colspan="5">No user\'s data found !</td></tr>';
                        }
                        

                      ?>
                      
                    </tbody>
                  </table>
                </div>
              </div>
            </div>

        </div>
        <div class="col-xl-2 col-sm-6 mb-xl-0 mb-4"></div>
      </div>


    </div>
      
  </main>

  <script type="text/javascript">
      function deletefn(user_id) {
          var confiramtion=confirm("Are you sure you want to delete this user , you will lost all report added by this user ?");
          if (confiramtion) {
              window.location.href='delete_user.php?user_id='+user_id+'';  
          }

          return confiramtion;
          
      }
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