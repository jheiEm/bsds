<?php require('../config.php') ?>
<?php
if (isset($_SESSION['email'])) {
    // Display the welcome message with the user's email
    $email = $_SESSION['email'];
        header("Location: dashboard.php");
        exit();
}
// Function to sanitize user input
function sanitizeInput($input)
{
    // Trim whitespace
    $input = trim($input);
    // Remove slashes
    $input = stripslashes($input);
    // Convert special characters to HTML entities
    $input = htmlspecialchars($input);
    return $input;
}
// Function to login
function login($username, $password, $conn)
{
    $username = sanitizeInput($username);
    $password = sanitizeInput($password);
    $password = md5($password); // Note: MD5 is not secure for password hashing, consider using bcrypt or Argon2

    $stmt = $conn->prepare("SELECT * FROM client_list WHERE email = ? AND password = ?");
    $stmt->bind_param("ss", $username, $password);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $_SESSION['user_id'] = $row['id'];
        $_SESSION['username'] = $row['email'];
        $_SESSION['email'] = $row['email'];
        return true;
    }
    return false;
}
// Process login form submission
if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    if (login($username, $password, $conn)) {
        // Login successful, redirect to dashboard or any other page
	if (isset($_SESSION['email'])) {
    // Display the welcome message with the user's email
    $email = $_SESSION['email'];
        header("Location: dashboard.php");
        exit();
}
    } else {
        $errorMessage = "Invalid email or password.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Student | Log in</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="../plugins/fontawesome-free/css/all.min.css">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="../plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="../dist/css/adminlte.min.css">
  <link rel="stylesheet" href="css/css.css">
</head>
 <style>
    body{
      background-image: url("gradient.jpg");
      background-size:cover;
      background-repeat:no-repeat;
    }
    .login-title{
        text-shadow: 1px 1px black
        text-align: center;
        font-weight: bold;
        color: #1D7ECB;
    }
    .logo-box {
        text-align: center;
        margin-bottom: 20px;
    }
    .logo-box img {
        max-width: 120px;
    }
    .login-box {
        max-width: 400px;
        margin: 80px auto;
        background-color: transparent;
        padding: 5px;
        border-radius: 20px;
        box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
    }
    .login-btn {
        width: 100% !important;
        background-color: #1D7ECB !important;
        border: none;
        padding: 10px !important;
    }
    .login-btn:hover {
        background-color: #105a87;
    }
    .login-box-msg {
        text-align: center;
        font-weight: bold;
        color: #1D7ECB;
    }
    .logo-text{
        text-align: center;
        margin-bottom: 20px;
    }
    #login-box{
        border-radius: 10px;
    }

  </style>
<!-- <body class="hold-transition login-page"> -->
<body class="hold-transition login-page  light-mode">
	  <header id="header" class="menu-container">
    <!--   Logo -->
    <!--   Logo -->
    <!--   navbar -->
    <!--   navbar -->
  </header>

<div class="login-box">
  <!-- /.login-logo -->
  <div class="card" id="login-box">
        <div class="card-body login-card-body">
        <a href="<?php echo base_url ?>">
        <div class="logo-box">
            <img src="logo.png" alt="Logo">
        </div>
            <div class="logo-text">
                <p>Batangas Scholarship Disbursement System</p>
            </div>
        </a>
      <p class="login-box-msg">
          Sign in to start your session
      </p>
      <?php if (isset($errorMessage)): ?>
        <p style="text-align:center;color:red"><?php echo $errorMessage; ?></p>
    <?php endif; ?>
      <form action="" method="post">
        <div class="input-group mb-3">
          <input type="email" class="form-control" placeholder="Email" name="username">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-envelope"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="password" class="form-control" name="password" placeholder="Password"   >
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>

          <!-- /.col -->
          <div class="col-12">
            <button type="submit" name="login" class="btn btn-primary btn-block login-btn">Sign In</button>

          </div>
          <!-- /.col -->
        </div>
      </form>

      <!-- /.social-auth-links -->

      <p style="padding-left: 20px;" class="mb-1">
        <a href="forgot.php">I forgot my password</a>
      </p>
      <p class="mb-0" style="padding-left: 20px;padding-bottom:20px;">
        <a href="index.php" class="text-center">Create an Account</a>
      </p>
    </div>
    <!-- /.login-card-body -->
  </div>
</div>
<!-- /.login-box -->

<!-- jQuery -->
<script src="../../plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="../../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="../../dist/js/adminlte.min.js"></script>
</body>
</html>
