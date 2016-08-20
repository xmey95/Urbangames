<?php

function get_username($id){
    $db_users = connect_users();
    $db_users->query("LOCK TABLES users{read}");
    $id=(int)$id;
    $query=$db_users->prepare("SELECT username FROM users WHERE id = ?");
    $query->execute(array($id));
    $riga=$query->fetch();
    $db_users->query("UNLOCK TABLES");
    return $riga['username'];
}

function get_admin($id){
    $db_users = connect_users();
    $db_users->query("LOCK TABLES users{read}");
    $id=(int)$id;
    $query=$db_users->prepare("SELECT admin FROM users WHERE id = ?");
    $query->execute(array($id));
    $riga=$query->fetch();
    $db_users->query("UNLOCK TABLES");
    return $riga['admin'];
}

function get_telegram($id){
    $db_users = connect_users();
    $db_users->query("LOCK TABLES users{read}");
    $id=(int)$id;
    $query=$db_users->prepare("SELECT telegram FROM users WHERE id = ?");
    $query->execute(array($id));
    $riga=$query->fetch();
    $db_users->query("UNLOCK TABLES");
    return $riga['telegram'];
}

function get_mail($id){
    $db_users = connect_users();
    $db_users->query("LOCK TABLES users{read}");
    $id=(int)$id;
    $query=$db_users->prepare("SELECT mail FROM users WHERE id = ?");
    $query->execute(array($id));
    $riga=$query->fetch();
    $db_users->query("UNLOCK TABLES");
    return $riga['mail'];
}

function get_id_ps4($id){
    $db_users = connect_users();
    $db_users->query("LOCK TABLES users{read}");
    $id=(int)$id;
    $query=$db_users->prepare("SELECT id_ps4 FROM users WHERE id = ?");
    $query->execute(array($id));
    $riga=$query->fetch();
    $db_users->query("UNLOCK TABLES");
    return $riga['id_ps4'];
}

function get_img($id){
    $db_users = connect_users();
    $db_users->query("LOCK TABLES users{read}");
    $id=(int)$id;
    $query=$db_users->prepare("SELECT img FROM users WHERE id = ?");
    $query->execute(array($id));
    $riga=$query->fetch();
    if($riga['img']==NULL){
        $db_users->query("UNLOCK TABLES");
        return "Default";
    }
    $db_users->query("UNLOCK TABLES");
    return $riga['img'];
}

function get_id($username){
    $db_users = connect_users();
    $db_users->query("LOCK TABLES users{read}");
    $query=$db_users->prepare("SELECT id FROM users WHERE username = ?");
    $query->execute(array($username));
    $riga=$query->fetch();
    $db_users->query("UNLOCK TABLES");
    return $riga['id'];
}

function get_balance($id){
    $db_users = connect_users();
    $db_users->query("LOCK TABLES users{read}");
    $id=(int)$id;
    $query=$db_users->prepare("SELECT balance FROM users WHERE id = ?");
    $query->execute(array($id));
    $riga=$query->fetch();
    $db_users->query("UNLOCK TABLES");
    return $riga['balance'];
}
?>

