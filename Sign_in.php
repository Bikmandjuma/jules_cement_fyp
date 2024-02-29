<?php
    
    session_start();
    include_once('Connect/connection.php');
    include_once 'php_code/codes.php';

    $incorectcredential=$allfieldRequired=$user=$pass=$PostionOptionisEmpty=$message_account_is_blocked="";

    if ($_SERVER["REQUEST_METHOD"] == "POST"){
        $user=test_input($_POST['Username']);
        $pass=test_input($_POST['Password']);

        if (empty($user) || empty($pass)) {
            
            ?>
              <script>
                
                setTimeout(function(){
                    var required=document.getElementById('login_fields_required');
                    required.style.display="block";
                    required.style.display="none";
                },4000);

              </script>
            <?php

            $allfieldRequired='<p style="background-color:red;color:white;padding:10px;border-radius:5px;text-align:center;" id="login_fields_required">Both fields are required !</p>';

        }else{
            $query_user=mysqli_query($con,"SELECT u_id,name,phone,email,password,image FROM users where email='$user' and password='".md5($pass)."'");
              $row_user=mysqli_fetch_array($query_user);

            $query_admin=mysqli_query($con,"SELECT a_id,name,phone,email,password,image FROM admin where email='$user' and password='".md5($pass)."'");
              $row_admin=mysqli_fetch_array($query_admin);

              if ($row_user > 0) {
                  $_SESSION['u_id']=$row_user[0];
                  $_SESSION['name']=$row_user[1];
                  $_SESSION['phone']=$row_user[2];
                  $_SESSION['email']=$row_user[3];
                  $_SESSION['password']=$row_user[4];
                  $_SESSION['image']=$row_user[5];

                  $user_id=$row_user[0];

                  $Sql_Show_Blocked_user="SELECT * from block_user_account inner join users on block_user_account.user_fk_id=users.u_id where status='Yes' and block_user_account.user_fk_id=$user_id";

                  $Query_Show_Blocked_user=mysqli_query($con,$Sql_Show_Blocked_user);
                  $count_Show_Blocked_user=mysqli_num_rows($Query_Show_Blocked_user);

                  if ($count_Show_Blocked_user == 1) {
                      $message_account_is_blocked="<p style='color:red;'>Sorry <b><span class='text-info'>".$row_user[1]." ".$row_user[2]."</span></b> your account is blocked</p>";
                  }else{

                      $diplic_online_user_sql=mysqli_query($con,"SELECT * from online_users where user_fk_id='".$row_user[0]."'");
                      $diplic_online_user_nums=mysqli_num_rows($diplic_online_user_sql);
                      date_default_timezone_set("Afrika/Kigali");
                      $tm=date("Y-m-d H:i:s");
                      $status="ON";

                      if ($diplic_online_user_nums > 0) {
                        mysqli_query($con,"UPDATE online_users SET status='$status',period='$tm' where user_fk_id='".$user_id."' ");
                      }else{
                          mysqli_query($con,"INSERT INTO online_users VALUES ('','$status','$tm','$user_id')");
                      }
                      
                      header("location:http://".$_SERVER['HTTP_HOST'].dirname($_SERVER['PHP_SELF'])."/system_users/Users/home.php");

                  }

              }elseif ($row_admin > 0) {
                  $_SESSION['a_id']=$row_admin[0];
                  $_SESSION['name']=$row_admin[1];
                  $_SESSION['phone']=$row_admin[2];
                  $_SESSION['email']=$row_admin[3];
                  $_SESSION['password']=$row_admin[4];
                  $_SESSION['image']=$row_admin[5];
                  
                  header("location:http://".$_SERVER['HTTP_HOST'].dirname($_SERVER['PHP_SELF'])."/system_users/Admin/home.php");

              }else{
                  
                  ?>
                    <script>
                      setTimeout(function(){
                          var wrong_cred=document.getElementById('Wrong_credentials');
                          wrong_cred.style.display="block";
                          wrong_cred.style.display="none";
                      },4000);
                      
                    </script>
                  <?php

                  $incorectcredential='<p id="Wrong_credentials" style="background-color:red;color:white;padding:10px;border-radius:5px;text-align:center;">Wrong credentials, try again !</p>';
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

<body class="bg-gradient-dark">
  <div class="container position-sticky z-index-sticky top-0">
    <div class="row">
      <div class="col-12">
        <?php require 'nav.php';?>
      </div>
    </div>
  </div>
  <main class="main-content  mt-0">
    <div class="page-header align-items-start min-vh-100" style="background-image: url('assets/img/illustrations/pattern-tree.svg');">
      <span class="mask bg-gradient-dark opacity-6"></span>
      <div class="container my-auto">

        <div class="row">
          <div class="col-lg-4 col-md-8 col-12 mx-auto">
            <div class="card z-index-0 fadeIn3 fadeInBottom">
              <div class="card-header p-0 position-relative mt-n4 z-index-2">
                <div class="bg-gradient-info shadow-primary border-radius-lg py-3 pe-1">
                  <h4 class="text-white font-weight-bolder text-center mt-2 mb-0">Login form</h4>
                </div>
              </div>

              <div class="card-body">
                <?php echo $message_account_is_blocked.$allfieldRequired.$incorectcredential;?>

                <form role="form" class="text-start loginForm" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" method="POST">
                  <div class="input-group input-group-outline my-3">
                    <label class="form-label">Email/Username</label>
                    <input type="text" class="form-control" name="Username">
                  </div>
                  <div class="input-group input-group-outline mb-3">
                    <label class="form-label">Password</label>
                    <input type="password" class="form-control" name="Password">
                  </div>
                  
                  <div class="text-center mx-4">
                    <button type="submit" class="btn bg-gradient-dark w-100 my-4 mb-2" name="Datas" onclick="submitForm()">Login</button>
                  </div>
                  <p class="mt-4 text-sm text-center">
                    <a href="#" onclick="window.location.href='Forgot_password.php'" class="text-info text-gradient font-weight-bold">Forgot password</a>
                  </p>

                  <p class="mt-4 text-sm text-center">
                    Don't have an account&nbsp;<a href="#" onclick="window.location.href='Sign_up.php'" class="text-info text-gradient font-weight-bold">register</a>
                  </p>

                </form>

              </div>
            </div>
          </div>
        </div>
        
      </div>
      <?php
        require 'footer.php';
      ?>
    </div>
  </main>
  <!--start loading button before submit-->
  <script>
    async function submitForm(){
        var loginform=document.querySelector('.loginForm');
        var buttonForm=loginform.querySelector('button');

        // loginform.onsubmit = (e) => {
        //     e.preventDefault();
        // } 
    }
  </script>
  <!--end loading button before submit-->
  <!--   Core JS Files   -->
  <script src="assets/js/core/popper.min.js"></script>
  <script src="assets/js/core/bootstrap.min.js"></script>
  <script src="assets/js/plugins/perfect-scrollbar.min.js"></script>
  <script src="assets/js/plugins/smooth-scrollbar.min.js"></script>
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
  <script src="assets/js/material-dashboard.min.js?v=3.0.4"></script>
</body>

</html>