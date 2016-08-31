<?php
include('DB/connections.php');
include('bin/getters_user.php');
include('bin/getters_ub.php');

function display_matches_ub($id_gir){
    $db=  connect_urbangames();
if(gettype($id_gir)!='integer'){
    echo("Errore Gettype id_gir");
    return;
}
$db->query("LOCK TABLES matches{read}");
    $query=$db->prepare("SELECT * FROM matches WHERE id_gir = ?");
    $query->execute(array($id_gir));
    while($row=$query->fetch()){
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

function display_tournaments_ub($prize, $part){
    $db= connect_urbangames();
    if(gettype($prize)!='integer' || gettype($part)!='integer'){
    echo("Errore Gettype prize-part");
    return;
}
$db->query("LOCK TABLES torneo{read}");
$query=$db->prepare("SELECT * FROM torneo WHERE credits = ? AND players = ?");
    $query->execute(array($prize, $part));
    while($row=$query->fetch()){
        echo $row['name'];
        echo $row['prize'];
        echo $row['state'];
    }
    $db->query("UNLOCK TABLES");
}

function display_mymatches_ub($id){
    $db= connect_urbangames();
    if(gettype($id)!='integer'){
    echo("Errore Gettype mymatches");
    return;
}
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
    if(gettype($id)!='integer'){
    echo("Errore Gettype mytournaments");
    return;
}
$db->query("LOCK TABLES iscrizione{read}");
$query=$db->prepare("SELECT * FROM iscrizione WHERE id_usr = ?");
    $query->execute(array($id));
    while($row=$query->fetch()){
        $riga=$row['id_tor'];
        $torneo=$db->prepare("SELECT * FROM torneo WHERE id = ?");
        $torneo->execute(array($riga));
        $row2=$torneo->fetch();
        echo $row2['name'];
        echo $row2['prize'];
        echo $row2['state'];
    }
    $db->query("UNLOCK TABLES");
}

function display_groups_ub($id_torneo){
    $db= connect_urbangames();
    if(gettype($id_torneo)!='integer'){
    echo("Errore Gettype groups");
    return;
}
$db->query("LOCK TABLES gironi{read}");
$query=$db->prepare("SELECT * FROM gironi WHERE id_tor = ? AND cat = 0");
$query->execute(array($id_torneo));
while($row=$query->fetch()){
    echo $row['name'];
}
$db->query("UNLOCK TABLES");
}

function display_tables_ub($id_gir){
    $db=  connect_urbangames();
    if(gettype($id_gir)!='integer'){
    echo("Errore Gettype tables");
    return;
}
$db->query("LOCK TABLES classifica{read}");
    $query=$db->prepare("SELECT * FROM classifica WHERE id_gir = ? ORDER BY pnt DESC, gd DESC, gm DESC");
    $query->execute(array($id_gir));
    while($row=$query->fetch()){
        echo get_username($row['id_usr']);
        echo get_img($row['id_usr']);
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

function display_profile($id){
    $db=  connect_users();
    if(gettype($id)!='integer'){
    echo("Errore Gettype profile");
    return;
}
$db->query("LOCK TABLES users{read}");
$query=$db->prepare("SELECT * FROM users WHERE id = ?");
    $query->execute(array($id));
    while($row=$query->fetch()){
        echo $row['username'];
        echo $row['mail'];
        echo $row['telegram'];
        echo $row['id_ps4'];
        echo $row['img'];
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