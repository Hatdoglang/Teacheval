<?php
session_start();  // Start session at the very beginning
ob_start();  // Enable output buffering

include('./db_connect.php');

// Load system settings if not set in session
if (!isset($_SESSION['system'])) {
    $system = $conn->query("SELECT * FROM system_settings")->fetch_array();
    foreach ($system as $k => $v) {
        $_SESSION['system'][$k] = $v;
    }
}

ob_end_flush();  // Flush output buffer

// Redirect if already logged in
if (isset($_SESSION['login_id'])) {
    header("Location: index.php?page=home");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<?php include 'header.php'; ?>

<style>
  body {
    background-image: url('assets/uploads/background.jpg');
    background-size: cover;
    background-position: center;
    background-attachment: fixed;
    background-repeat: no-repeat;
    height: 100vh;
    display: flex;
    justify-content: center;
    align-items: center;
    position: relative;
  }
  body::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.5);
    z-index: -1;
  }
  @media (max-width: 768px) {
    body {
      background-size: contain;
      background-position: center;
      background-size: cover;
    }
  }
  h2 {
    color: white;
  }
</style>

<body class="hold-transition login-page bg-white">
  <h2><b><?php echo htmlspecialchars($_SESSION['system']['name']); ?> - Login</b></h2>
  
  <div class="login-box">
    <div class="login-logo">
      <a href="#" class="text-white"></a>
    </div>
    <div class="card">
      <div class="card-body login-card-body">
        <form action="" id="login-form">
          <div class="input-group mb-3">
            <input type="email" class="form-control" name="email" required placeholder="Email">
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-envelope"></span>
              </div>
            </div>
          </div>
          <div class="input-group mb-3">
            <input type="password" class="form-control" name="password" required placeholder="Password">
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-lock"></span>
              </div>
            </div>
          </div>
          <div class="form-group mb-3">
            <label for="">Login As</label>
            <select name="login" class="custom-select custom-select-sm">
              <option value="3">Student</option>
              <option value="2">Faculty</option>
            </select>
          </div>
          <div class="row">
            <div class="col-8">
              <div class="icheck-primary">
                <input type="checkbox" id="remember">
                <label for="remember">Remember Me</label>
              </div>
            </div>
            <div class="col-4">
              <button type="submit" class="btn btn-primary btn-block">Sign In</button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>

  <script>
    $(document).ready(function() {
      $('#login-form').submit(function(e) {
        e.preventDefault();
        start_load();
        if ($(this).find('.alert-danger').length > 0)
          $(this).find('.alert-danger').remove();
        $.ajax({
          url: 'ajax.php?action=login',
          method: 'POST',
          data: $(this).serialize(),
          error: err => {
            console.log(err);
            end_load();
          },
          success: function(resp) {
            if (resp == 1) {
              location.href = 'index.php?page=home';
            } else {
              $('#login-form').prepend('<div class="alert alert-danger">Username or password is incorrect.</div>');
              end_load();
            }
          }
        });
      });
    });
  </script>

  <?php include 'footer.php'; ?>
</body>
</html>
