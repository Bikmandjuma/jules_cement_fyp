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

    $image_uploaded=$image_size=$image_type=$image_not_uploaded=$Error_to_uploaded=null;

    if ($_SERVER["REQUEST_METHOD"] == "POST"){

        if (isset($_POST['SubmitfileStorage'])) {
            $fi_name=test_input($_POST['name']);
            $filename=date('YmdHi').basename($_FILES["fileToUpload"]["name"]);
            $destination = '../../assets/img/fileStorage/' . $filename;
            $extension = pathinfo($filename, PATHINFO_EXTENSION);
            $file = $_FILES['fileToUpload']['tmp_name'];
            $size = $_FILES['fileToUpload']['size'];

            ?>
              <script type="text/javascript">
                setTimeout(function(){
                  var file_notif=document.getElementById('file_id');
                  file_notif.style.display="block";
                  file_notif.style.display="none";
                },3000);
              </script>
            <?php

              if (!in_array($extension, ['zip', 'rar', 'pdf', 'docx','xls'])) {
                  $image_type='<p style="background-color:red;color:white;padding:10px;border-radius:5px;text-align:center;" id="file_id">You file extension must be .zip ,.rar , .pdf or .docx</p><br>';

              } elseif ($size > 5000000) { 
                  $image_size='<p style="background-color:red;color:white;padding:10px;border-radius:5px;text-align:center;" id="file_id">Sorry, your file is too large ,add 50MB at least.</p><br>';
              
              } else {
                  if (move_uploaded_file($file, $destination)) {
                      $sql = "INSERT INTO file_storage (fs_id,file_name,file_path) VALUES ('','$fi_name','$filename')";
                      if (mysqli_query($con, $sql)) {
                        $image_uploaded='<p style="background-color:teal;color:white;padding:10px;border-radius:5px;text-align:center;" id="file_id">File added well !</p><br>';
                      }
                  } else {
                    $Error_to_uploaded='<p style="background-color:red;color:white;padding:10px;border-radius:5px;text-align:center;" id="file_id">Sorry, your file was not uploaded</p><br>';
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
              echo $image_uploaded.$image_size.$image_type.$Error_to_uploaded;
            ?>
            <div class="card z-index-0 fadeIn3 fadeInBottom">
              
              <div class="card-header p-0 position-relative mt-n4 z-index-2">
                <div class="bg-gradient-dark shadow-primary border-radius-lg py-3 pe-1">
                  <h4 class="text-white font-weight-bolder text-center mt-2 mb-0">Add file/document</h4>
                </div>
              </div>

              <div class="card-body">

                <form role="form" class="text-start" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" method="POST" enctype="multipart/form-data">

                          <div class="input-group input-group-outline">
                            <label class="form-label">Name</label>
                            <input type="text" class="form-control" name="name" required>
                          </div>
                        
                          <div class="input-group input-group-outline mt-4">
                            <!-- <label class="form-label">File storage</label> -->
                            <input type="file" class="form-control" name="fileToUpload" required>
                          </div>  
                        
                      <div class="text-center mx-5" style="margin-top:-4px;">
                          <button type="submit" class="btn bg-gradient-info w-100 my-4 mb-2" name="SubmitfileStorage"><i class="far fa-save"></i> Store file info</button>
                      </div>

                </form>
              </div>
            </div>

        </div>
        <div class="col-xl-4 col-sm-6 mb-xl-0 mb-4"></div>

        <!--displaying the data from file storage-->

        <div class="col-xl-2 col-sm-6 mb-xl-0 mb-4"></div>
        <div class="col-xl-8 col-sm-6 mb-xl-0 mb-4">
            
            <div class="card mt-3">
              <div class="card-header pb-0">
                <div class="row">
                  <div class="col-lg-12 col-7 text-center">
                    <h6>Files stored data</h6>
                  </div>
                </div>
              </div>
              <div class="card-body px-0 pb-2">
                <div class="table-responsive">
                  <table class="table align-items-center mb-0 text-center">
                    <thead class="text-center">
                      <tr>
                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">N<sup>o</sup></th>
                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">File_name</th>
                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Action</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                          $files_data=mysqli_query($con,"SELECT * from file_storage order by fs_id desc");

                          $file_data_count=mysqli_num_rows($files_data);
                          $count=1;
                          while ($file_row=mysqli_fetch_assoc($files_data)) {
                            $file_id=$file_row['fs_id'];
                            $file_name_data=$file_row['file_name'];
                            $file_path_data=$file_row['file_path'];
                                  
                            echo '      
                              <tr>
                                <td class="text-center">
                                  '.$count++.'
                                </td>
                                <td>
                                  '.$file_name_data.'
                                </td>
                                <td class="align-middle text-center">
                                  ';?>
                                  <a class="far fa-save text-info" href="<?php echo '../../assets/img/fileStorage/'.$file_path_data.''?>" download>&nbsp;Download</a>
                                  <?php
                                '</td>

                              </tr>
                            ';

                        }

                        if ($file_data_count == 0) {
                                echo '<tr><td colspan="5" class="text-center">No data found in table !</td></tr>';
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