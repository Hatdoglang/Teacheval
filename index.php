<?php
session_start();
ob_start();  // Prevents "headers already sent" error

// Redirect to login page if not logged in
if (!isset($_SESSION['login_id'])) {
    header('Location: login.php');
    exit();
}

include 'db_connect.php';

// Load system settings into session if not already set
if (!isset($_SESSION['system'])) {
    $system = $conn->query("SELECT * FROM system_settings")->fetch_array();
    foreach ($system as $k => $v) {
        $_SESSION['system'][$k] = $v;
    }
}

ob_end_flush();  // End output buffering
?>
<!DOCTYPE html>
<html lang="en">
<?php include 'header.php' ?>

<body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">
    <div class="wrapper">
        <?php include 'topbar.php' ?>
        <?php include $_SESSION['login_view_folder'].'sidebar.php' ?>

        <!-- Content Wrapper -->
        <div class="content-wrapper">
            <div class="toast" id="alert_toast" role="alert" aria-live="assertive" aria-atomic="true">
                <div class="toast-body text-white"></div>
            </div>
            <div id="toastsContainerTopRight" class="toasts-top-right fixed"></div>

            <!-- Content Header -->
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0"><?php echo htmlspecialchars($title); ?></h1>
                        </div>
                    </div>
                    <hr class="border-primary">
                </div>
            </div>

            <!-- Main Content -->
            <section class="content">
                <div class="container-fluid">
                    <?php 
                    $page = isset($_GET['page']) ? $_GET['page'] : 'home';
                    $filepath = $_SESSION['login_view_folder'] . $page . ".php";
                    
                    if (!file_exists($filepath)) {
                        include '404.html';
                    } else {
                        include $filepath;
                    }
                    ?>
                </div>
            </section>

            <!-- Confirmation Modal -->
            <div class="modal fade" id="confirm_modal" role="dialog">
                <div class="modal-dialog modal-md">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Confirmation</h5>
                        </div>
                        <div class="modal-body">
                            <div id="delete_content"></div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-primary" id="confirm">Continue</button>
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Universal Modal -->
            <div class="modal fade" id="uni_modal" role="dialog">
                <div class="modal-dialog modal-md">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title"></h5>
                        </div>
                        <div class="modal-body"></div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-primary" id="submit" onclick="$('#uni_modal form').submit()">Save</button>
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Viewer Modal -->
            <div class="modal fade" id="viewer_modal" role="dialog">
                <div class="modal-dialog modal-md">
                    <div class="modal-content">
                        <button type="button" class="btn-close" data-dismiss="modal">
                            <span class="fa fa-times"></span>
                        </button>
                        <img src="" alt="">
                    </div>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <footer class="main-footer">
            <strong>Copyright &copy; 2025 <a href="#">Teacheval Plus</a>.</strong>
            All rights reserved.
            <div class="float-right d-none d-sm-inline-block">
                <b><?php echo htmlspecialchars($_SESSION['system']['name']); ?></b>
            </div>
        </footer>
    </div>

    <!-- Required Scripts -->
    <?php include 'footer.php' ?>
</body>
</html>
