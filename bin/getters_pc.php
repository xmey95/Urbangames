<?php

function get_cap($team){
    $db_pc = connect_proclub();
    $db_pc->query("LOCK TABLES teams{read}");
    $team=(int)$team;
    $query=$db_pc->prepare("SELECT captain FROM teams WHERE id = ?");
    $query->execute(array($team));
    $riga=$query->fetch();
    $db_pc->query("UNLOCK TABLES");
    return $riga['captain'];
}

function get_team_name($team){
    $db_pc = connect_proclub();
    $db_pc->query("LOCK TABLES teams{read}");
    $team=(int)$team;
    $query=$db_pc->prepare("SELECT name FROM teams WHERE id = ?");
    $query->execute(array($team));
    $riga=$query->fetch();
    $db_pc->query("UNLOCK TABLES");
    return $riga['name'];
}

function get_team_image($team){
    $db_pc = connect_proclub();
    $db_pc->query("LOCK TABLES teams{read}");
    $team=(int)$team;
    $query=$db_pc->prepare("SELECT image FROM teams WHERE id = ?");
    $query->execute(array($team));
    $riga=$query->fetch();
    if($riga['image']==NULL){
        $db_pc->query("UNLOCK TABLES");
        return "Default";
    }
    $db_pc->query("UNLOCK TABLES");
    return $riga['image'];
}

function get_tournament_match_pc($id){
    $db=  connect_proclub();
    $db->query("LOCK TABLES teams{read},girone{read}");
    $id=(int)$id;
    $query=$db->prepare("SELECT id_gir FROM matches WHERE id= ?");
    $query->execute(array($id));
    $riga=$query->fetch();
    $gir=$riga['id_gir'];
    $gir=(int)$gir;
    $query=$db->prepare("SELECT id_tor FROM girone WHERE id= ?");
    $query->execute(array($gir));
    $riga=$query->fetch();
    $db->query("UNLOCK TABLES");
    return $riga['id_tor'];
}

function get_tournament_name_pc($id){
    $db= connect_proclub();
    $db->query("LOCK TABLES torneo{read}");
    $id=(int)$id;
    $query=$db->prepare("SELECT name FROM torneo WHERE id= ?");
    $query->execute(array($id));
    $riga=$query->fetch();
    $db->query("UNLOCK TABLES");
    return $riga['name'];
}

function get_user_team($id){
    $db= connect_proclub();
    $db->query("LOCK TABLES members{read}");
    $id=(int)$id;
    $query=$db->prepare("SELECT id_team FROM members WHERE id_usr= ?");
    $query->execute(array($id));
    $riga=$query->fetch();
    $db->query("UNLOCK TABLES");
    return $riga['id_team'];
}
?>

