<!DOCTYPE html>
<html>
<head>
  <?php session_start();
  $id=htmlspecialchars($_GET['id']);
  include ("bin/getters_UI.php");
  include ("bin/getters_ub.php");
  include ("bin/getters_user.php");
  include ("bin/setters_ub.php");  
  include ("bin/displays_ub.php"); 
  include ("DB/connections.php");
  include ("login/register_functions.php");
  include ("bin/refresh_user.php");
  include ("urbangames/tournament_functions.php");
  if(isset($_POST['unsubscribe'])){
    remove_subscription(get_id($_SESSION['username']), $id);
    header ('Location: redirect.php');
  }
  if(isset($_POST['subscribe'])){
    if(get_tournament_gt($id) == 0){
    subscribe(get_id($_SESSION['username']), $id);
    header ('Location: redirect.php');
  }
  else{
    subscribe_gt(get_id($_SESSION['username']), $id, $_POST['code']);
    header ('Location: redirect.php');
  }
  }
  ?>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Urbangames | <?php echo get_tournament_name_ub($id);?></title>
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
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">
  <?php include ("includes/header_sidebar.php"); ?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <section class="content-header">
      <h1>
        <?php echo get_tournament_name_ub($id);?>
      </h1>
      <ol class="breadcrumb">
        <li><a href="index.php"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="all_tournaments.php"> Tornei</a></li>
        <li class="active"><?php echo get_tournament_name_ub($id);?></li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">

      <div class="row">
        <div class="col-md-5">

          <!-- Profile Image -->
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Dati torneo</h3>
            </div>
            <div class="box-body box-profile">
              <img class="profile-user-img img-responsive img-circle" src="images/logos/tournament.png" alt="User profile picture">

              <h3 class="profile-username text-center"><?php echo get_tournament_name_ub($id);?></h3>

              <ul class="list-group list-group-unbordered">
                <li class="list-group-item">
                  <i class="fa fa-users margin-r-5 text-green"></i> <b>Partecipanti</b> <a class="pull-right"><?php echo get_tournament_players($id);?></a>
                </li>
                <li class="list-group-item">
                  <i class="fa fa-trophy text-yellow margin-r-5"></i> <b>Premio</b> <a class="pull-right"><?php echo get_tournament_prize($id); ?></a>
                </li>
                <!--<li class="list-group-item">
                  <i class="fa fa-database text-red margin-r-5"></i> <b>Costo iscrizione</b> <a class="pull-right"><?php if(get_tournament_credits($id)==0){?><span class="label label-success">GRATIS</span><?php }
                  else{
                    echo get_tournament_credits($id)." "; ?><i class="fa fa-money text-green"></i><?php } ?></a>
                </li>-->
                <li class="list-group-item">
                  <i class="fa fa-exchange text-blue margin-r-5"></i> <b>Stato</b> <a class="pull-right"><?php switch(get_tournament_state($id)){
             case 0:
                 ?>
                 <span class="label label-warning">Iscrizioni</span><?php
                 break;
             case 1:
                 ?>
                 <span class="label label-danger">In corso</span><?php
                 break;
             case 2:
                 ?>
                 <span class="label label-primary">Concluso</span><?php
                 break;
             default:break;
         } ?></a>
                </li>
                <?php
                if(isset($_SESSION['username'])&& get_tournament_state($id)==0){
                    if(check_subscripted(get_id($_SESSION['username']), $id)){ ?>
                <li class="list-group-item">
                  <i class="fa fa-check text-green margin-r-5"></i> Sei iscritto <form action="<?php echo $_SERVER["REQUEST_URI"]; ?>" method="post" class="pull-right"><button type="submit" name="unsubscribe" class="btn btn-xs btn-block btn-danger">Annulla Iscrizione</button></form>
                </li>
                <?php
              }
              else{
                if(get_tournament_gt($id)==0){
                  ?>
                <li class="list-group-item">
                  <i class="fa fa-close text-red margin-r-5"></i> Non sei iscritto <form action="<?php echo $_SERVER["REQUEST_URI"]; ?>" method="post" class="pull-right"><button type="submit" name="subscribe" class="btn btn-xs btn-block btn-success">Iscriviti</button></form>
                </li>
                <?php
              }
                else{
                  ?>
                <li class="list-group-item">
                  <i class="fa fa-close text-red margin-r-5"></i> Non sei iscritto 
                </li>
                <li class="list-group-item">
                  <form style="width: 100%" action="<?php echo $_SERVER["REQUEST_URI"]; ?>" method="post" class="pull-right">
                  <input type="text" class="form-control pull-left" name="code" placeholder="Codice d'iscrizione" required>
                </br>
                  <button style="margin-top: 7px; width: 25%" type="submit" name="subscribe" class="btn btn-block btn-success pull-right">Iscriviti</button>
                </form>
                </li>
                <?php
              }
              }} ?>
              </ul>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
          <?php 
          if(get_tournament_sponsor($id)!=null || get_tournament_gt($id) == 1){
          $sponsor=get_tournament_sponsor($id); ?>
                   <div class="box box-primary">
                    <div class="box-header with-border">
              <h3 class="box-title">Dati sponsor</h3>
            </div>
            <div class="box-body">
              <?php
              if(get_tournament_gt($id) == 1){
                ?>
                <img style="width: 100%" src="images/sponsor_images/gamestime.png ?>" class="img-thumbnail">

              <h1 class="text-center">Gamestime</h1>
              <?php
              }
              else{
                ?>
              <img style="width: 100%" src="images/sponsor_images/<?php echo get_sponsor_img(get_tournament_sponsor($id)); ?>" class="img-thumbnail">

              <h1 class="text-center"><?php echo get_sponsor_name($sponsor); ?></h1>
              <?php
              }
              if(!(get_sponsor_mail($sponsor) == null && get_sponsor_facebook($sponsor) == null && get_sponsor_site($sponsor) == null)){
              ?>
              <ul class="list-group list-group-unbordered">
                <?php
              if(get_sponsor_mail($sponsor) != null)
              {
                ?>
                <li class="list-group-item">
                  <i class="fa fa-envelope margin-r-5"></i> <b>Mail</b> <a class="pull-right"><?php echo get_sponsor_mail($sponsor);?></a>
                </li>
                <?php
              }
              if(get_sponsor_facebook($sponsor) != null)
              {
                ?>
                <li class="list-group-item">
                  <i class="fa fa-facebook text-blue margin-r-5"></i> <b>Facebook</b> <a href="<?php echo get_sponsor_facebook($sponsor); ?>" rel="nofollow"><button type="button" class="btn btn-xs btn-primary pull-right">Vai</button></a>
                </li>
                <?php
              }
              if(get_sponsor_site($sponsor) != null)
              {
                ?>
                <li class="list-group-item">
                  <i class="fa fa-globe margin-r-5"></i> <b>Web site</b>
            <a href="<?php echo get_sponsor_site($sponsor); ?>" rel="nofollow"><button type="button" class="btn btn-xs btn-danger pull-right">Vai</button></a>
                </li>
                <?php
              }
            }
              ?>
              </ul>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
          <?php
        }
        ?>
        </div>
        <!-- /.col -->
        <div class="col-md-7">
          <?php
          if(get_tournament_state($id)==0){
          include ("includes/subscripted.php");
          }
          if(check_groups_end($id)){
          include ("includes/tab.php");
          }
          if(get_tournament_players($id) != 32 && get_tournament_state($id) != 0){
          include ("includes/groups.php");
        }
        ?>
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
