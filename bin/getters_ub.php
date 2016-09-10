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

function get_tournament_sponsor($id){
    $db=  connect_urbangames();
    $db->query("LOCK TABLES torneo{read}");
    $id=(int)$id;
    $query=$db->prepare("SELECT id_sponsor FROM torneo WHERE id= ?");
    $query->execute(array($id));
    $riga=$query->fetch();
    $db->query("UNLOCK TABLES");
    return $riga['id_sponsor'];
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

function get_tournament_gt($id){
    $db=  connect_urbangames();
    $db->query("LOCK TABLES torneo{read}");
    $id=(int)$id;
    $query=$db->prepare("SELECT GT FROM torneo WHERE id= ?");
    $query->execute(array($id));
    $riga=$query->fetch();
    $db->query("UNLOCK TABLES");
    return $riga['GT'];
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

function get_tournament_prize($id){
    $db=  connect_urbangames();
    $db->query("LOCK TABLES torneo{read}");
    $id=(int)$id;
    $query=$db->prepare("SELECT prize FROM torneo WHERE id= ?");
    $query->execute(array($id));
    $riga=$query->fetch();
    $db->query("UNLOCK TABLES");
    return $riga['prize'];
}

function get_tournament_state($id){
    $db=  connect_urbangames();
    $db->query("LOCK TABLES torneo{read}");
    $id=(int)$id;
    $query=$db->prepare("SELECT state FROM torneo WHERE id= ?");
    $query->execute(array($id));
    $riga=$query->fetch();
    $db->query("UNLOCK TABLES");
    return $riga['state'];
}

function get_group_cat($id){
    $db=  connect_urbangames();
    $db->query("LOCK TABLES gironi{read}");
    $id=(int)$id;
    $query=$db->prepare("SELECT cat FROM gironi WHERE id= ?");
    $query->execute(array($id));
    $riga=$query->fetch();
    $db->query("UNLOCK TABLES");
    return $riga['cat'];
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
    if(get_match_state($id) < 2){
        echo ("Partita non giocata!");
        return;
    }
    if(get_match_g1($id) > get_match_g2($id)){
        return get_match_id_usr1($id);
    }
    else{
        return get_match_id_usr2($id);
    }
}

function get_match_loser($id){
    $id=(int)$id;
    if(get_match_state($id) < 2){
        echo ("Partita non giocata!");
        return;
    }
    if(get_match_g1($id) > get_match_g2($id)){
        return get_match_id_usr2($id);
    }
    else{
        return get_match_id_usr1($id);
    }
}

function get_match_result($id){
    $id=(int)$id;
    if(get_match_state($id) < 2){
        echo ("Partita non giocata!");
        return;
    }
    if(get_match_g1($id) > get_match_g2($id)){
        return 1;
    }
    elseif(get_match_g1($id) < get_match_g2($id)){
        return 2;
    }
    else{
        return 0;
    }
}

function get_subscription_admin($tor,$usr){
    $db=connect_urbangames();
    $db->query("LOCK TABLES iscrizione{read}");
    $query=$db->prepare("SELECT id_admin FROM iscrizione WHERE id_tor = ? AND id_usr = ?");
    $query->execute(array($tor,$usr));
    $row=$query->fetch();
    $db->query("UNLOCK TABLES");
    return $row['id_admin'];
}

function get_sponsor_name($id){
    $db=connect_urbangames();
    $db->query("LOCK TABLES sponsor{read}");
    $query=$db->prepare("SELECT name FROM sponsor WHERE id = ?");
    $query->execute(array($id));
    $row=$query->fetch();
    $db->query("UNLOCK TABLES");
    return $row['name'];
}

function get_sponsor_mail($id){
    $db=connect_urbangames();
    $db->query("LOCK TABLES sponsor{read}");
    $query=$db->prepare("SELECT mail FROM sponsor WHERE id = ?");
    $query->execute(array($id));
    $row=$query->fetch();
    $db->query("UNLOCK TABLES");
    return $row['mail'];
}

function get_sponsor_facebook($id){
    $db=connect_urbangames();
    $db->query("LOCK TABLES sponsor{read}");
    $query=$db->prepare("SELECT facebook FROM sponsor WHERE id = ?");
    $query->execute(array($id));
    $row=$query->fetch();
    $db->query("UNLOCK TABLES");
    return $row['facebook'];
}

function get_sponsor_img($id){
    $db=connect_urbangames();
    $db->query("LOCK TABLES sponsor{read}");
    $query=$db->prepare("SELECT img FROM sponsor WHERE id = ?");
    $query->execute(array($id));
    $row=$query->fetch();
    $db->query("UNLOCK TABLES");
    return $row['img'];
}

function get_sponsor_site($id){
    $db=connect_urbangames();
    $db->query("LOCK TABLES sponsor{read}");
    $query=$db->prepare("SELECT site FROM sponsor WHERE id = ?");
    $query->execute(array($id));
    $row=$query->fetch();
    $db->query("UNLOCK TABLES");
    return $row['site'];
}

function get_code_admin($id){
    $db=connect_users();
    $db->query("LOCK TABLES codes{read}");
    $query=$db->prepare("SELECT id_admin FROM codes WHERE id = ?");
    $query->execute(array($id));
    $row=$query->fetch();
    $db->query("UNLOCK TABLES");
    return $row['id_admin'];
}

function get_id_code($code){
    $db=connect_users();
    $db->query("LOCK TABLES codes{read}");
    $query=$db->prepare("SELECT id FROM codes WHERE codice = ?");
    $query->execute(array($code));
    $row=$query->fetch();
    $db->query("UNLOCK TABLES");
    return $row['id'];
}

function get_code_tournament($id){
    $db=connect_users();
    $db->query("LOCK TABLES codes{read}");
    $query=$db->prepare("SELECT id_tor FROM codes WHERE id = ?");
    $query->execute(array($id));
    $row=$query->fetch();
    $db->query("UNLOCK TABLES");
    return $row['id_tor'];
}


?>

