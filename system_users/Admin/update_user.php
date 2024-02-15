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

    $users_id=$_REQUEST['user_id'];

    $users_data=mysqli_query($con,"SELECT * from users where u_id=$users_id");
    while ($user_row=mysqli_fetch_assoc($users_data)) {
        $name_data=$user_row['name'];
        $phone_data=$user_row['phone'];
        $email_data=$user_row['email'];
        $image_data=$user_row['image'];
    }

    $user_info_changed=null;

    if ($_SERVER["REQUEST_METHOD"] == "POST"){

      if (isset($_POST['update_user_info'])) {
        
          $name=test_input($_POST['name']);
          $phone=test_input($_POST['phone']);
          $email=test_input($_POST['email']);

          $sql_password="UPDATE users SET name='".$name."',phone='".$phone."',email='".$email."' where u_id='".$users_id."'";
          $result_password=mysqli_query($con,$sql_password);
          if ($result_password == true) {
              $user_info_changed='<p style="background-color:teal;color:white;padding:10px;border-radius:5px;text-align:center;" id="user_info">user info changed successfully !</p><br>';
               ?>
                    <script>
                      
                      setTimeout(function(){
                          var required=document.getElementById('user_info');
                          required.style.display="block";
                          required.style.display="none";

                          window.location.href='users.php'

                      },4000);

                    </script>
                <?php

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
        <img src="../../assets/img/users/<?php echo $_SESSION['image'];?>" title="user image" style="width:40px;height:40px;border-radius:50%;" class="navbar-brand-img h-100" alt="main_logo">
        <span class="ms-1 font-weight-bold text-white"><?php echo $_SESSION['name'];?></span>
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
    
        <li class="nav-item">
          <a class="nav-link text-white active bg-gradient-info" href="#" onclick="window.location.href='users.php'">
            <!-- <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
              <i class="material-icons">users</i>
            </div> -->
            <span class="nav-link-text ms-1"><i class="fas fa-users"></i>&nbsp;&nbsp;Users</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-white " href="#" onclick="window.location.href='report.php'">
            <!-- <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
              <i class="material-icons opacity-10">report</i>
            </div> -->
            <span class="nav-link-text ms-1"> <i class="far fa-file-alt"></i>&nbsp;&nbsp;Reports</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-white " href="#" onclick="window.location.href='password.php'">
            <!-- <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
              <i class="material-icons opacity-10">cog</i>
            </div> -->
            <span class="nav-link-text ms-1"><i class="fa fa-key"></i>&nbsp;&nbsp;Password</span>
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
        <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4"></div>
        <div class="col-xl-6 col-sm-6 mb-xl-0 mb-4">
          <?php echo $user_info_changed;?>
          <div class="card z-index-0 fadeIn3 fadeInBottom">
              <div class="card-header p-0 position-relative mt-n4 mx-2 z-index-2">
                <div class="bg-gradient-info shadow-primary border-radius-lg py-3 pe-1">
                  <h4 class="text-white font-weight-bolder text-center mt-2 mb-0">Update user info</h4>
                </div>
              </div>

              <div class="card-body">

                <form role="form" class="text-start loginForm" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" method="POST">
                  <input type="hidden" name="user_id" value="<?php echo htmlspecialchars($users_id); ?>">
                  <div class="row">
                    <div class="col-xl-6 col-sm-6 mb-xl-0">
                      <div class="input-group input-group-outline">
                        <input type="text" class="form-control" name="name" value="<?php echo $name_data;?>">
                      </div>
                    </div>
                    <div class="col-xl-6 col-sm-6 mb-xl-0">
                      <div class="input-group input-group-outline">
                        <input type="text" class="form-control" name="phone" value="<?php echo $phone_data;?>">
                      </div>
                    </div>
                  </div>

                  <div class="row">
                    <div class="col-xl-6 col-sm-6 mb-xl-0 mt-4">
                      <div class="input-group input-group-outline">
                        <input type="text" class="form-control" name="email" value="<?php echo $email_data;?>">
                      </div>
                    </div>
                    <div class="col-xl-6 col-sm-6 mb-xl-0 mt-1">
                      <div class="text-center mx-4" style="margin-top:-4px;">
                        <button type="submit" class="btn bg-gradient-info w-100 my-4 mb-2" name="update_user_info" onclick="submitForm()">Save changes</button>
                      </div>
                    </div>
                  </div>

                </form>

              </div>
            </div>
        </div>
        <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4"></div>

      </div>


    </div>
      
  </main>
  
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