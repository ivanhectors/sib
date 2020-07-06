<?php
include("include/config.php");
session_start();
error_reporting(0);

if(isset($_POST["login"]))  
 {  
  $username = mysqli_real_escape_string($con, $_POST["username"]);  
  $password = mysqli_real_escape_string($con, $_POST["password"]);  
  $query = "SELECT * FROM user_admin WHERE username = '$username' and status = '1'"; 
  $query2 = "SELECT * FROM user_mhs WHERE username = '$username'";
  $query3 = "SELECT * FROM user_acc WHERE username = '$username'";
  $admin = mysqli_query($con, $query);  
  $mhs = mysqli_query($con, $query2);
  $acc = mysqli_query($con, $query3);
  $_SESSION['errmsg']="Username / Password yang anda masukkan salah";
  $num=mysqli_fetch_array($con, $query);
  $num1=mysqli_fetch_array($con, $query2);
  $num2=mysqli_fetch_array($con, $query3);
  if(mysqli_num_rows($admin) > 0)  
           {  
                while($row = mysqli_fetch_array($admin))  
                {  
                     if(password_verify($password, $row["password"]))  
                     {  
                          //return true;  
                          $extra="adm/";//
                          $_SESSION["admlogin"] = $username; 
                          $_SESSION['id']=$num['id']; 
                          $host=$_SERVER['HTTP_HOST']; 
                          $uip=$_SERVER['REMOTE_ADDR'];
                          $status=1;
                          $log=mysqli_query($con,"insert into userlog(iduserlog,username,userip,status) values('".$_SESSION['id']."','".$_SESSION['admlogin']."','$uip','$status')");
                          $uri=rtrim(dirname($_SERVER['PHP_SELF']),'/\\');
                          header("location:http://$host$uri/$extra");
                          exit();
                     } 
                     else  
                     {   

                          $extra="login";
                          $host  = $_SERVER['HTTP_HOST'];
                          $uri  = rtrim(dirname($_SERVER['PHP_SELF']),'/\\');
                          $_SESSION['admlogin']= $username;	
                          $uip=$_SERVER['REMOTE_ADDR'];
                          $status=0;
                          mysqli_query($con,"insert into userlog(username,userip,status) values('".$_SESSION['admlogin']."','$uip','$status')");
                          $_SESSION['errmsg']="Username / Password salah";
                          header("location:http://$host$uri/$extra?failed=1");
                          echo '';
                          exit(); 
                          
                     } 
                }
            }

            elseif (mysqli_num_rows($mhs) > 0){
              while($row = mysqli_fetch_array($mhs))  
              {  
                   if(password_verify($password, $row["password"]))  
                   {  
                        //return true;  
                        $_SESSION["username"] = $username;  
                        header("location:mhs/");  
                   }
                   else  
                   {  
                        echo '';  
                   }  
              }
            }

            elseif (mysqli_num_rows($acc) > 0){
              while($row = mysqli_fetch_array($acc))  
              {  
                   if(password_verify($password, $row["password"]))  
                   {  
                        //return true;  
                        $_SESSION["username"] = $username;  
                        header("location:acc/");  
                   }
                   else  
                   {  
                        echo '<script>alert("Wrong User Details")</script>';  
                   }  
              }
            }
            else{

              echo '<div data-notify="container" class="alert alert-dismissible alert-danger alert-notify animated fadeInDown" role="alert" data-notify-position="top-center" style="display: inline-block; margin: 0px auto; position: fixed; transition: all 0.5s ease-in-out 0s; z-index: 1080; top: 15px; left: 0px; right: 0px; animation-iteration-count: 1;">
                  <span class="alert-icon ni ni-bell-55" data-notify="icon"></span> 
                  <div class="alert-text" div=""> <span class="alert-title" data-notify="title"> Gagal!</span> 
                  <span data-notify="message">Terjadi kesalahan dengan akun anda. Pastikan akun anda aktif untuk dapat login.</span>
                </div><button type="button" id="close_direct" class="close" data-dismiss="alert" aria-label="Close" style="position: absolute; right: 10px; top: 5px; z-index: 1082;">
                <span aria-hidden="true">×</span></button></div>';
            }
            
      } 

      
    
 ?>
 <!DOCTYPE html>
<html>

<head>
<meta charset="utf-8">
   <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
   <meta name="description" content="SIB UKDW LOGIN">
   <meta name="author" content="Ivan Hector Sinambela">
   <title>SIB - LOGIN</title>
  <!-- Favicon -->
  <link rel="icon" href="./assets/img/brand/favicon.png" type="image/png">
  <!-- Fonts -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700">
  <!-- Icons -->
  <link rel="stylesheet" href="./assets/vendor/nucleo/css/nucleo.css" type="text/css">
  <link rel="stylesheet" href="./assets/vendor/@fortawesome/fontawesome-free/css/all.min.css" type="text/css">
  <!-- Argon CSS -->
  <link rel="stylesheet" href="./assets/css/argon.css?v=1.1.0" type="text/css">
</head>

<body class="bg-default">
  <!-- Navbar -->
  <nav id="navbar-main" class="navbar navbar-horizontal navbar-transparent navbar-main navbar-expand-lg navbar-light">
    <div class="container">
      <a class="navbar-brand" href="../../pages/dashboards/dashboard.html">
        <img src="assets/img/brand/white.png">
      </a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar-collapse" aria-controls="navbar-collapse" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="navbar-collapse navbar-custom-collapse collapse" id="navbar-collapse">
        <div class="navbar-collapse-header">
          <div class="row">
            <div class="col-6 collapse-brand">
              <a href="pages/dashboards/dashboard.html">
                <img src="assets/img/brand/blue.png">
              </a>
            </div>
            <div class="col-6 collapse-close">
              <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#navbar-collapse" aria-controls="navbar-collapse" aria-expanded="false" aria-label="Toggle navigation">
                <span></span>
                <span></span>
              </button>
            </div>
          </div>
        </div>

        <hr class="d-lg-none" />
         <ul class="navbar-nav align-items-lg-center ml-lg-auto">
           <li class="nav-item">
             <a class="nav-link nav-link-icon" href="https://www.facebook.com/DutaWacana/" target="_blank" data-toggle="tooltip" title="" data-original-title="Like UKDW di Facebook">
               <i class="fab fa-facebook-square"></i>
               <span class="nav-link-inner--text d-lg-none">Facebook</span>
             </a>
           </li>
           <li class="nav-item">
             <a class="nav-link nav-link-icon" href="https://www.instagram.com/duta_wacana" target="_blank" data-toggle="tooltip" title="" data-original-title="Follow UKDW di Instagram">
               <i class="fab fa-instagram"></i>
               <span class="nav-link-inner--text d-lg-none">Instagram</span>
             </a>
           </li>
           <li class="nav-item">
             <a class="nav-link nav-link-icon" href="https://twitter.com/ukdw" target="_blank" data-toggle="tooltip" title="" data-original-title="Follow UKDW di Twitter">
               <i class="fab fa-twitter-square"></i>
               <span class="nav-link-inner--text d-lg-none">Twitter</span>
             </a>
           </li>
           <li class="nav-item">
             <a class="nav-link nav-link-icon" href="https://www.youtube.com/channel/UC5cKNXrmMhLC8jdbap_ZBbg/feed?reload=9" target="_blank" data-toggle="tooltip" title="" data-original-title="Subscibe UKDW di Youtube">
               <i class="fab fa-youtube"></i>
               <span class="nav-link-inner--text d-lg-none">Youtube</span>
             </a>
           </li>
           <li class="nav-item">
             <a class="nav-link nav-link-icon" href="https://ukdw.ac.id" target="_blank" data-toggle="tooltip" title="" data-original-title="Kunjungi UKDW Website">
               <i class="ni ni-world"></i>
               <span class="nav-link-inner--text d-lg-none">Website</span>
             </a>
           </li>
           <li class="nav-item d-none d-lg-block ml-lg-4">
             <a href="../sib/index#pengumuman" class="btn btn-neutral btn-icon">
               <span class="btn-inner--icon">
                 <i class="fas fa-newspaper mr-2"></i> 
               </span>
               <span class="nav-link-inner--text">Pengumuman</span>
             </a>
           </li>
         </ul>
       </div>
     </div>
   </nav>
  <!-- Main content -->
  <div class="main-content">
    <!-- Header -->
    <div class="header bg-gradient-primary py-7 py-lg-8 pt-lg-9">
      <div class="container">
        <div class="header-body text-center mb-3">
          <div class="row justify-content-center">
            <!-- <div class="col-xl-5 col-lg-6 col-md-8 px-5">
              <h1 class="text-white">Welcome!</h1>
              <p class="text-lead text-white">Use these awesome forms to login or create new account in your project for free.</p>
            </div> -->
          </div>
        </div>
      </div>
      <div class="separator separator-bottom separator-skew zindex-100">
        <svg x="0" y="0" viewBox="0 0 2560 100" preserveAspectRatio="none" version="1.1" xmlns="http://www.w3.org/2000/svg">
          <polygon class="fill-default" points="2560 0 2560 100 0 100"></polygon>
        </svg>
      </div>
    </div>
    <!-- Page content -->
    <div class="container mt--8 pb-5">
      <div class="row justify-content-center">
        <div class="col-lg-5 col-md-7">
          <div class="card bg-secondary border-0 mb-0">
            <div class="card-header bg-transparent pb-1">
              <div class="text-muted text-center"><h1>LOGIN</h1></div>
              <!-- <div class="btn-wrapper text-center">
                <a href="#" class="btn btn-neutral btn-icon">
                  <span class="btn-inner--icon"><img src="../../assets/img/icons/common/github.svg"></span>
                  <span class="btn-inner--text">Github</span>
                </a>
                <a href="#" class="btn btn-neutral btn-icon">
                  <span class="btn-inner--icon"><img src="../../assets/img/icons/common/google.svg"></span>
                  <span class="btn-inner--text">Google</span>
                </a>
              </div> -->
            </div>
            <div class="card-body px-lg-5 py-lg-5">
              <form role="form" method="post" class="needs-validation">
                <div class="form-group mb-3">
              <?php If(isset($_GET['failed']) && $_GET['failed'] == 1)
              {?>
									                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                <span class="alert-text"><i class="fas fa-exclamation-circle">&nbsp</i><strong><?php echo htmlentities($_SESSION['errmsg']); ?><?php echo htmlentities($_SESSION['errmsg']="");?></strong></span>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <?php } ?>

              <!-- logout -->
              <?php If(isset($_GET['logout']) && $_GET['logout'] == 1)
              {?>
									                <div class="alert alert-success alert-dismissible fade show" role="alert">
                <span class="alert-text"><i class="fas fa-check-circle"></i>&nbsp</i><strong><?php echo htmlentities($_SESSION['errmsg']); ?><?php echo htmlentities($_SESSION['errmsg']="");?></strong></span>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <?php } ?>

                  <div class="input-group input-group-merge input-group-alternative">
                    <div class="input-group-prepend">
                      <span class="input-group-text">@</span>
                    </div>
                    <input class="form-control" placeholder="Username" name="username" id="validationDefaultUsername" aria-describedby="inputGroupPrepend1" type="text" title="Masukkan NIM/Username"  oninvalid="this.setCustomValidity('Selahkan masukkan NIM/Username anda.')" oninput="setCustomValidity('')" required>
                  </div>
                </div>
                <div class="form-group">
                  <div class="input-group input-group-merge input-group-alternative">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="ni ni-lock-circle-open"></i></span>
                    </div>
                    <input class="form-control" placeholder="Password" name="password" type="password" title="Masukkan Password"  oninvalid="this.setCustomValidity('Selahkan masukkan Password anda.')" oninput="setCustomValidity('')" required>
                  </div>
                </div>
                <div class="custom-control custom-control-alternative custom-checkbox">
                  <input class="custom-control-input" id=" customCheckLogin" type="checkbox">
                  <label class="custom-control-label" for=" customCheckLogin">
                    <span class="text-muted">Remember me</span>
                  </label>
                </div>
                <div class="text-center">
                <button type="submit" id="login" name="login" value="Login" class="btn btn-primary my-4">Sign in</button>
                </div>
              </form>
            </div>
          </div>
          <div class="row mt-3">
            <div class="col-6">
              <a href="#" class="text-light"><small>Forgot password?</small></a>
            </div>
            <div class="col-6 text-right">
              <a href="#" class="text-light"><small>Create new account</small></a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- Footer -->
  <footer class="py-5" id="footer-main">
    <div class="container">
      <div class="row align-items-center justify-content-xl-between">
        <div class="col-xl-6">
          <div class="copyright text-center text-xl-left text-muted">
            &copy; 2019 <a href="https://www.creative-tim.com" class="font-weight-bold ml-1" target="_blank">Creative Tim</a>
          </div>
        </div>
        <div class="col-xl-6">
          <ul class="nav nav-footer justify-content-center justify-content-xl-end">
            <li class="nav-item">
              <a href="https://www.creative-tim.com" class="nav-link" target="_blank">Creative Tim</a>
            </li>
            <li class="nav-item">
              <a href="https://www.creative-tim.com/presentation" class="nav-link" target="_blank">About Us</a>
            </li>
            <li class="nav-item">
              <a href="http://blog.creative-tim.com" class="nav-link" target="_blank">Blog</a>
            </li>
            <li class="nav-item">
              <a href="https://www.creative-tim.com/license" class="nav-link" target="_blank">License</a>
            </li>
          </ul>
        </div>
      </div>
    </div>
  </footer>
  <!-- Argon Scripts -->
  <!-- Core -->
  <script src="./assets/vendor/jquery/dist/jquery.min.js"></script>
  <script src="./assets/vendor/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
  <script src="./assets/vendor/js-cookie/js.cookie.js"></script>
  <script src="./assets/vendor/jquery.scrollbar/jquery.scrollbar.min.js"></script>
  <script src="./assets/vendor/jquery-scroll-lock/dist/jquery-scrollLock.min.js"></script>
  <!-- Argon JS -->
  <script src="./assets/js/argon.js?v=1.1.0"></script>
  <!-- Demo JS - remove this in your project -->
  <script src="./assets/js/demo.min.js"></script>
  <script>
    // Example starter JavaScript for disabling form submissions if there are invalid fields
    (function() {
      'use strict';
      window.addEventListener('load', function() {
        // Fetch all the forms we want to apply custom Bootstrap validation styles to
        var forms = document.getElementsByClassName('needs-validation');
        // Loop over them and prevent submission
        var validation = Array.prototype.filter.call(forms, function(form) {
          form.addEventListener('submit', function(event) {
            if (form.checkValidity() === false) {
              event.preventDefault();
              event.stopPropagation();
            }
            form.classList.add('was-validated');
          }, false);
        });
      }, false);
    })();
  </script>
  <script type="text/javascript">
    document.getElementById("close_direct").onclick = function () {
        location.href = "login";
    };
</script>
</body>

</html>