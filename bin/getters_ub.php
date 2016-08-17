<?php

function get_tournament_match_ub($id){
    $db=  connect_urbangames();
    $db->query("LOCK TABLES matches{read}, gironi{read}");
    $id=(int)$id;
    $query=$db->prepare("SELECT id_gir FROM matches WHERE id= ?");
    $query->execute(array($id));
    $riga=$query->fetch();
    $gir=$riga['id_gir'];
    $gir=(int)$gir;
    $query=$db->prepare("SELECT id_tor FROM gironi WHERE id= ?");
    $query->execute(array($gir));
    $riga=$query->fetch();
    $db->query("UNLOCK TABLES");
    return $riga['id_tor'];
}

function get_tournament_name_ub($id){
    $db=  connect_urbangames();
    $db->query("LOCK TABLES torneo{read}");
    $id=(int)$id;
    $query=$db->prepare("SELECT name FROM torneo WHERE id= ?");
    $query->execute(array($id));
    $riga=$query->fetch();
    $db->query("UNLOCK TABLES");
    return $riga['name'];
}

function get_tournament_players($id){
    $db=  connect_urbangames();
    $db->query("LOCK TABLES torneo{read}");
    $id=(int)$id;
    $query=$db->prepare("SELECT players FROM torneo WHERE id = ?");
    $query->execute(array($id));
    $riga=$query->fetch();
    $db->query("UNLOCK TABLES");
    $var=$riga['players'];
    return $var;
}

function get_tournament_credits($id){
    $db=  connect_urbangames();
    $db->query("LOCK TABLES torneo{read}");
    $id=(int)$id;
    $query=$db->prepare("SELECT credits FROM torneo WHERE id= ?");
    $query->execute(array($id));
    $riga=$query->fetch();
    $db->query("UNLOCK TABLES");
    return $riga['credits'];
}

function get_group_name($id){
    $db=  connect_urbangames();
    $db->query("LOCK TABLES gironi{read}");
    $id=(int)$id;
    $query=$db->prepare("SELECT name FROM gironi WHERE id= ?");
    $query->execute(array($id));
    $riga=$query->fetch();
    $db->query("UNLOCK TABLES");
    return $riga['name'];
}
?>

