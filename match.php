<!DOCTYPE html>
<html>
<head>
  <?php session_start();
  $id=htmlspecialchars($_GET['id']);
  include ("bin/getters_UI.php");
  include ("bin/getters_ub.php");
  include ("bin/getters_user.php"); 
  include ("bin/displays_ub.php"); 
  include ("DB/connections.php");
  include ("login/register_functions.php");
  include ("bin/refresh_user.php");
    include ("urbangames/tournament_functions.php");
  $tor=get_tournament_match_ub($id);
  $id_usr1=get_match_id_usr1($id);
  $id_usr2=get_match_id_usr2($id);
  if(isset($_POST['score'])){
    insert_score($id, $_POST['g1'], $_POST['g2'], get_id($_SESSION['username']));  
  }
  ?>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Urbangames | Match</title>
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
        <?php echo get_username($id_usr1). ' - ' .get_username($id_usr2); ?>
      </h1>
      <ol class="breadcrumb">
        <li><a href="index.php"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Match</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
      <div class="col-md-4">

          <!-- Profile Image -->
          <div class="box box-primary">
            <div class="box-body box-profile">
              <img class="profile-user-img img-responsive img-circle" src="images/profile_images/<?php echo get_img($id_usr1); ?>" alt="User profile picture">
              <h3 class="profile-username text-center"><?php echo get_username($id_usr1); ?></h3>
              <ul class="list-group list-group-unbordered">
                <li class="list-group-item">
                  <i class="fa fa-circle-o margin-r-5"></i> <b>Partite giocate</b> <a class="pull-right"><?php echo get_win($id_usr1)+get_lose($id_usr1)+get_tie($id_usr1);?></a>
                </li>
                <li class="list-group-item">
                  <i class="fa fa-check text-green margin-r-5"></i> <b>Vittorie</b> <a class="pull-right"><?php echo get_win($id_usr1) ?></a>
                </li>
                <li class="list-group-item">
                  <i class="fa fa-minus text-yellow margin-r-5"></i> <b>Pareggi</b> <a class="pull-right"><?php echo get_tie($id_usr1) ?></a>
                </li>
                <li class="list-group-item">
                  <i class="fa fa-close text-red margin-r-5"></i> <b>Sconfitte</b> <a class="pull-right"><?php echo get_lose($id_usr1) ?></a>
                </li>
              </ul>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>

        <div class="col-md-4">

          <!-- Profile Image -->
          <div class="box box-primary">
            <div class="box-body">
              <div class="box-header with-border">
              <h3 class="text-center"><?php echo get_tournament_name_ub(get_tournament_match_ub($id)); ?></h3>
              <h4 class="text-center"><?php if(get_group_cat(get_match_group($id)) == 0){
                echo ("Girone ");
              }
                echo get_group_name(get_match_group($id)); ?></h4>
            </div>
              <?php
              switch(get_match_state($id)){
                case 0:
                if(isset($_SESSION['username'])){
                if(get_id($_SESSION['username']) == $id_usr1){
                  ?>
                    <form action="<?php echo $_SERVER["REQUEST_URI"]; ?>" method="post">
                  <div class="form-group">
                    <div class="col-sm-2">
                    </div>
                     <div class="col-sm-3">
                      <input type="text" class="form-control" name="g1" placeholder="Goal Casa" required>
                    </div>
                    <div class="col-sm-2 text-center">
                      <h1 style="margin-top: 0px"> - </h1>
                    </div>
                    <div class="col-sm-3">
                      <input type="text" class="form-control" name="g2" placeholder="Goal Ospite" required>
                    </div>
                    <div class="col-sm-2">
                    </div>
                    <div class="row">
                      <div class="col-sm-12 text-center">
                      <button type="submit" style="margin-top: 10px" name="score" class="btn btn-primary">Inserisci</button>
                    </div>
                    </div>
                  </div>
              </form>
                  <?php
                }
                else{
                  ?>
                  <div class="text-center" style="font-size: 120px"><b>Vs</b></div>
                  <?php
                }
                }
                else{
                  ?>
                  <div class="text-center" style="font-size: 120px"><b>Vs</b></div>
                  <?php
                }
                break;
                case 1:
                ?>
                <div class="text-center"><b style="font-size: 120px"><?php echo get_match_g1($id). ' - ' .get_match_g2($id); ?></b>
            </div>
            <h3 class="text-center">(da confermare)</h3>
            <?php
            if(isset($_SESSION['username'])){
              if(get_admin(get_id($_SESSION['username'])) || get_id($_SESSION['username'])== $id_usr2){
                if(get_group_cat(get_match_group($id))== 0){
                  ?>
                  <a href="confirm_score.php?id=<?php echo $id; ?>"><button class="btn btn-lg btn-success">Accetta</button></a>
                  <?php
                }
                else{
                  ?>
                  <a href="confirm_score_final_phase.php?id=<?php echo $id; ?>"><button class="btn btn-lg btn-success">Accetta</button></a>
                  <?php
                }
                ?>
            <a href="refuse_score.php?id=<?php echo $id; ?>"><button class="btn btn-lg btn-danger pull-right">Rifiuta</button></a>
                <?php
              }
              if(get_id($_SESSION['username']) == $id_usr1){
                ?>
                <a href="refuse_score.php?id=<?php echo $id; ?>"><button class="btn btn-lg btn-danger">Cancella</button></a>
                <?php
              }
            }
                break;
                case 2:
                ?>
                <div class="text-center"><h1>Risultato finale</h1></br><p style="font-size: 120px"><b><?php echo get_match_g1($id). ' - ' .get_match_g2($id); ?></b></p></div>
                <?php
                if(isset($_SESSION['username'])){
                if(get_admin(get_id($_SESSION['username'])) == 1){
                ?>
                <a href="cancel_score.php?id=<?php echo $id; ?>"><button class="btn btn-lg btn-danger">Elimina</button></a>
                <?php
              }
            }
                break;
                default:
                break;
              }
              ?>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <div class="col-md-4">

          <!-- Profile Image -->
          <div class="box box-primary">
            <div class="box-body box-profile">
              <img class="profile-user-img img-responsive img-circle" src="images/profile_images/<?php echo get_img($id_usr2); ?>" alt="User profile picture">
              <h3 class="profile-username text-center"><?php echo get_username($id_usr2); ?></h3>
              <ul class="list-group list-group-unbordered">
                <li class="list-group-item">
                  <i class="fa fa-circle-o margin-r-5"></i> <b>Partite giocate</b> <a class="pull-right"><?php echo get_win($id_usr2)+get_lose($id_usr2)+get_tie($id_usr2);?></a>
                </li>
                <li class="list-group-item">
                  <i class="fa fa-check text-green margin-r-5"></i> <b>Vittorie</b> <a class="pull-right"><?php echo get_win($id_usr2) ?></a>
                </li>
                <li class="list-group-item">
                  <i class="fa fa-minus text-yellow margin-r-5"></i> <b>Pareggi</b> <a class="pull-right"><?php echo get_tie($id_usr2) ?></a>
                </li>
                <li class="list-group-item">
                  <i class="fa fa-close text-red margin-r-5"></i> <b>Sconfitte</b> <a class="pull-right"><?php echo get_lose($id_usr2) ?></a>
                </li>
              </ul>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
      </div>
      <div class="row">
        <?php if(get_group_cat(get_match_group($id)) == 0){
          ?>
        <div class="col-md-4">

          <!-- Profile Image -->
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">CLassifica girone</h3>
            </div>
            <div class="box-body">
              <table class="table table-bordered table-hover">
                <thead>
                <tr>
                  <th>#</th>
                  <th>Utente</th>
                  <th>Pti</th>
                </tr>
                </thead>
                <tbody>
                <?php     display_small_tables_ub(get_match_group($id)); ?>
                </tbody>
              </table>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <?php
      }
      ?>
        <div class="col-md-<?php
        if(get_group_cat(get_match_group($id)) == 0)
          {
            echo ("8");
          }
          else{
            echo ("12");
          }
          ?>">

          <!-- Profile Image -->
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Incontri turno</h3>
            </div>
            <div class="box-body">
             <table class="table table-bordered table-hover">
                <?php     display_matches_ub(get_match_group($id)); ?>
              </table>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
      </div>
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
