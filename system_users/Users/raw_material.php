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
    }

    $allfieldRequired=$account_created=$Name_exist="";

    if ($_SERVER["REQUEST_METHOD"] == "POST"){

      if (isset($_POST['SubmitBtn'])) {
          
            $name=test_input($_POST['name']);
            $description=test_input($_POST['description']);
            $quantity=test_input($_POST['qty']);
            $unit=test_input($_POST['unit']);

            if (empty($name) || empty($description) || empty($quantity) || empty($unit)) {
                
                ?>
                  <script>
                    
                    setTimeout(function(){
                        var required=document.getElementById('login_fields_required');
                        required.style.display="block";
                        required.style.display="none";
                    },4000);

                  </script>
                <?php

                $allfieldRequired='<p style="background-color:red;color:white;padding:10px;border-radius:5px;text-align:center;" id="login_fields_required"><b>All fields are required !</b></p><br>';

            }else{

                  //avoid duplication of name
                  $sql_name=mysqli_query($con,"SELECT name from raw_material where name='".$name."'");

                  $count_name=mysqli_num_rows($sql_name);

                  if ($count_name == 0) {
                    
                  
                      $query=mysqli_query($con,"INSERT INTO raw_material values ('','$name','$description','$quantity','','$unit','','','$users_id')");

                      if ($query == true) {
                          
                          ?>
                            <script>
                              
                              setTimeout(function(){
                                  var required=document.getElementById('account_created');
                                  required.style.display="block";
                                  required.style.display="none";
                              },4000);

                            </script>
                          <?php

                         $account_created='<p style="background-color:teal;color:white;padding:10px;border-radius:5px;text-align:center;" id="account_created"><b>Data inserted successfully !</b></p><br>';

                      }

                  }else{
                      ?>
                        <script>
                              
                              setTimeout(function(){
                                  var required=document.getElementById('name_exist');
                                  required.style.display="block";
                                  required.style.display="none";
                              },4000);

                            </script>
                          <?php

                         $Name_exist='<p style="background-color:red;color:white;padding:10px;border-radius:5px;text-align:center;" id="name_exist">This name <strong>('.$name.')</strong> is already exist , just update it !</p><br>';

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
          <a class="nav-link dropdown-toggle text-white active bg-gradient-dark" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            <span class="nav-link-text ms-1"><i class="fa fa-tools"></i>&nbsp;&nbsp;Manage stuff</span>
          </a>
          <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
            <li><a class="dropdown-item text-info" href="#" onclick="window.location.href='raw_material.php'"><i class="fa fa-building"></i>&nbsp;&nbsp;Raw_material</a></li>
            <li><a class="dropdown-item" href="#" onclick="window.location.href='report.php'"><i class="fa fa-file-alt"></i>&nbsp;&nbsp;Report</a></li>
            <li><a class="dropdown-item" href="#" onclick="window.location.href='file_storage.php'"><i class="fa fa-image"></i>&nbsp;&nbsp;File_storage</a></li>
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
            <li class="breadcrumb-item text-sm text-dark active" aria-current="page">Raw_material</li>
          </ol>
          <h6 class="font-weight-bolder mb-0">Raw_material</h6>
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

          <?php echo $allfieldRequired.$account_created.$Name_exist;?>
            
            <div class="card z-index-0 fadeIn3 fadeInBottom">
              
              <div class="card-header p-0 position-relative mt-n4 z-index-2">
                <div class="bg-gradient-success shadow-primary border-radius-lg py-3 pe-1">
                  <h4 class="text-white font-weight-bolder text-center mt-2 mb-0">Add raw material</h4>
                </div>
              </div>

              <div class="card-body">

                <form role="form" class="text-start" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" method="POST">

                    <div class="row">
                      <div class="col-xl-6 col-sm-6 mb-xl-0 mb-4">
                        <div class="input-group input-group-outline">
                          <select name="name" class="form-control" required>
                            <option>Name</option>
                            <option value="Limestone">Limestone</option>
                            <option value="Clay or Shale">Clay or Shale</option>
                            <option value="Sand or Silica">Sand or Silica</option>
                            <option value="Iron Ore">Iron Ore</option>
                            <option value="Fly Ash">Fly Ash</option>
                            <option value="Gypsum">Gypsum</option>
                          </select>

                        </div>
                      </div>
                      <div class="col-xl-6 col-sm-6 mb-xl-0 mb-4">
                        <div class="input-group input-group-outline">
                          <label class="form-label">Quantity</label>
                          <input type="text" class="form-control" name="qty">
                        </div>  
                      </div>
                    </div>

                    <div class="row">
                      <div class="col-xl-6 col-sm-6 mb-xl-0 mb-4">
                        <div class="input-group input-group-outline mt-4">
                          <textarea type="text" class="form-control" name="description" placeholder="description"></textarea>
                        </div>
                      </div>
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
                    </div>
                  
                    <div class="text-center mx-5" style="margin-top:-4px;">
                        <button type="submit" class="btn bg-gradient-info w-100 my-4 mb-2" name="SubmitBtn"><i class="far fa-save"></i> Save</button>
                    </div>

                </form>

              </div>
            </div>

        </div>
        <div class="col-xl-4 col-sm-4 mb-xl-0 mb-4"></div>
      </div>

      <br>

      <div class="row">
        <!-- <div class="col-xl-2 col-sm-6 mb-xl-0 mb-4"></div> -->
        <div class="col-xl-12 col-sm-12 mb-xl-0 mb-4">
          
            <div class="card">
              <div class="card-header pb-0">
                <div class="row">
                  <div class="col-lg-12 col-7 text-center">
                    <h6>Raw materials data</h6>
                  </div>
                </div>
              </div>
              <div class="card-body px-0 pb-2">
                <div class="table-responsive">
                  <table class="table align-items-center mb-0 text-center">
                    <thead class="text-center">
                      <tr>
                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Name</th>
                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Quantity</th>
                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Unit</th>
                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Description</th>
                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Action</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                          $users_data=mysqli_query($con,"SELECT * from raw_material order by rm_id desc");

                          $users_data_count=mysqli_num_rows($users_data);

                          while ($user_row=mysqli_fetch_assoc($users_data)) {
                            $rm_id=$user_row['rm_id'];
                            $name_data=$user_row['name'];
                            $descr_data=$user_row['description'];
                            $qty_data=$user_row['quantity_stored'];
                            $unit_data=$user_row['unit'];
                                  
                            echo '      
                              <tr>
                                <td class="text-center">
                                  '.$name_data.'
                                </td>
                                <td>
                                  '.$qty_data.'
                                </td>
                                <td class="align-middle text-center text-sm">
                                  '.$unit_data.'
                                </td>
                                <td class="align-middle text-center">
                                  '.$descr_data.'
                                </td>
                                <td class="align-middle text-center">
                                  ';?>
                                  <i class="far fa-edit text-info" id="eye_id" onclick="window.location.href='update_raw_material.php?raw_material_id=<?php echo $rm_id;?>'"></i>&nbsp;&nbsp;&nbsp;
                                  <i class="fa fa-trash text-danger" id="eye_id" onclick="deletefn('<?php echo $rm_id;?>')"></i>
                                  <?php
                                '</td>

                              </tr>
                            ';

                        }

                        if ($users_data_count == 0) {
                                echo '<tr><td colspan="5" class="text-center">No data found in table !</td></tr>';
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


    </div>
      
  </main>

  <script type="text/javascript">

    function deletefn(raw_material_id){
        var confirmation=confirm("are you sure you want to delete this raw material's data ?");
        if (confirmation) {
            window.location.href='delete_raw_material.php?raw_material_id='+raw_material_id+'';
        }

        return confirmation;
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