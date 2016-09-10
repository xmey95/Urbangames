<?php

function display_matches_ub($id_gir){
    $db=  connect_urbangames();
$id_gir=(int)$id_gir;
$db->query("LOCK TABLES matches{read}");
    $query=$db->prepare("SELECT * FROM matches WHERE id_gir = ?");
    $query->execute(array($id_gir));
    while($row=$query->fetch()){
        ?>
         <tr>
          <td style="width: 40%">
              <a href="profile.php?id=<?php echo $row['id_usr1']; ?>">
                  <div class="user-panel">
            <div style="min-height: 30px;" class="pull-right image">
             <img style="height: 100%;" src="images/profile_images/<?php echo get_img($row['id_usr1']); ?>" class="img-circle" alt="User Image">
            </div>
            <div class="pull-right scritta">
                <b><?php echo get_username($row['id_usr1']); ?></b>
            </div>
                  </div></a>
          </td>
          <td style="width: 10%">
              <?php
              if(get_match_state($row['id']) < 2){ ?>
              <button type="button" class="btn btn-block btn-primary button-ris">Vs</button>
              <?php }
              else{
                  ?>
              <button type="button" class="btn btn-block btn-primary button-ris"><?php echo get_match_g1($row['id'])."-".get_match_g2($row['id']); ?></button>
              <?php
              }
              ?>
          </td>
            <td style="width: 40%">
                <a href="profile.php?id=<?php echo $row['id_usr2']; ?>">
                <div class="user-panel pull-left">
            <div style="min-height: 30px;" class="pull-left image">
             <img style="height: 100%;" src="images/profile_images/<?php echo get_img($row['id_usr2']); ?>" class="img-circle" alt="User Image">
            </div>
            <div class="pull-left scritta">
             <b><?php echo get_username($row['id_usr2']); ?></b>
            </div>
                </div></a>
            </td>
            <td style="width: 10%"><a href="match.php?id=<?php echo $row['id']; ?>"><button type="button" class="btn btn-block btn-danger button-ris">Vai</button></a></td>
         </tr>
        <?php
    }
    $db->query("UNLOCK TABLES");
}

function display_tournaments_ub($prize, $part){
    $db= connect_urbangames();
    $prize=(int)$prize;
$db->query("LOCK TABLES torneo{read}");
$query=$db->prepare("SELECT * FROM torneo WHERE credits = ? AND players = ?");
    $query->execute(array($prize, $part));
    while($row=$query->fetch()){
        if($row['GT']!=1){
        ?>
        <tr>
            <td><?php if(isset($_SESSION['username'])){if(check_subscripted(get_id($_SESSION['username']), $row['id'])){?><i class="fa fa-check-circle text-green"></i><?php }} ?><b> <?php echo $row['name'];?></b></td>
         <td class="hidden-xs"><?php echo $row['players'];?></td>
         <td><?php echo $row['prize'];?></td>
         <?php
         /*if($row['credits']==0){
             ?><td><span class="label label-success">GRATIS</span></td><?php
         }
         else{
             ?><td><?php echo $row['credits']." ";?><i class="fa fa-money text-green"></i></td><?php
         }*/
         switch($row['state']){
             case 0:
                 ?>
                 <td><span class="label label-warning">Iscrizioni</span></td><?php
                 break;
             case 1:
                 ?>
                 <td><span class="label label-danger">In corso</span></td><?php
                 break;
             case 2:
                 ?>
                 <td><span class="label label-primary">Concluso</span></td><?php
                 break;
             default:break;
         }
?>
                 <td><a href="tournament.php?id=<?php echo $row['id']; ?>"><button type="button" class="btn btn-block btn-danger btn-sm">Vai</button></a></td>
        </tr>
        <?php
        }
    }
    $db->query("UNLOCK TABLES");
}

function display_tournaments_gt(){
    $db= connect_urbangames();
$db->query("LOCK TABLES torneo{read}");
$query=$db->query("SELECT * FROM torneo WHERE GT = 1");
    while($row=$query->fetch()){
        ?>
        <tr>
            <td><?php if(isset($_SESSION['username'])){if(check_subscripted(get_id($_SESSION['username']), $row['id'])){?><i class="fa fa-check-circle text-green"></i><?php }} ?><b> <?php echo $row['name'];?></b></td>
         <td class="hidden-xs"><?php echo $row['players'];?></td>
         <td><?php echo $row['prize'];?></td>
         <?php
         switch($row['state']){
             case 0:
                 ?>
                 <td><span class="label label-warning">Iscrizioni</span></td><?php
                 break;
             case 1:
                 ?>
                 <td><span class="label label-danger">In corso</span></td><?php
                 break;
             case 2:
                 ?>
                 <td><span class="label label-primary">Concluso</span></td><?php
                 break;
             default:break;
         }
?>
                 <td><a href="tournament.php?id=<?php echo $row['id']; ?>"><button type="button" class="btn btn-block btn-danger btn-sm">Vai</button></a></td>
        </tr>
        <?php
    }
    $db->query("UNLOCK TABLES");
}


function display_mymatches_ub($id){
    $db= connect_urbangames();
$id=(int)$id;
$db->query("LOCK TABLES matches{read}");
$query=$db->prepare("SELECT * FROM matches WHERE id_usr1= ? OR id_usr2 = ?");
    $query->execute(array($id, $id));
    while($row=$query->fetch()){
        echo get_tournament_name_ub(get_tournament_match_ub($row['id']));
        echo get_username($row['id_usr1']);
        echo get_username($row['id_usr2']);
        echo get_telegram($row['id_usr1']);
        echo get_id_ps4($row['id_usr2']);
        echo get_id_ps4($row['id_usr1']);
        echo get_telegram($row['id_usr2']);
        echo get_img($row['id_usr1']);
        echo get_img($row['id_usr2']);
        echo $row['g1'];
        echo $row['g2'];
    }
    $db->query("UNLOCK TABLES");
}

function display_mytournaments_ub($id){
    $db= connect_urbangames();
    $id=(int)$id;
$db->query("LOCK TABLES iscrizione{read}");
$query=$db->prepare("SELECT * FROM iscrizione WHERE id_usr = ?");
    $query->execute(array($id));
    while($row=$query->fetch()){
        $riga=$row['id_tor'];
        $torneo=$db->prepare("SELECT * FROM torneo WHERE id = ?");
        $torneo->execute(array($riga));
        while($row2=$torneo->fetch()){
        ?>
        <tr>
            <td><b><?php echo $row2['name'];?></b></td>
         <td class="hidden-xs"><?php echo $row2['players'];?></td>
         <td><?php echo $row2['prize'];?></td>
         <?php
         /*if($row2['credits']==0){
             ?><td><span class="label label-success">GRATIS</span></td><?php
         }
         else{
             ?><td><?php echo $row2['credits']." ";?><i class="fa fa-money text-green"></i></td><?php
         }*/
         switch($row2['state']){
             case 0:
                 ?>
                 <td><span class="label label-warning">Iscrizioni</span></td><?php
                 break;
             case 1:
                 ?>
                 <td><span class="label label-danger">In corso</span></td><?php
                 break;
             case 2:
                 ?>
                 <td><span class="label label-primary">Concluso</span></td><?php
                 break;
             default:break;
         }
?>
                 <td><a href="tournament.php?id=<?php echo $row2['id']; ?>"><button type="button" class="btn btn-block btn-danger btn-sm">Vai</button></a></td>
        </tr>
        <?php
    }
    }
    $db->query("UNLOCK TABLES");
}

function display_groups_ub($id_torneo){
    $db= connect_urbangames();
$id_torneo=(int)$id_torneo;
$db->query("LOCK TABLES gironi{read}");
$query=$db->prepare("SELECT * FROM gironi WHERE id_tor = ? AND cat = 0");
$query->execute(array($id_torneo));
$i=0;
while($row=$query->fetch()){
    ?>
        <div class="<?php if($i==0){ ?>active <?php } ?>tab-pane" id="<?php echo $i; ?>">
               <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
              <li class="active"><a href="#matches<?php echo $i; ?>" data-toggle="tab">Incontri</a></li>
              <li><a href="#classifica<?php echo $i; ?>" data-toggle="tab">Classifica</a></li>
            </ul>
            <div class="tab-content">
              <div class="active tab-pane" id="matches<?php echo $i; ?>">
                            <div class="box">
            <div class="box-body no-padding">
              <table class="table table-condensed">
                <?php     display_matches_ub($row['id']); ?>
              </table>
            </div>
            <!-- /.box-body -->
          </div>
              </div>
              <!-- /.tab-pane -->
              <div class="tab-pane" id="classifica<?php echo $i; ?>">
                  <div class="box">
            <div class="box-body">
              <table class="table table-bordered table-hover">
                <thead>
                <tr>
                  <th>#</th>
                  <th>Utente</th>
                  <th>G</th>
                  <th>V</th>
                  <th>P</th>
                  <th>S</th>
                  <th>GF</th>
                  <th>GS</th>
                  <th>DR</th>
                  <th>Pti</th>
                </tr>
                </thead>
                <tbody>
                <?php     display_tables_ub($row['id']); ?>
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
   <?php
   $i++;
}
$db->query("UNLOCK TABLES");
}

function display_tables_ub($id_gir){
    $db=  connect_urbangames();
    $id_gir=(int)$id_gir;
$db->query("LOCK TABLES classifica{read}");
    $query=$db->prepare("SELECT * FROM classifica WHERE id_gir = ? ORDER BY pnt DESC, gd DESC, gm DESC");
    $query->execute(array($id_gir));
    $i=1;
    while($row=$query->fetch()){
       ?>
         <tr<?php if($i < 3){ ?> style="background-color: rgba(0, 166, 90, 0.3)"<?php } ?>>
                  <td><?php echo $i; ?></td>
                  <td><a href="profile.php?id=<?php echo $row['id_usr']; ?>">
                  <div class="user-panel">
            <div style="min-height: 30px;" class="pull-left image">
             <img style="height: 100%;" src="images/profile_images/<?php echo get_img($row['id_usr']); ?>" class="img-circle" alt="User Image">
            </div>
            <div class="pull-left scritta">
                <b><?php echo get_username($row['id_usr']); ?></b>
            </div>
                  </div></a></td>
                  <td><?php echo $row['win']+$row['tie']+$row['lose']; ?></td>
                  <td><?php echo $row['win']; ?></td>
                  <td><?php echo $row['tie']; ?></td>
                  <td><?php echo $row['lose']; ?></td>
                  <td><?php echo $row['gm']; ?></td>
                  <td><?php echo $row['gs']; ?></td>
                  <td><?php echo $row['gd']; ?></td>
                  <td><b><?php echo $row['pnt']; ?></b></td>
                </tr>
          
       <?php
       $i++;
    }
    $db->query("UNLOCK TABLES");
}

function display_small_tables_ub($id_gir){
    $db=  connect_urbangames();
    $id_gir=(int)$id_gir;
$db->query("LOCK TABLES classifica{read}");
    $query=$db->prepare("SELECT * FROM classifica WHERE id_gir = ? ORDER BY pnt DESC, gd DESC, gm DESC");
    $query->execute(array($id_gir));
    $i=1;
    while($row=$query->fetch()){
        if($i >= 5){
            break;
        }
       ?>
         <tr<?php if($i < 3){ ?> style="background-color: rgba(0, 166, 90, 0.3)"<?php } ?>>
                  <td><?php echo $i; ?></td>
                  <td><a href="profile.php?id=<?php echo $row['id_usr']; ?>">
                  <div class="user-panel">
            <div style="min-height: 30px;" class="pull-left image">
             <img style="height: 100%;" src="images/profile_images/<?php echo get_img($row['id_usr']); ?>" class="img-circle" alt="User Image">
            </div>
            <div class="pull-left scritta">
                <b><?php echo get_username($row['id_usr']); ?></b>
            </div>
                  </div></a></td>
                  <td><b><?php echo $row['pnt']; ?></b></td>
                </tr>
          
       <?php
       $i++;
    }
    $db->query("UNLOCK TABLES");
}

function display_subscripted_ub($id_tor){
    $db=  connect_urbangames();
    $id_tor=(int)$id_tor;
$db->query("LOCK TABLES iscrizione{read}");
    $query=$db->prepare("SELECT * FROM iscrizione WHERE id_tor = ?");
    $query->execute(array($id_tor));
    $i=1;
    while($row=$query->fetch()){
       ?>
         <tr>
                  <td><?php echo $i; ?></td>
                  <td><a href="profile.php?id=<?php echo $row['id_usr']; ?>">
                  <div class="user-panel">
            <div style="min-height: 30px;" class="pull-left image">
             <img style="height: 100%;" src="images/profile_images/<?php echo get_img($row['id_usr']); ?>" class="img-circle" alt="User Image">
            </div>
            <div class="scritta">
                <b class="pull-left"><?php echo get_username($row['id_usr']); ?></b>
            </div>
                  </div></a></td>
                  <td><b class="pull-right"><?php echo get_trophy($row['id_usr']); ?></b></td>
                </tr>
          
       <?php
       $i++;
    }
    $db->query("UNLOCK TABLES");
}

function display_red_alert($message){
    ?>
<div class="modal-dialog red_alert centrato">
<div class="modal-body red_alert">
    <b style="color: white; font-size: 25px" ><i class="fa fa-exclamation-circle margin-r-5 text-white"></i><?php echo $message; ?></b>
    <hr style="color: white">
    <a href="redirect.php" ><button class="pull-right btn btn-lg">OK</button></a>
</div>
<!-- dialog buttons -->
</div>

    <?php
}

function display_yellow_alert($message){
    ?>
<div class="modal-dialog yellow_alert centrato">
<div class="modal-body yellow_alert">
    <b style="color: white; font-size: 25px" ><i class="fa fa-warning margin-r-5 text-white"></i><?php echo $message; ?></b>
    <hr style="color: white">
    <a href="redirect.php" ><button class="pull-right btn btn-lg">OK</button></a>
</div>
<!-- dialog buttons -->
</div>

    <?php
}

function display_green_alert($message){
    ?>
<div class="modal-dialog green_alert centrato">
<div class="modal-body green_alert">
    <b style="color: white; font-size: 25px" ><i class="fa fa-check margin-r-5 text-white"></i><?php echo $message; ?></b>
    <hr style="color: white">
    <a href="redirect.php" ><button class="pull-right btn btn-lg">OK</button></a>
</div>
<!-- dialog buttons -->
</div>

    <?php
}


/*
display_tab(id_tor);
-display_week();
-display_day();
-display_annual();
-display_cash();
-display_mytransations(id);*/
?>