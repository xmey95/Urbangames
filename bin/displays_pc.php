<?php
include('DB/connections.php');
include('bin/getters_user.php');
include('bin/getters_pc.php');

function display_matches_pc($id_gir){
    $db=  connect_proclub();
    if(gettype($id_gir)!='integer'){
    echo("Errore Gettype id_gir");
    return;
}
    $db->query("LOCK TABLES matches{read}");
    $query=$db->prepare("SELECT * FROM matches WHERE id_gir = ?");
    $query->execute(array($id_gir));
    while($row=$query->fetch()){
        echo get_team_name($row['id_team1']);
        echo get_team_name($row['id_team2']);
        echo get_team_image($row['id_team1']);
        echo get_team_image($row['id_team2']);
        echo get_telegram(get_cap($row['id_team1']));
        echo get_telegram(get_cap($row['id_team2']));
        
    }
    $db->query("UNLOCK TABLES");
}

function display_tournaments_pc(){
    $db= connect_proclub();
    $db->query("LOCK TABLES torneo{read}");
    $query=$db->prepare("SELECT * FROM torneo");
    $query->execute();
    while($row=$query->fetch()){
        echo $row['name'];
        echo $row['state'];
    }
    $db->query("UNLOCK TABLES");
}

function display_mymatches_pc($team){
    $db= connect_proclub();
    if(gettype($team)!='integer'){
    echo("Errore Gettype mymatches");
    return;
}
  $db->query("LOCK TABLES matches{read}");
$query=$db->prepare("SELECT * FROM matches WHERE id_team1= ? OR id_team2 = ?");
    $query->execute(array($team, $team));
    while($row=$query->fetch()){
        echo get_tournament_name_pc(get_tournament_match_pc($row['id']));
        echo get_team_name($row['id_team1']);
        echo get_team_name($row['id_team2']);
        echo get_telegram(get_cap($row['id_team1']));
        echo get_id_ps4(get_cap($row['id_team1']));
        echo get_id_ps4(get_cap($row['id_team2']));
        echo get_telegram(get_cap($row['id_team2']));
        echo get_team_image($row['id_team1']);
        echo get_team_image($row['id_team2']);
        echo $row['g1'];
        echo $row['g2'];
    }
    $db->query("UNLOCK TABLES");
}

function display_mytournaments_pc($team){
    $db= connect_proclub();
    if(gettype($team)!='integer'){
    echo("Errore Gettype mytournaments");
    return;
}
$db->query("LOCK TABLES torneo{read}");
$query=$db->prepare("SELECT * FROM iscrizione WHERE id_team = ?");
    $query->execute(array($team));
    while($row=$query->fetch()){
        $riga=$row['id_tor'];
        $torneo=$db->prepare("SELECT * FROM torneo WHERE id = ?");
        $torneo->execute(array($riga));
        $row2=$torneo->fetch();
        echo $row2['name'];
        echo $row2['state'];
    }
    $db->query("UNLOCK TABLES");
}

function display_teams(){
    $db=  connect_proclub();
    $db->query("LOCK TABLES teams{read}");
    $query=$db->prepare("SELECT * FROM teams");
    $query->execute();
    while($row=$query->fetch()){
        echo $row['name'];
        echo $row['image'];
        echo get_username($row['captain']);
    }
    $db->query("UNLOCK TABLES");
}

function display_markers($id_tor){
    $db=  connect_proclub();
    if(gettype($id_tor)!='integer'){
    echo("Errore Gettype markers");
    return;
}
    $db->query("LOCK TABLES markers{read}");
    $query=$db->prepare("SELECT * FROM markers WHERE id_tor = ?");
    $query->execute(array($id_tor));
    while($row=$query->fetch()){
        echo get_username($row['id_usr']);
        echo $row['goals'];
        echo get_team_image(get_user_team($row['id_usr']));
    }
        $db->query("UNLOCK TABLES");

}

function display_tables_pc($id_gir){
    $db=  connect_proclub();
     if(gettype($id_gir)!='integer'){
    echo("Errore Gettype tables");
    return;
}
    $db->query("LOCK TABLES classifica{read}");
    $query=$db->prepare("SELECT * FROM classifica WHERE id_gir = ? ORDER BY pnt DESC, gd DESC, gm DESC");
    $query->execute(array($id_gir));
    while($row=$query->fetch()){
        echo get_team_name($row['id_team']);
        echo get_team_image($row['id_team']);
        echo $row['pnt'];
        echo $row['win'];
        echo $row['lose'];
        echo $row['tie'];
        echo $row['gm'];
        echo $row['gs'];
        echo $row['gd'];
    }
            $db->query("UNLOCK TABLES");

}

function display_members($id_team){
    $db=  connect_proclub();
     if(gettype($id_team)!='integer'){
    echo("Errore Gettype members");
    return;
}
    $db->query("LOCK TABLES members{read}");
    $query=$db->prepare("SELECT id_usr FROM members WHERE id_team = ?");
    $query->execute(array($id_team));
    while($row=$query->fetch()){
        echo get_username($row['id_usr']);
        echo get_img($row['id_usr']);
    }
                $db->query("UNLOCK TABLES");

}



/*
display_tab(id_tor);
-display_week();
-display_day();
-display_annual();
-display_cash();
-display_mytransations(id);*/
?>