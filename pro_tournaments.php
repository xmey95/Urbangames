<!DOCTYPE html>
<html>
<head>
  <?php session_start();
  include ("bin/getters_UI.php");
  include ("bin/getters_ub.php");
  include ("DB/connections.php");
  include ("bin/getters_user.php");
  include ("bin/displays_ub.php");
  include ("urbangames/tournament_functions.php"); ?>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Urbangames | Tornei PRO</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Personal CSS -->
  <link rel="stylesheet" href="custom.css">
  <!-- Bootstrap 3.3.6 -->
  <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
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
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">
  <?php include ("includes/header_sidebar.php"); ?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <section class="content-header">
      <h1>
        Tornei PRO
      </h1>
      <ol class="breadcrumb">
        <li><a href="index.php"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Tornei PRO</li>
      </ol>
    </section>
    <section class="content">
    <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
              <li class="active"><a href="#32" data-toggle="tab">32 squadre</a></li>
              <li><a href="#64" data-toggle="tab">64 squadre</a></li>
              <li><a href="#128" data-toggle="tab">128 squadre</a></li>
            </ul>
            <div class="tab-content">
              <div class="active tab-pane" id="32">
               <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
              <li class="active"><a href="#primo" data-toggle="tab">300 <i class="fa fa-money text-green"></i></a></li>
              <li><a href="#secondo" data-toggle="tab">600 <i class="fa fa-money text-green"></i></a></li>
              <li><a href="#terzo" data-toggle="tab">1000 <i class="fa fa-money text-green"></i></a></li>
            </ul>
            <div class="tab-content">
              <div class="active tab-pane" id="primo">
                  <div class="box">
            <!-- /.box-header -->
            <div class="box-body">
              <table class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>Nome</th>
                  <th>Partecipanti</th>
                  <th>Premio</th>
                  <th>Costo iscrizione</th>
                  <th>Stato</th>
                  <th></th>
                </tr>
                </thead>
                <tbody>
                 <?php display_tournaments_ub(300,32);?>
                </tbody>
              </table>
            </div>
          </div>
              </div>
              <!-- /.tab-pane -->
              <div class="tab-pane" id="secondo">
                 <div class="box">
            <!-- /.box-header -->
            <div class="box-body">
              <table class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>Nome</th>
                  <th>Partecipanti</th>
                  <th>Premio</th>
                  <th>Costo iscrizione</th>
                  <th>Stato</th>
                  <th></th>
                </tr>
                </thead>
                <tbody>
                 <?php display_tournaments_ub(600,32);?>
                </tbody>
              </table>
            </div>
            <!-- /.box-body -->
          </div>
               </div>
              <!-- /.tab-pane -->
              <div class="tab-pane" id="terzo">
                  <div class="box">
            <!-- /.box-header -->
            <div class="box-body">
              <table class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>Nome</th>
                  <th>Partecipanti</th>
                  <th>Premio</th>
                  <th>Costo iscrizione</th>
                  <th>Stato</th>
                  <th></th>
                </tr>
                </thead>
                <tbody>
                 <?php display_tournaments_ub(1000,32);?>
                </tbody>
              </table>
            </div>
            <!-- /.box-body -->
          </div>
              </div>
              <!-- /.tab-pane -->
            </div>
            <!-- /.tab-content -->
          </div>
              </div>
              <!-- /.tab-pane -->
              <div class="tab-pane" id="64">
               <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
              <li class="active"><a href="#primo1" data-toggle="tab">300 <i class="fa fa-money text-green"></i></a></li>
              <li><a href="#secondo1" data-toggle="tab">600 <i class="fa fa-money text-green"></i></a></li>
              <li><a href="#terzo1" data-toggle="tab">1000 <i class="fa fa-money text-green"></i></a></li>
            </ul>
            <div class="tab-content ">
              <div class="active tab-pane" id="primo1">
                  <div class="box">
            <!-- /.box-header -->
            <div class="box-body">
              <table class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>Nome</th>
                  <th>Partecipanti</th>
                  <th>Premio</th>
                  <th>Costo iscrizione</th>
                  <th>Stato</th>
                  <th></th>
                </tr>
                </thead>
                <tbody>
                 <?php display_tournaments_ub(300,64);?>
                </tbody>
              </table>
            </div>
          </div>
              </div>
              <!-- /.tab-pane -->
              <div class="tab-pane" id="secondo1">
                 <div class="box">
            <!-- /.box-header -->
            <div class="box-body">
              <table class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>Nome</th>
                  <th>Partecipanti</th>
                  <th>Premio</th>
                  <th>Costo iscrizione</th>
                  <th>Stato</th>
                  <th></th>
                </tr>
                </thead>
                <tbody>
                 <?php display_tournaments_ub(600,64);?>
                </tbody>
              </table>
            </div>
            <!-- /.box-body -->
          </div>
               </div>
              <!-- /.tab-pane -->
              <div class="tab-pane" id="terzo1">
                  <div class="box">
            <!-- /.box-header -->
            <div class="box-body">
              <table class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>Nome</th>
                  <th>Partecipanti</th>
                  <th>Premio</th>
                  <th>Costo iscrizione</th>
                  <th>Stato</th>
                  <th></th>
                </tr>
                </thead>
                <tbody>
                 <?php display_tournaments_ub(1000,64);?>
                </tbody>
              </table>
            </div>
            <!-- /.box-body -->
          </div>
              </div>
              <!-- /.tab-pane -->
            </div>
            <!-- /.tab-content -->
          </div>
              </div>
              <!-- /.tab-pane -->
              <div class="tab-pane" id="128">
               <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
              <li class="active"><a href="#primo2" data-toggle="tab">300 <i class="fa fa-money text-green"></i></a></li>
              <li><a href="#secondo2" data-toggle="tab">600 <i class="fa fa-money text-green"></i></a></li>
              <li><a href="#terzo2" data-toggle="tab">1000 <i class="fa fa-money text-green"></i></a></li>
            </ul>
            <div class="tab-content">
              <div class="active tab-pane" id="primo2">
                  <div class="box">
            <!-- /.box-header -->
            <div class="box-body">
              <table class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>Nome</th>
                  <th>Partecipanti</th>
                  <th>Premio</th>
                  <th>Costo iscrizione</th>
                  <th>Stato</th>
                  <th></th>
                </tr>
                </thead>
                <tbody>
                 <?php display_tournaments_ub(300,128);?>
                </tbody>
              </table>
            </div>
          </div>
              </div>
              <!-- /.tab-pane -->
              <div class="tab-pane" id="secondo2">
                 <div class="box">
            <!-- /.box-header -->
            <div class="box-body">
              <table class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>Nome</th>
                  <th>Partecipanti</th>
                  <th>Premio</th>
                  <th>Costo iscrizione</th>
                  <th>Stato</th>
                  <th></th>
                </tr>
                </thead>
                <tbody>
                 <?php display_tournaments_ub(600,128);?>
                </tbody>
              </table>
            </div>
            <!-- /.box-body -->
          </div>
               </div>
              <!-- /.tab-pane -->
              <div class="tab-pane" id="terzo2">
                  <div class="box">
            <!-- /.box-header -->
            <div class="box-body">
              <table class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>Nome</th>
                  <th>Partecipanti</th>
                  <th>Premio</th>
                  <th>Costo iscrizione</th>
                  <th>Stato</th>
                  <th></th>
                </tr>
                </thead>
                <tbody>
                 <?php display_tournaments_ub(1000,128);?>
                </tbody>
              </table>
            </div>
            <!-- /.box-body -->
          </div>
              </div>
              <!-- /.tab-pane -->
            </div>
            <!-- /.tab-content -->
          </div>
              </div>
              <!-- /.tab-pane -->
            </div>
            <!-- /.tab-content -->
          </div>
    </section>
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
