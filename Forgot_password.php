<?php

    session_start();
    use PHPMailer\PHPMailer\PHPMailer;
    include_once('Connect/connection.php');
    require_once 'PHPMailer\PHPMailer.php';
    require_once 'PHPMailer\SMTP.php';
    require_once 'PHPMailer\Exception.php';
    
    $Email_Sent=$Email_Not_Found=$MailerError=$email_required=null;

    if ($_SERVER["REQUEST_METHOD"] == "POST"){

        if(isset($_POST['submit_forgot_pswd'])){
              $email_input= test_input($_POST['email']);
              $sql="SELECT email,phone FROM users UNION SELECT email,phone FROM admin";
              $res=mysqli_query($con,$sql);
              while ($rows=mysqli_fetch_array($res)) {
                  if (empty($email_input)) {
                      
                        ?>
                        <script>
                          
                          setTimeout(function(){
                              var required=document.getElementById('email_field_required');
                              required.style.display="block";
                              required.style.display="none";
                          },4000);

                        </script>
                      <?php

                      $email_required='<p style="background-color:red;color:white;padding:10px;border-radius:5px;text-align:center;" id="email_field_required">Email field is required ! </p><br>';
                      break;

                  }elseif($rows[0] === $email_input) {
                        $email=$rows[0];
            
                        $r = mysqli_fetch_assoc($res);

                        //Encrypting email
                        $email_string=$email;
                        
                        try {

                          //select user
                          $sql_user=mysqli_query($con,"SELECT * from users where email='$email'");
                          $sql_user_num=mysqli_num_rows($sql_user);

                          if ($sql_user_num == 1) {
                            $user_rand_pswd=rand(0,1000000);
                            $new_pswd=md5($user_rand_pswd);
                            $update_user=mysqli_query($con,"UPDATE users SET password='$new_pswd' where email='$email'");
                          }else{
                            $new_pswd=md5($user_rand_pswd);
                            $update_user=mysqli_query($con,"UPDATE admin SET password='$new_pswd' where email='$email'");
                          }

                            //Server settings
                            // $mail->SMTPDebug = SMTP::DEBUG_SERVER; 
                            $mail=new PHPMailer();                     //Enable verbose debug output
                            $mail->isSMTP();                                            //Send using SMTP
                            $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
                            $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
                            $mail->Username   = 'bikmangeek@gmail.com';                     //SMTP username
                            $mail->Password   = 'hpvrdqffxfmpsgku';                         //SMTP password
                            $mail->SMTPSecure = 'tls' ; //tls;            //Enable implicit TLS encryption
                            $mail->Port       = 587; //587;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

                            //Content
                            $mail->isHTML(true); 
                            $mail->setFrom($email,'RAW MATERIALS MINING ANALYTIC SYSTEM');
                            $mail->addAddress($email);               //Set email format to HTML
                            $mail->Subject = "Password reset";
                            // $mail->Body    = "<span id='link_message'>Please use this link to reset password " .'<a href="http://localhost/project/TMIS/Training-managent-system-TMIS/ResetPassword.php?email='.$encrypted_email.'">Reset Password here : '.$encrypted_email.'</a></span>';
                            $mail->Body ='
                                        <html> 
                                          <head> 
                                              <title>Welcome to CIMERWA</title> 
                                          </head> 
                                          <body> 
                                              <h1>RAW MATERIALS MINING ANALYTIC SYSTEM</h1> 
                                              <p style="box-radius:5px;border:1px solid red;box-shadow:0px 4px 8px 0px rgba(0,0,0,0.2);text-align: center;background-color: white;font-family: sans-serif;font-weight: bold;padding: 5px;">Please use this <span style="color:blue;">'.$user_rand_pswd.'</span> as password to login into <b>RAW MATERIALS MINING </b> ANALYTIC SYSTEM</p>
                                          </body> 
                                          </html>';
                      

                            $mail->send();

                            ?>
                              <script>
                                
                                setTimeout(function(){
                                    var required=document.getElementById('Email_Sent');
                                    required.style.display="block";
                                    required.style.display="none";
                                },5000);

                              </script>
                            <?php

                            $Email_Sent='<p style="background-color:green;color:white;padding:10px;border-radius:5px;text-align:center;" id="Email_Sent">Check your email ,we mailed you a reset link !</p><br>';


                        } catch (Exception $e) {

                            ?>
                              <script>
                                
                                setTimeout(function(){
                                    var required=document.getElementById('MailerError');
                                    required.style.display="block";
                                    required.style.display="none";
                                },5000);

                              </script>
                            <?php

                            $MailerError='<p style="background-color:red;color:white;padding:10px;border-radius:5px;" id="MailerError">Message could not be sent. Mailer Error: {$mail->ErrorInfo} !</p>';            
                        }


                  }else{
                      ?>
                        <script>
                          
                          setTimeout(function(){
                              var required=document.getElementById('email_not_found');
                              required.style.display="block";
                              required.style.display="none";
                          },5000);

                        </script>
                      <?php

                      $Email_Not_Found='<p style="background-color:red;color:white;padding:10px;border-radius:5px;text-align:center;" id="email_not_found">Email not found in our database !</p><br>';  
                  }
                  //end of else
              
              }
              //end of while loop
        }
        //end of if of submit

    }
    //end of if request

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
        <!-- Navbar -->
        <?php require 'nav.php';?>
        <!-- End Navbar -->
      </div>
    </div>
  </div>
  <main class="main-content  mt-0">
    <div class="page-header align-items-start min-vh-100" style="background-image: url('assets/img/illustrations/pattern-tree.svg');">
      <span class="mask bg-gradient-dark opacity-6"></span>
      <div class="container my-auto">

        <div class="row">
          <div class="col-lg-4 col-md-8 col-12 mx-auto">
            <?php
                
                echo $email_required.$MailerError;
                
                if ($Email_Sent == true) {
                    echo $Email_Sent;
                }else{
                    echo $Email_Not_Found;
                }

            ?>
            <div class="card z-index-0 fadeIn3 fadeInBottom">
              <div class="card-header p-0 position-relative mt-n4 z-index-2">
                <div class="bg-gradient-info shadow-primary border-radius-lg py-3 pe-1">
                  <h4 class="text-white font-weight-bolder text-center mt-2 mb-0">Forgot password</h4>
                </div>
              </div>
              <div class="card-body">
                <form role="form" class="text-start" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" method="POST">
                  <div class="input-group input-group-outline my-3">
                    <label class="form-label">Email</label>
                    <input type="email" class="form-control" name="email">
                  </div>
                  
                  <div class="text-center mx-4">
                    <button type="submit" name="submit_forgot_pswd" class="btn bg-gradient-dark w-100 my-4 mb-2">Send reset link</button>
                  </div>

                  <p class="mt-4 text-sm text-center">
                    <a href="#" onclick="window.location.href='Sign_in.php'" class="text-info text-gradient font-weight-bold">Back to login</a>
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
  <script src="../assets/js/material-dashboard.min.js?v=3.0.4"></script>
</body>

</html>