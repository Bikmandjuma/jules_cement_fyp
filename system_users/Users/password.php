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
      $user_image=$row_user_info['image'];
      $user_name=$row_user_info['name'];
    }

                      
    $all_fields_required=$current_password=$new_password=$confirm_new_password=$password_required=$current_password_incorrect=$password_mustbe_greaterthan_8=$new_password_do_not_match=$Password_changed_well=$user_new_pswd=null;

  if ($_SERVER["REQUEST_METHOD"] == "POST") {
      
      if (isset($_POST['Password_changed'])) {
            $current_password=test_input($_POST['password']);
            $new_password=test_input($_POST['new_password']);
            $confirm_new_password=test_input($_POST['repeat_new_password']);

            $sql="SELECT password from users where u_id='".$_SESSION['u_id']."'";
            $result=mysqli_query($con,$sql);
            while ($row=mysqli_fetch_assoc($result)) {
                $user_password=$row['password'];
            }

            if (empty($current_password) || empty($new_password) || empty($new_password)) {
                $all_fields_required='
                    <p style="background-color:red;color:white;padding:10px;border-radius:5px;text-align:center;">All fields are required !</p><br>';

            }else{
                if (md5($current_password) != $user_password) {
                    $current_password_incorrect='
                      <p style="background-color:red;color:white;padding:10px;border-radius:5px;text-align:center;">Incorrect current password !</p><br>';

                }elseif (strlen($new_password) < 8) {
                    $password_mustbe_greaterthan_8='
                        <p style="background-color:red;color:white;padding:10px;border-radius:5px;text-align:center;">New password must be at least 8 characters !</p><br>';

                }elseif (md5($new_password) != md5($confirm_new_password)) {
                    $new_password_do_not_match='
                         <p style="background-color:red;color:white;padding:10px;border-radius:5px;text-align:center;">New password do not match !</p><br>';

                }else{ 
                    $user_new_pswd=md5($new_password);
                    if ($new_password == $confirm_new_password) {
                        $sql_password="UPDATE users SET password='".$user_new_pswd."' where u_id='".$_SESSION['u_id']."'";
                        $result_password=mysqli_query($con,$sql_password);
                        if ($result_password == true) {
                            $Password_changed_well='
                               <p style="background-color:teal;color:white;padding:10px;border-radius:5px;text-align:center;">Password changed successfully !</p><br>';

                        }

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
          <a class="nav-link dropdown-toggle text-white" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            <span class="nav-link-text ms-1"><i class="fa fa-tools"></i>&nbsp;&nbsp;Manage stuff</span>
          </a>
          <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
            <li><a class="dropdown-item" href="#" onclick="window.location.href='raw_material.php'"><i class="fa fa-building"></i>&nbsp;&nbsp;Raw_material</a></li>
            <li><a class="dropdown-item" href="#" onclick="window.location.href='report.php'"><i class="fa fa-file-alt"></i>&nbsp;&nbsp;Report</a></li>
            <li><a class="dropdown-item" href="#" onclick="window.location.href='file_storage.php'"><i class="fa fa-image"></i>&nbsp;&nbsp;File_storage</a></li>
          </ul>
        </li>

        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle text-white active bg-gradient-dark" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            <span class="nav-link-text ms-1"><i class="fa fa-cogs"></i>&nbsp;&nbsp;Settings</span>
          </a>
          <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
            <li><a class="dropdown-item" href="#" onclick="window.location.href='profile.php'"><i class="fa fa-image"></i>&nbsp;&nbsp;Profile picture</a></li>
            <li><a class="dropdown-item text-info" href="#" onclick="window.location.href='password.php'"><i class="fa fa-key"></i>&nbsp;&nbsp;Password</a></li>
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
            <li class="breadcrumb-item text-sm text-dark active" aria-current="page">Password</li>
          </ol>
          <h6 class="font-weight-bolder mb-0">Password</h6>
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
        <div class="col-xl-4 col-sm-4 mb-xl-0 mb-4"></div>
        <div class="col-xl-4 col-sm-4 mb-xl-0 mb-4">

            <?php echo $Password_changed_well.$all_fields_required.$current_password_incorrect.$new_password_do_not_match.$password_mustbe_greaterthan_8;?>
            
            <div class="card z-index-0 fadeIn3 fadeInBottom">
              <div class="card-header p-0 position-relative mt-n4 mx-2 z-index-2">
                <div class="bg-gradient-info shadow-primary border-radius-lg py-3 pe-1">
                  <h4 class="text-white font-weight-bolder text-center mt-2 mb-0">Manage password</h4>
                </div>
              </div>

              <div class="card-body">

                <form role="form" class="text-start loginForm" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" method="POST">
                  
                      <div class="input-group input-group-outline">
                        <label class="form-label">Current password</label>
                        <input type="text" class="form-control" name="password">
                      </div>
                    
                      <div class="input-group input-group-outline mt-4">
                        <label class="form-label">new password</label>
                        <input type="text" class="form-control" name="new_password">
                      </div>
                    
                      <div class="input-group input-group-outline mt-4">
                        <label class="form-label">confirm new password</label>
                        <input type="text" class="form-control" name="repeat_new_password">
                      </div>
                 
                      <div class="text-center mx-5" style="margin-top:-4px;">
                        <button type="submit" class="btn bg-gradient-info w-100 my-4 mb-2" name="Password_changed"><i class="far fa-save"></i> Save</button>
                      </div>

                </form>

              </div>
            </div>

        </div>
        <div class="col-xl-4 col-sm-4 mb-xl-0 mb-4"></div>
      </div>

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
</body>

</html>