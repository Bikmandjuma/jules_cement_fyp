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
    $image_uploaded=$image_size=$image_type=$image_not_uploaded=$Error_to_uploaded=$File_not_image=null;
    if (isset($_POST['SubmitProfilePicture'])) {
      
        $target_dir = "../../assets/img/users/";
        $file_name=date('YmdHi').basename($_FILES["fileToUpload"]["name"]);
        $target_file = $target_dir .$file_name;
        
        $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
        // Check if image file is a actual image or fake image

        $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);

        if ($uploadOk = 1) {
            
            if($check !== false) {
                  // Check file size
                  if ($_FILES["fileToUpload"]["size"] > 5000000) {
                      $image_size='<script type="text/javascript">toastr.error("Sorry, your file is too large ,add 5MB at least.")</script>';
                      $uploadOk = 0;
                  }

                  // Allow certain file formats
                  if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
                  && $imageFileType != "gif" ) {
                     $image_type='<script type="text/javascript">toastr.error("Sorry, only JPG, JPEG, PNG & GIF files are allowed.")</script>';
                      $uploadOk = 0;
                  }

                  if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
                      $u_sql="UPDATE users set image='$file_name' where u_id='$users_id' ";
                      $u_query=mysqli_query($con,$u_sql);
                      $image_uploaded='<script type="text/javascript">toastr.success("Image added well !")</script>';
                  } else {
                     $image_not_uploaded='<script type="text/javascript">toastr.error("Sorry, there was an error uploading your file !")</script>';
                  }
            }


          }elseif ($uploadOk = 0) {
              $Error_to_uploaded='<script type="text/javascript">toastr.error("Sorry, your file was not uploaded")</script>';
          }
          

      }

    $sql_user_info="SELECT * FROM users where u_id=".$users_id."";
    $query_user_info=mysqli_query($con,$sql_user_info);
    while ($row_user_info=mysqli_fetch_assoc($query_user_info)) {
      $user_image=$row_user_info['image'];
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
            <li><a class="dropdown-item text-info" href="#" onclick="window.location.href='profile.php'"><i class="fa fa-image"></i>&nbsp;&nbsp;Profile picture</a></li>
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
            <li class="breadcrumb-item text-sm text-dark active" aria-current="page">Profile</li>
          </ol>
          <h6 class="font-weight-bolder mb-0">Profile</h6>
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
        <div class="col-xl-4 col-sm-4 mb-xl-0 mb-4"></div>
        <div class="col-xl-4 col-sm-4 mb-xl-0 mb-4">

               <?php echo $image_uploaded.$image_size.$image_type.$image_not_uploaded.$Error_to_uploaded.$File_not_image;?>

              <div class="card-body">
                <?php
                  $user_img_sql="SELECT * FROM users where image='user.png' and u_id=".$_SESSION['u_id']."";
                  $user_img_query=mysqli_query($con,$user_img_sql);
                  $img_number=mysqli_num_rows($user_img_query);
                 
                ?>
                <div class="card card-primary card-outline text-center" style="width: 80%;box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);">
                          <div class="card-header text-center" style="box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);"><h4 style="font-family:initial;">Profile picture</h4></div>
                          <img src="..\..\assets\img\users\<?php echo $user_image;?>">
                          <div class="containers">
                            <br>
                            <h4><b><?php echo $_SESSION['name']; ?></b></h4> 
                            <?php
                              if ($img_number == 1) {
                                ?>
                                  <button class="btn btn-info" data-bs-toggle="modal" data-bs-target="#ImageModal"><i class="fa fa-image"></i>&nbsp;Add</button>
                                <?php
                              }else{
                                ?>
                                  <button class="btn btn-info" data-bs-toggle="modal" data-bs-target="#ImageModal"><i class="fa fa-edit"></i>&nbsp;Edit</button>
                                <?php
                              }
                            ?>
                            
                          </div>
                        </div>

                        <!--start modal of image-->
                          <div class="modal fade text-center" style="margin-top:150px;" id="ImageModal" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                              <div class="modal-content">
                                <div class="modal-header text-center">
                                  <h5 class="modal-title" id="ImageModalLabel">Choose image</h5>
                                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                  <form enctype="multipart/form-data" method="POST">
                                      <img id="blah" style="width:130px;height:150px;"  src="..\..\assets\img\users\<?php echo $user_image;?>"/><br>            
                                      <br>
                                      <input name="fileToUpload" type="file" accept="image/*" id="imgInp" class="form-control" required><br>
                                      <button class="btn btn-info" type="submit" name="SubmitProfilePicture"><i class="fa fa-save"></i> Save change</button>
                                   
                                  
                                </form>
                                </div>
                                <div class="modal-footer">
                                  <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancel</button>
                                </div>
                              </div>
                            </div>
                          </div>
                        <!--end of image modal-->

              </div>
            </div>

        </div>
        <div class="col-xl-4 col-sm-4 mb-xl-0 mb-4"></div>
      </div>


    </div>
      
  </main>
  
  <!--   Core JS Files   -->
   <script type="text/javascript">
      imgInp.onchange = evt => {
        const [file] = imgInp.files
        if (file) {
          blah.src = URL.createObjectURL(file)
        }
      }
  </script>
  
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