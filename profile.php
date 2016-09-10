<!DOCTYPE html>
<html>
<head>
  <?php session_start();
  $id=htmlspecialchars($_GET['id']);
  include ("bin/getters_UI.php");
  include ("bin/getters_ub.php");
  include ("bin/getters_user.php"); 
  include ("DB/connections.php");
  include ("bin/displays_ub.php");
  include ("login/register_functions.php");
  include ("bin/refresh_user.php");
  if(isset($_POST['username']) && strcmp($_POST['username'],"")!=0 && isset($_POST['check_password'])){
  refresh_username($_POST['username'], $_POST['check_password'], $id);  
  }
    if(isset($_POST['password']) && strcmp($_POST['password'],"")!=0 && isset($_POST['password2']) && strcmp($_POST['password2'],"")!=0  && isset($_POST['check_password'])){
  refresh_password($_POST['password'],$_POST['password2'],$_POST['check_password'], $id);
  }
    if(isset($_POST['mail']) && strcmp($_POST['mail'],"")!=0 && isset($_POST['check_password'])){
  refresh_mail($_POST['mail'], $_POST['check_password'], $id);
  }
    if(isset($_POST['telegram']) && strcmp($_POST['telegram'],"")!=0  && isset($_POST['check_password'])){
  refresh_telegram($_POST['telegram'], $_POST['check_password'], $id); 
  }
    if(isset($_POST['id_ps4']) && strcmp($_POST['id_ps4'],"")!=0  && isset($_POST['check_password'])){
  refresh_id_ps4($_POST['id_ps4'], $_POST['check_password'], $id);
  }
  /*if(isset($_POST['username']) || isset($_POST['password'])  || isset($_POST['mail'])  || isset($_POST['telegram'])  || isset($_POST['id_ps4'])){
   header('Location: redirect.php');
 }*/
 if(isset($_POST['img'])){
  refresh_user_img($id);  
  }
  ?>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Urbangames | Profilo</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.6 -->
  <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
  <!-- Personal CSS -->
  <link rel="stylesheet" href="custom.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/AdminLTE.min.css">
  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="dist/css/skins/_all-skins.min.css">
  <!-- iCheck -->
  <link rel="stylesheet" href="plugins/iCheck/flat/blue.css">
  <!-- Morris chart -->
  <link rel="stylesheet" href="plugins/morris/morris.css">
  <!-- jvectormap -->
  <link rel="stylesheet" href="plugins/jvectormap/jquery-jvectormap-1.2.2.css">
  <!-- Date Picker -->
  <link rel="stylesheet" href="plugins/datepicker/datepicker3.css">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="plugins/daterangepicker/daterangepicker.css">
  <!-- bootstrap wysihtml5 - text editor -->
  <link rel="stylesheet" href="plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
</head>
<body class="hold-transition skin-blue sidebar-mini modal-open">
<div class="wrapper">
  <?php include ("includes/header_sidebar.php"); ?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <section class="content-header">
      <h1>
        Profilo
      </h1>
      <ol class="breadcrumb">
        <li><a href="index.php"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Profilo</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">

      <div class="row">
        <div class="col-md-3">

          <!-- Profile Image -->
          <div class="box box-primary">
            <div class="box-body box-profile">
              <img class="profile-user-img img-responsive img-circle" src="images/profile_images/<?php echo get_img($id); ?>" alt="User profile picture">
              <h3 class="profile-username text-center"><?php echo get_username($id); ?></h3>
              <ul class="list-group list-group-unbordered">
                <li class="list-group-item">
                  <i class="fa fa-circle-o margin-r-5"></i> <b>Partite giocate</b> <a class="pull-right"><?php echo get_win($id)+get_lose($id)+get_tie($id);?></a>
                </li>
                <li class="list-group-item">
                  <i class="fa fa-check text-green margin-r-5"></i> <b>Vittorie</b> <a class="pull-right"><?php echo get_win($id) ?></a>
                </li>
                <li class="list-group-item">
                  <i class="fa fa-minus text-yellow margin-r-5"></i> <b>Pareggi</b> <a class="pull-right"><?php echo get_tie($id) ?></a>
                </li>
                <li class="list-group-item">
                  <i class="fa fa-close text-red margin-r-5"></i> <b>Sconfitte</b> <a class="pull-right"><?php echo get_lose($id) ?></a>
                </li>
              </ul>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
        <div class="col-md-9">
          <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
              <li class="active"><a href="#info" data-toggle="tab">Info</a></li>
              <li><a href="#stats" data-toggle="tab">Statistiche</a></li>
              <?php if(isset($_SESSION['username'])){ if(get_id($_SESSION['username']) == $id){ ?>
              <li><a href="#settings" data-toggle="tab">Modifica</a></li>
              <?php }} ?>
            </ul>
            <div class="tab-content">
              <div class="active tab-pane" id="info">
                <strong><i class="fa fa-envelope margin-r-5"></i> Mail</strong>

              <p class="text-muted">
                <?php echo get_mail($id); ?>
              </p>

              <hr>

              <strong><i class="fa fa-paper-plane margin-r-5"></i> ID Telegram</strong>

              <p class="text-muted">
                <?php echo get_telegram($id); ?>
              </p>

              <hr>

              <strong><i class="fa fa-gamepad margin-r-5"></i> ID PSN</strong>

              <p class="text-muted">
                <?php echo get_id_ps4($id); ?>
              </p>

              <hr>
              </div>
              <!-- /.tab-pane -->
              <div class="tab-pane" id="stats">
                <div class="box-body">
              <!--Donut Chart-->
            </div>
              </div>
              <!-- /.tab-pane -->
              <?php if(isset($_SESSION['username'])){if(get_id($_SESSION['username']) == $id){ ?>
              <div class="tab-pane" id="settings">
                <div class="col-sm-12">
                                  <img style="width: 25%" src="images/profile_images/<?php echo get_img($id); ?>" class="img-thumbnail">
                </div>
                <form action="<?php echo $_SERVER["REQUEST_URI"]; ?>" method="post" enctype="multipart/form-data">
                  <div class="form-group col-sm-12">
                     <div class="col-sm-2">
                      <button type="submit" style="margin-top: 10px" name="img" class="btn btn-primary pull-left">Aggiorna</button>
                    </div>
                     <div style="margin-top: 15px" class="col-sm-8">
                        <input type="file" id="fileToUpload" name="fileToUpload">
                    </div>
                  </div>
              </form>
                <form action="<?php echo $_SERVER["REQUEST_URI"]; ?>" class="form-horizontal" method="post" enctype="multipart/form-data">
                  <div class="form-group">
                    <label for="Username" class="col-sm-2 control-label">Username</label>

                    <div class="col-sm-10">
                      <input type="text" class="form-control" name="username" placeholder="Username">
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="Password" class="col-sm-2 control-label">Password</label>

                    <div class="col-sm-10">
                      <input type="password" class="form-control" name="password" placeholder="Password">
                    </br>
                      <input type="password" class="form-control" name="password2" placeholder="Conferma Password">
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="Email" class="col-sm-2 control-label">Email</label>

                    <div class="col-sm-10">
                      <input type="text" class="form-control" name="mail" placeholder="Email">
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="ID Telegram" class="col-sm-2 control-label">Id Telegram</label>

                    <div class="col-sm-10">
                     <input type="text" class="form-control" name="telegram" placeholder="ID Telegram">
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="ID PSN" class="col-sm-2 control-label">ID PSN</label>

                    <div class="col-sm-10">
                      <input type="text" class="form-control" name="id_ps4" placeholder="ID PSN">
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                      <div class="col-sm-offset-2 col-sm-8">
                      <input type="password" class="form-control" name="check_password" placeholder="Password attuale" required>
                      </div>
                      <button type="submit" class="btn btn-danger">Modifica</button>
                    </div>
                  </div>
                </form>
              </div>
              <?php }} ?>
              <!-- /.tab-pane -->
            </div>
            <!-- /.tab-content -->
          </div>
          <!-- /.nav-tabs-custom -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->

    </section>
    <!-- /.content -->
    
  </div>
  <!-- /.content-wrapper -->
  <?php include ("includes/footer.html"); ?>
</div>
<!-- ./wrapper -->

<!-- jQuery 2.2.3 -->
<script src="plugins/jQuery/jquery-2.2.3.min.js"></script>
<!-- jQuery UI 1.11.4 -->
<script src="https://code.jquery.com/ui/1.11.4/jquery-ui.min.js"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button);
</script>
<!-- Bootstrap 3.3.6 -->
<script src="bootstrap/js/bootstrap.min.js"></script>
<!-- Morris.js charts -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
<script src="plugins/morris/morris.min.js"></script>
<!-- Sparkline -->
<script src="plugins/sparkline/jquery.sparkline.min.js"></script>
<!-- jvectormap -->
<script src="plugins/jvectormap/jquery-jvectormap-1.2.2.min.js"></script>
<script src="plugins/jvectormap/jquery-jvectormap-world-mill-en.js"></script>
<!-- jQuery Knob Chart -->
<script src="plugins/knob/jquery.knob.js"></script>
<!-- daterangepicker -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.11.2/moment.min.js"></script>
<script src="plugins/daterangepicker/daterangepicker.js"></script>
<!-- datepicker -->
<script src="plugins/datepicker/bootstrap-datepicker.js"></script>
<!-- Bootstrap WYSIHTML5 -->
<script src="plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>
<!-- Slimscroll -->
<script src="plugins/slimScroll/jquery.slimscroll.min.js"></script>
<!-- FastClick -->
<script src="plugins/fastclick/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/app.min.js"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="dist/js/pages/dashboard.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="dist/js/demo.js"></script>
</body>
</html>
