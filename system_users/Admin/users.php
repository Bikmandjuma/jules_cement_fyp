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

    $allfieldRequired=$email_diplicated=$phone_diplicated=$account_created=$pswd_do_not_match=$pswd_length="";

    if ($_SERVER["REQUEST_METHOD"] == "POST"){
        $name=test_input($_POST['name']);
        $phone=test_input($_POST['phone']);
        $email=test_input($_POST['email']);
        $password=test_input(md5($_POST['password']));
        $repeat_pswd=test_input(md5($_POST['repeat-password']));
  
        if (empty($name) || empty($phone) || empty($email) || empty($password) || empty($repeat_pswd)) {
            
            ?>
              <script>
                
                setTimeout(function(){
                    var required=document.getElementById('login_fields_required');
                    required.style.display="none";
                },4000);

              </script>
            <?php

            $allfieldRequired='<p style="background-color:red;color:white;padding:10px;border-radius:5px;text-align:center;" id="login_fields_required">All fields are required !</p>';

        }else{
            $diplicated_phone_query=mysqli_query($con,"SELECT phone FROM users where phone='$phone'");
            $diplicated_phone_nums=mysqli_num_rows($diplicated_phone_query);

            $diplicated_email_query=mysqli_query($con,"SELECT email FROM users where email='$email'");
            $diplicated_email_nums=mysqli_num_rows($diplicated_email_query);
            

            if ($diplicated_phone_nums == 1) {
                
                ?>
                    <script>
                      
                      setTimeout(function(){
                          var required=document.getElementById('phone_diplicated');
                          required.style.display="none";
                      },5000);

                    </script>
                <?php

                $phone_diplicated="<p style='color:red;text-align:center;' id='phone_diplicated'>This number <b><span class='text-info'>".$phone."</span></b> is already exist !</p>";
            }elseif ($diplicated_email_nums == 1) {
              ?>
                    <script>
                      
                      setTimeout(function(){
                          var required=document.getElementById('email_diplicated');
                          required.style.display="none";
                      },5000);

                    </script>
                <?php

              $email_diplicated="<p style='color:red;text-align:center;' id='email_diplicated'>This email <b><span class='text-info'>".$email."</span></b> is already exist !</p>";
            }elseif(strlen($password) < 8 ){
                 ?>
                    <script>
                      
                      setTimeout(function(){
                          var required=document.getElementById('password_length');
                          required.style.display="none";
                      },5000);

                    </script>
                <?php

              $pswd_length="<p style='color:red;text-align:center;' id='password_length'>Password must be 8 characters , atleast !</p>";
            }elseif($password != $repeat_pswd ){
                 ?>
                    <script>
                      
                      setTimeout(function(){
                          var required=document.getElementById('password_do_not_match');
                          required.style.display="none";
                      },5000);

                    </script>
                <?php

              $pswd_do_not_match="<p style='color:red;text-align:center;' id='password_do_not_match'>Password do not match !</p>";
            }else{
               $query=mysqli_query($con,"INSERT INTO users values ('','$name','$phone','$email','$password','user.png')");

               if ($query == true) {
                  ?>
                    <script>
                      
                      setTimeout(function(){
                          var required=document.getElementById('account_created');
                          required.style.display="none";

                          window.location.href='viewUsers.php';
                      },4000);

                    </script>
                  <?php

                 $account_created="<p style='color:blue;text-align:center;' id='account_created'>New user created !</p>";
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
        <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
          <button class="btn btn-info" onclick="window.location.href='viewUsers.php'"><i class="fa fa-users"></i>&nbsp;View Users</button>
        </div>
        <div class="col-xl-6 col-sm-6 mb-xl-0 mb-4">
          <div class="card z-index-0 fadeIn3 fadeInBottom">
              <div class="card-header p-0 position-relative mt-n4 z-index-2">
                <div class="bg-gradient-info shadow-primary border-radius-lg py-3 pe-1">
                  <h4 class="text-white font-weight-bolder text-center mt-2 mb-0">Register new user</h4>
                </div>
              </div>

              <div class="card-body">
                <?php echo $allfieldRequired.$email_diplicated.$phone_diplicated.$account_created.$pswd_do_not_match.$pswd_length;?>

                <form role="form" class="text-start loginForm" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" method="POST">
                  <div class="row">
                    <div class="col-xl-6 col-sm-6 mb-xl-0">
                      <div class="input-group input-group-outline">
                        <label class="form-label">Name</label>
                        <input type="text" class="form-control" name="name">
                      </div>
                    </div>
                    <div class="col-xl-6 col-sm-6 mb-xl-0">
                      <div class="input-group input-group-outline">
                        <label class="form-label">Phone</label>
                        <input type="text" class="form-control" name="phone">
                      </div>
                    </div>
                  </div>

                  <div class="row">
                    <div class="col-xl-6 col-sm-6 mb-xl-0 mt-4">
                      <div class="input-group input-group-outline">
                        <label class="form-label">Email</label>
                        <input type="text" class="form-control" name="email">
                      </div>
                    </div>
                    <div class="col-xl-6 col-sm-6 mb-xl-0 mt-4">
                      <div class="input-group input-group-outline">
                        <label class="form-label">Password</label>
                        <input type="password" class="form-control" name="password">
                      </div>
                    </div>
                  </div>

                  <div class="row">
                    <div class="col-xl-6 col-sm-6 mb-xl-0 mt-2">
                      <div class="input-group input-group-outline my-3">
                        <label class="form-label">repeat-password</label>
                        <input type="password" class="form-control" name="repeat-password">
                      </div>
                    </div>
                    <div class="col-xl-6 col-sm-6 mb-xl-0 mt-1">
                      <div class="text-center mx-4" style="margin-top:-4px;">
                        <button type="submit" class="btn bg-gradient-info w-100 my-4 mb-2" name="Datas" onclick="submitForm()" >Sign up</button>
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