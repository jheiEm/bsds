<?php require_once('../config.php')

?>
<!DOCTYPE html>
<html lang="en" class="" style="height: auto;">
 <?php require_once('inc/header.php') ?>
   <link rel="stylesheet" href="css/css.css">
<body class="hold-transition login-page  light-mode">
	  <header id="header" class="menu-container">

    <!--   Logo -->
    <div class="logo-box">
     <a href="<?php echo $base_url; ?>"><img src="logo.png" alt="" id="header-img"><p style="margin-top: 30px; color:black;"></a>Batangas Scholarship Disbursement System </p>

    </div>
    <!--   Logo -->
  
    <!--   navbar -->
    
    <!--   navbar -->
  </header>
  <script>
    start_loader()
  </script>
  <style>
    body{
      background-image: url("<?php echo validate_image($_settings->info('cover')) ?>");
      background-size:cover;
      background-repeat:no-repeat;
    }
    .login-title{
      text-shadow: 1px 1px black
    }
  </style>

<div class="login-box" >
  <!-- /.login-logo -->
  <div class="card card-outline card-primary">
    <div class="card-header text-center">
      <a href="./" class="h1"><b>Admin Login</b></a>
    </div>
    <div class="card-body">
      <p class="login-box-msg" >Sign in to start your session</p>

      <form id="login-frm" action="" method="post">
        <div class="input-group mb-3">
          <input type="text" class="form-control" name="username" placeholder="Username" style="background-color:#fff;">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-user"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="password" class="form-control" name="password" placeholder="Password" style="background-color:#fff;">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
    
   <p class="mb-1">
        <a href="forgot.php" style="color:white;">I forgot my password</a>
      </p>
        <div class="row">
          <div class="col-8">
          </div>
          <!-- /.col -->
          <div class="col-4" >
            <button style="width:100%;" type="submit" class="btn btn-primary btn-block" >Sign In</button>
          </div>
       
        </div>
      </form>
      <!-- /.social-auth-links -->

    
      
    </div>
    <!-- /.card-body -->
  </div>
  <!-- /.card -->
</div>
<!-- /.login-box -->

<!-- jQuery -->
<script src="plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>

<script>
  $(document).ready(function(){
    end_loader();
  })
</script>
</body>
</html>