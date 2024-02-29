<?php
    
    session_start();
    include_once('Connect/connection.php');
    include_once 'php_code/codes.php';

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
                    required.style.display="block";
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
                          required.style.display="block";
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
                          required.style.display="block";
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
                          required.style.display="block";
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
                          required.style.display="block";
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
                          required.style.display="block";
                          required.style.display="none";

                          window.location.href='Sign_in.php';
                      },4000);

                    </script>
                  <?php

                 $account_created="<p style='color:teal;text-align:center;' id='account_created'>Account created well</p>";
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

        <div class="row mt-7">
          <div class="col-lg-6 col-md-8 col-12 mx-auto">
            <div class="card z-index-0 fadeIn3 fadeInBottom">
              <div class="card-header p-0 position-relative mt-n4  z-index-2">
                <div class="bg-gradient-info shadow-primary border-radius-lg py-3 pe-1">
                  <h4 class="text-white font-weight-bolder text-center mt-2 mb-0">Register form</h4>
                </div>
              </div>

              <div class="card-body">
                <?php echo $allfieldRequired.$email_diplicated.$phone_diplicated.$account_created.$pswd_do_not_match.$pswd_length;?>

                <form role="form" class="text-start loginForm" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" method="POST">

                  <div class="row">
                    <div class="col-lg-6 col-md-6 col-6 mx-auto">
                      <div class="input-group input-group-outline my-3">
                        <label class="form-label">Name</label>
                        <input type="text" class="form-control" name="name">
                      </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-6 mx-auto">
                      <div class="input-group input-group-outline mb-3 mt-3">
                        <label class="form-label">Phone</label>
                        <input type="text" class="form-control" name="phone">
                      </div>
                    </div>
                  </div>

                  <div class="row">
                    <div class="col-lg-6 col-md-6 col-6 mx-auto">
                      <div class="input-group input-group-outline my-3">
                        <label class="form-label">Email</label>
                        <input type="text" class="form-control" name="email">
                      </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-6 mx-auto">
                      <div class="input-group input-group-outline mb-3 mt-3">
                        <label class="form-label">Password</label>
                        <input type="password" class="form-control" name="password">
                      </div>
                    </div>
                  </div>

                  <div class="row">
                    <div class="col-lg-6 col-md-6 col-6 mx-auto">
                        <div class="input-group input-group-outline my-3">
                          <label class="form-label">repeat-password</label>
                          <input type="password" class="form-control" name="repeat-password">
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-6 mx-auto">
                      <div class="text-center mx-4" style="margin-top:-12px;">
                        <button type="submit" class="btn bg-gradient-dark w-100 my-4 mb-2 shadow-danger" name="Datas" onclick="submitForm()" >Register</button>
                      </div>
                    </div>
                  </div>

                  
                  

                  <p class="mt-4 text-sm text-center">
                    Already have an account&nbsp;<a href="#" onclick="window.location.href='Sign_in.php'" class="text-info text-gradient font-weight-bold">Sign in</a>
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