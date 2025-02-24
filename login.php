<?php 
session_start();
include('./db_connect.php');
ob_start();
$system = $conn->query("SELECT * FROM system_settings")->fetch_array();
foreach($system as $k => $v){
  $_SESSION['system'][$k] = $v;
}
ob_end_flush();

if(isset($_SESSION['login_id']))
  header("location:index.php?page=home");
?>
<!DOCTYPE html>
<html lang="en">

<!-- Include your header file (AdminLTE, Bootstrap, etc.) -->
<?php include 'header.php'; ?>

<style>
  /* Background styling */
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

  /* Ensure the .login-box is on top of the overlay */
  .login-box {
    z-index: 1;
  }

  /* Add a box shadow to the card for better contrast against the background */
  .card {
    box-shadow: 0 0 20px rgba(0, 0, 0, 0.3);
  }

  /* Login heading */
  .login-logo h2 {
    color: #fff;
    margin-bottom: 1rem;
  }

  /* Profile image in the sign-up modal */
  img#cimg {
    height: 100px;
    width: 100px;
    object-fit: cover;
    border-radius: 50%;
    display: block;
    margin: auto;
  }
</style>

<body class="hold-transition login-page">
  <div class="login-box">
    <!-- You can use .login-logo for a header or logo area -->
    <div class="login-logo">
      <h2><b><?php echo $_SESSION['system']['name'] ?> - Login</b></h2>
    </div>
    <!-- /.login-logo -->

    <div class="card">
      <div class="card-body login-card-body">
        <form action="" id="login-form">
          <div class="input-group mb-3">
            <input type="email" class="form-control" name="email" required placeholder="Email">
            <div class="input-group-append">
              <div class="input-group-text"><span class="fas fa-envelope"></span></div>
            </div>
          </div>

          <div class="input-group mb-3">
            <input type="password" class="form-control" name="password" required placeholder="Password">
            <div class="input-group-append">
              <div class="input-group-text"><span class="fas fa-lock"></span></div>
            </div>
          </div>

          <div class="form-group mb-3">
            <label for="login">Login As</label>
            <select name="login" class="custom-select custom-select-sm">
              <option value="3">Student</option>
              <option value="2">Faculty</option>
              <!-- <option value="1">Admin</option> -->
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

        <p class="mt-3 text-center">
          Don't have an account? 
          <a href="#" data-toggle="modal" data-target="#signupModal">Sign Up</a>
        </p>
      </div>
      <!-- /.login-card-body -->
    </div>
    <!-- /.card -->
  </div>
  <!-- /.login-box -->

  <!-- Sign-Up Modal -->
  <div class="modal fade" id="signupModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Sign Up / Student</h5>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
          <form id="manage_student" enctype="multipart/form-data">
            <div class="row">
              <div class="col-md-6 border-right">
                <div class="form-group">
                  <label>School ID</label>
                  <input type="text" name="school_id" class="form-control" required>
                </div>
                <div class="form-group">
                  <label>First Name</label>
                  <input type="text" name="firstname" class="form-control" required>
                </div>
                <div class="form-group">
                  <label>Last Name</label>
                  <input type="text" name="lastname" class="form-control" required>
                </div>
                <div class="form-group">
                  <label>Class</label>
                  <select name="class_id" class="form-control">
                    <option value="">Select Class</option>
                    <?php 
                      $classes = $conn->query("SELECT id, concat(curriculum,' ',level,' - ',section) as class FROM class_list");
                      while($row = $classes->fetch_assoc()):
                    ?>
                    <option value="<?php echo $row['id'] ?>"><?php echo $row['class'] ?></option>
                    <?php endwhile; ?>
                  </select>
                </div>
              </div>

              <div class="col-md-6">
                <div class="form-group">
                  <label>Email</label>
                  <input type="email" name="email" class="form-control" required>
                </div>
                <div class="form-group">
                  <label>Password</label>
                  <input type="password" name="password" class="form-control" required>
                </div>
                <div class="form-group">
                  <label>Profile Picture (Optional)</label>
                  <input type="file" class="form-control" name="avatar" id="avatar" onchange="displayImg(this)">
                  <img src="assets/uploads/default-avatar.png" id="cimg">
                </div>
              </div>
            </div>
            <div class="modal-footer">
              <button type="submit" class="btn btn-success">Register</button>
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
  <!-- End Sign-Up Modal -->

  <script>
    function displayImg(input) {
      if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
          $('#cimg').attr('src', e.target.result);
        }
        reader.readAsDataURL(input.files[0]);
      }
    }

    // Handle student sign-up
    $('#manage_student').submit(function(e){
      e.preventDefault();
      $('input').removeClass("border-danger");

      var formData = new FormData(this);
      $.ajax({
          url: 'ajax.php?action=save_student',
          data: formData,
          cache: false,
          contentType: false,
          processData: false,
          method: 'POST',
          success: function(resp){
              if(resp == 1){
                  alert("Registration successful!");
                  $('#signupModal').modal('hide');
                  $('#manage_student')[0].reset();
                  $('#cimg').attr('src', 'assets/uploads/default-avatar.png');
              } else if(resp == 2){
                  $('#msg').html("<div class='alert alert-danger'>Email already exists.</div>");
                  $('[name=\"email\"]').addClass("border-danger");
              }
          }
      });
    });

    // Handle login
    $('#login-form').submit(function(e){
      e.preventDefault();
      start_load();
      if ($(this).find('.alert-danger').length > 0) 
        $(this).find('.alert-danger').remove();
      $.ajax({
        url:'ajax.php?action=login',
        method:'POST',
        data:$(this).serialize(),
        error:err=>{
          console.log(err);
          end_load();
        },
        success:function(resp){
          if(resp == 1){
            location.href = 'index.php?page=home';
          } else {
            $('#login-form').prepend('<div class="alert alert-danger">Username or password is incorrect.</div>');
            end_load();
          }
        }
      });
    });
  </script>

<?php include 'footer.php'; ?>
</body>
</html>
