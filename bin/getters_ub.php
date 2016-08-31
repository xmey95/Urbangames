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

function get_match_state($id){
    $db=  connect_urbangames();
    $db->query("LOCK TABLES matches{read}");
    $id=(int)$id;
    $query=$db->prepare("SELECT state FROM matches WHERE id = ?");
    $query->execute(array($id));
    $state=$query->fetch();
    $db->query("UNLOCK TABLES");
    return $state['state'];
}

function get_match_id_usr1($id){
    $db=  connect_urbangames();
    $db->query("LOCK TABLES matches{read}");
    $id=(int)$id;
    $query=$db->prepare("SELECT id_usr1 FROM matches WHERE id = ?");
    $query->execute(array($id));
    $state=$query->fetch();
    $db->query("UNLOCK TABLES");
    return $state['id_usr1'];
}

function get_match_id_usr2($id){
    $db=  connect_urbangames();
    $db->query("LOCK TABLES matches{read}");
    $id=(int)$id;
    $query=$db->prepare("SELECT id_usr2 FROM matches WHERE id = ?");
    $query->execute(array($id));
    $state=$query->fetch();
    $db->query("UNLOCK TABLES");
    return $state['id_usr2'];
}

function get_match_g1($id){
    $db=  connect_urbangames();
    $db->query("LOCK TABLES matches{read}");
    $id=(int)$id;
    $query=$db->prepare("SELECT g1 FROM matches WHERE id = ?");
    $query->execute(array($id));
    $state=$query->fetch();
    $db->query("UNLOCK TABLES");
    return $state['g1'];
}

function get_match_g2($id){
    $db=  connect_urbangames();
    $db->query("LOCK TABLES matches{read}");
    $id=(int)$id;
    $query=$db->prepare("SELECT g2 FROM matches WHERE id = ?");
    $query->execute(array($id));
    $state=$query->fetch();
    $db->query("UNLOCK TABLES");
    return $state['g2'];
}

function get_match_group($id){
    $db=  connect_urbangames();
    $db->query("LOCK TABLES matches{read}");
    $id=(int)$id;
    $query=$db->prepare("SELECT id_gir FROM matches WHERE id = ?");
    $query->execute(array($id));
    $state=$query->fetch();
    $db->query("UNLOCK TABLES");
    return $state['id_gir'];
}

function get_match_next($id){
    $db=  connect_urbangames();
    $db->query("LOCK TABLES matches{read}");
    $id=(int)$id;
    $query=$db->prepare("SELECT next FROM matches WHERE id = ?");
    $query->execute(array($id));
    $state=$query->fetch();
    $db->query("UNLOCK TABLES");
    return $state['next'];
}

function get_match_winner($id){
    $id=(int)$id;
    if(get_match_g1($id) > get_match_g2($id)){
        return get_match_id_usr1($id);
    }
    else{
        return get_match_id_usr2($id);
    }
}
?>

