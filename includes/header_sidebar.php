<header class="main-header">
    <!-- Logo -->
    <a href="index.php" class="logo">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini"><img class="adapted-image" src="images/logos/mini_logo.png"></span>
      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg"><b>Urban</b>Games</span>
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
      <!-- Sidebar toggle button-->
      <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
        <span class="sr-only">Toggle navigation</span>
      </a>

      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
          <!-- Tasks: style can be found in dropdown.less -->
          <?php if(isset($_SESSION['username'])){ ?>
          <li class="dropdown tasks-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <i class="fa fa-exclamation-circle"></i>
              <span class="label label-danger"><?php echo get_notification(get_id($_SESSION['username'])); ?></span>
            </a>
            <ul class="dropdown-menu">
              <li class="header">You have <?php echo get_notification(get_id($_SESSION['username'])); ?> activities</li>
              <li>
                <!-- inner menu: contains the actual data -->
                <ul class="menu">
                  <li>
                    <a href="#">
                      <i class="fa fa-repeat text-blue margin-r-5 "></i> Hai <?php echo get_my_active_tournament(get_id($_SESSION['username'])); ?> Tornei in corso
                    </a>
                  </li>
                  <li>
                    <a href="#">
                      <i class="fa fa-registered text-blue margin-r-5 "></i> Hai <?php echo get_my_not_started_tournament(get_id($_SESSION['username'])); ?> Tornei ancora in fase di iscrizione
                    </a>
                  </li>
                  <li>
                    <a href="#">
                      <i class="fa fa-soccer-ball-o text-blue margin-r-5 "></i> Hai <?php echo get_to_play(get_id($_SESSION['username'])); ?> partite da giocare
                    </a>
                  </li>
                  <li>
                    <a href="#">
                      <i class="fa fa-check-square-o text-blue margin-r-5 "></i> Hai <?php echo get_to_confirm(get_id($_SESSION['username'])); ?> risultati da confermare
                    </a>
                  </li>
                  <li>
                    <a href="#">
                      <i class="fa fa-plus text-blue margin-r-5 "></i> Ci sono <?php echo get_available_tournament(get_id($_SESSION['username'])); ?> Tornei disponibili
                    </a>
                  </li>
                </ul>
              </li>
            </ul>
          </li>
          <!-- User Account: style can be found in dropdown.less -->
          <li class="dropdown user user-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <img src="images/profile_images/<?php echo get_img(get_id($_SESSION['username'])); ?>" class="user-image" alt="User Image">
              <span class="hidden-xs"><?php echo $_SESSION['username']; ?></span>
            </a>
            <ul class="dropdown-menu">
              <!-- User image -->
              <li class="user-header">
                <img src="images/profile_images/<?php echo get_img(get_id($_SESSION['username'])); ?>" class="img-circle" alt="User Image">

                <p>
                  <?php echo $_SESSION['username']; ?>
                </p>
                <div class="pull-left">
                  <a href="profile.php?id=<?php echo get_id($_SESSION['username'])?>"><button type="button" class="btn btn-block btn-warning button-dropdown">Profile</button></a>
                </div>
                <div class="pull-right">
                  <a href="login/login.php"><button type="button" class="btn btn-block btn-danger button-dropdown">Sign out</button></a>
                </div>
              </li>
              <!-- Menu Body -->
              <!--<li class="user-body">
                <div class="row">
                  <div class="col-xs-3 text-left">
                    <a href="#">Credits:</a>
                  </div>
                  <div class="col-xs-4 text-left">
                    <a href="#"><?php echo get_balance(get_id($_SESSION['username'])); ?></a>
                    <i class="fa fa-money text-green"></i>
                  </div>
                  <div class="col-xs-5 text-right">
                    <a href="#">Shop <i class="fa fa-shopping-cart text-blue"></i></a>
                  </div>
                </div>
              </li>-->
              <!-- Menu Footer-->
            </ul>
          </li>
          <?php } else{
            ?>
            <div class="button-signin">
            <a href="login/login.php"><button type="button" class="btn btn-block btn-danger">Sign in</button></a>
            </div>
          <?php
          }
          ?>
        </ul>
      </div>
    </nav>
  </header>
  <!-- Left side column. contains the logo and sidebar -->
  <aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <!-- Sidebar user panel -->
     <?php if(isset($_SESSION['username'])){ ?>
      <div class="user-panel">
        <div style="min-height: 30px;" class="pull-left image">
           <img style="height: 100%;" src="images/profile_images/<?php echo get_img(get_id($_SESSION['username'])); ?>" class="img-circle" alt="User Image">
        </div>
        <div class="pull-left info">
          <p><?php echo $_SESSION['username']; ?></p>
          <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
        </div>
      </div>
      <?php }
      ?>
            <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu">
        <li class="header">MAIN NAVIGATION</li>
        <li class="active treeview">
          <a href="#">
            <i class="fa fa-trophy"></i> <span>Tornei</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li class="active"><a href="all_tournaments.php"><i class="fa fa-circle-o"></i> Tutti i tornei</a></li>
            <li><a href="gt_tournaments.php"><i class="fa fa-circle-o text-green"></i> Tornei Gamestime</a></li>
            <!--<li><a href="free_tournaments.php"><i class="fa fa-circle-o text-aqua"></i> Tornei FREE</a></li>
            <li><a href="pro_tournaments.php"><i class="fa fa-circle-o text-green"></i> Tornei PRO</a></li>-->
            <?php if(isset($_SESSION['username'])){ ?>
            <li><a href="my_tournaments.php"><i class="fa fa-circle-o text-yellow"></i> Miei Tornei</a></li>
             <?php }
             ?>
          </ul>
        </li>
        <li class="treeview">
          <a href="#">
            <i class="fa fa-share-alt"></i>
            <span>Social</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="pages/layout/top-nav.html"><i class="fa fa-facebook"></i> Facebook</a></li>
            <li><a href="pages/layout/boxed.html"><i class="fa fa-twitter"></i> Twitter</a></li>
            <li><a href="pages/layout/fixed.html"><i class="fa fa-google-plus"></i> Google +</a></li>
            <li><a href="pages/layout/collapsed-sidebar.html"><i class="fa fa-youtube"></i> Youtube</a></li>
          </ul>
        </li>
        <li class="treeview">
          <a href="#">
            <i class="fa fa-question-circle"></i>
            <span>Contatti</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="pages/layout/top-nav.html"><i class="fa fa-paper-plane"></i> Telegram</a></li>
            <li><a href="pages/layout/boxed.html"><i class="fa fa-envelope"></i> Mail</a></li>
          </ul>
        </li>
        <li><a href="documentation/index.html"><i class="fa fa-book"></i> <span>Regolamento</span></a></li>
        <?php if(isset($_SESSION['username']) && get_admin(get_id($_SESSION['username']))){ ?>
        <li><a href="admin.php"><i class="fa fa-user"></i> <span>Admin</span></a></li>
        <?php } ?>
      </ul>
    </section>
    <!-- /.sidebar -->
  </aside>