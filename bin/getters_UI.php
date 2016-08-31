<?php
include 'DB/connections.php';
function get_to_play($id){
    $db =  connect_urbangames();
    $count=0;
    $query=$db->prepare("SELECT id_tor FROM iscrizione WHERE id_usr = ?");
    $query->execute(array($id));
    while($tor=$query->fetch()['id_tor']){
        $query2=$db->prepare("SELECT id FROM gironi WHERE id_tor = ?");
        $query2->execute(array($tor));
        while($girone=$query2->fetch()['id']){
            $query3=$db->prepare("SELECT * FROM matches WHERE id_gir = ? AND id_usr1 = ? AND state = 0");
            $query3->execute(array($girone,$id));
            $count+=$query3->rowCount();
        }
    }
    return $count;
}

function get_to_confirm($id){
    $db =  connect_urbangames();
    $count=0;
    $query=$db->prepare("SELECT id_tor FROM iscrizione WHERE id_usr = ?");
    $query->execute(array($id));
    while($tor=$query->fetch()['id_tor']){
        $query2=$db->prepare("SELECT id FROM gironi WHERE id_tor = ?");
        $query2->execute(array($tor));
        while($girone=$query2->fetch()['id']){
            $query3=$db->prepare("SELECT * FROM matches WHERE id_gir = ? AND id_usr2 = ? AND state = 1");
            $query3->execute(array($girone,$id));
            $count+=$query3->rowCount();
        }
    }
    return $count;
}

function get_mytournament($id){
     $db =  connect_urbangames();
    $count=0;
    $query=$db->prepare("SELECT id_tor FROM iscrizione WHERE id_usr = ?");
    $query->execute(array($id));
    while($tor=$query->fetch()['id_tor']){
        $count++;
    }
    return $count;
}

function get_available_tournament($id){
    $db=  connect_urbangames();
    $query=$db->prepare("SELECT id AS primo FROM torneo WHERE state = 0 AND NOT EXIST(SELECT * FROM iscrizione WHERE id_tor LIKE primo AND id_usr = ?)");
    $query->execute(array($id));
    return $query->rowCount();
}

function get_notification($id){
    return get_to_play($id)+get_to_confirm($id)+get_mytournament($id)+get_available_tournament($id);
}