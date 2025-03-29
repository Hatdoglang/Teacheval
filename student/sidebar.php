<aside class="main-sidebar sidebar-dark-primary elevation-4" style="background-color: white;">
<div class="dropdown">
<div class="dropdown text-center p-3">
      <div class="logo-container">
        <img src="assets/dist/img/test.png" alt="Logo" class="logo">
        <h3 class="ms-2"><b>Student</b></h3>
      </div>
    </div>
    <style>
      .logo-container {
        display: flex;
        align-items: center;
        justify-content: center;
      }

      .logo {
        height: 40px;
        margin-right: 10px;
      }

      h3 {
        font-size: 20px;
      }
      .p-3{
        background-color:rgba(233, 230, 230, 0.81);
      }
    </style>
      
    </div>
    <div class="sidebar ">
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column nav-flat" data-widget="treeview" role="menu" data-accordion="false">
         <li class="nav-item dropdown">
            <a href="./" class="nav-link nav-home">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Dashboard
              </p>
            </a>
          </li>
          <li class="nav-item dropdown">
            <a href="./index.php?page=evaluate" class="nav-link nav-evaluate">
              <i class="nav-icon fas fa-th-list"></i>
              <p>
                Evaluate
              </p>
            </a>
          </li> 
        </ul>
      </nav>
    </div>
  </aside>
  <script>
  	$(document).ready(function(){
      var page = '<?php echo isset($_GET['page']) ? $_GET['page'] : 'home' ?>';
  		var s = '<?php echo isset($_GET['s']) ? $_GET['s'] : '' ?>';
      if(s!='')
        page = page+'_'+s;
  		if($('.nav-link.nav-'+page).length > 0){
             $('.nav-link.nav-'+page).addClass('active')
  			if($('.nav-link.nav-'+page).hasClass('tree-item') == true){
            $('.nav-link.nav-'+page).closest('.nav-treeview').siblings('a').addClass('active')
  				$('.nav-link.nav-'+page).closest('.nav-treeview').parent().addClass('menu-open')
  			}
        if($('.nav-link.nav-'+page).hasClass('nav-is-tree') == true){
          $('.nav-link.nav-'+page).parent().addClass('menu-open')
        }

  		}
     
  	})
  </script>
