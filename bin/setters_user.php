<?php

function set_user_credits($id, $credits){
    $db=  connect_users();
    $db->query("LOCK TABLES users{write}");
    $id=(int)$id;
    $query=$db->prepare("UPDATE users SET balance = balance + ? WHERE id = ?");
    $query->execute(array($credits, $id));
    $db->query("UNLOCK TABLES");
}

function increment_win($id){
    $db=  connect_users();
    $db->query("LOCK TABLES users{write}");
    $id=(int)$id;
    $query=$db->prepare("UPDATE users SET win = win + 1 WHERE id = ?");
    $query->execute(array($id));
    $db->query("UNLOCK TABLES");
}

function increment_tie($id){
    $db=  connect_users();
    $db->query("LOCK TABLES users{write}");
    $id=(int)$id;
    $query=$db->prepare("UPDATE users SET tie = tie + 1 WHERE id = ?");
    $query->execute(array($id));
    $db->query("UNLOCK TABLES");
}

function increment_lose($id){
    $db=  connect_users();
    $db->query("LOCK TABLES users{write}");
    $id=(int)$id;
    $query=$db->prepare("UPDATE users SET lose = lose + 1 WHERE id = ?");
    $query->execute(array($id));
    $db->query("UNLOCK TABLES");
}

function increment_trophy($id){
    $db=  connect_users();
    $db->query("LOCK TABLES users{write}");
    $id=(int)$id;
    $query=$db->prepare("UPDATE users SET trophy = trophy + 1 WHERE id = ?");
    $query->execute(array($id));
    $db->query("UNLOCK TABLES");
}

function decrement_win($id){
    $db=  connect_users();
    $db->query("LOCK TABLES users{write}");
    $id=(int)$id;
    $query=$db->prepare("UPDATE users SET win = win - 1 WHERE id = ?");
    $query->execute(array($id));
    $db->query("UNLOCK TABLES");
}

function decrement_tie($id){
    $db=  connect_users();
    $db->query("LOCK TABLES users{write}");
    $id=(int)$id;
    $query=$db->prepare("UPDATE users SET tie = tie - 1 WHERE id = ?");
    $query->execute(array($id));
    $db->query("UNLOCK TABLES");
}

function decrement_lose($id){
    $db=  connect_users();
    $db->query("LOCK TABLES users{write}");
    $id=(int)$id;
    $query=$db->prepare("UPDATE users SET lose = lose - 1 WHERE id = ?");
    $query->execute(array($id));
    $db->query("UNLOCK TABLES");
}

function decrement_trophy($id){
    $db=  connect_users();
    $db->query("LOCK TABLES users{write}");
    $id=(int)$id;
    $query=$db->prepare("UPDATE users SET trophy = trophy - 1 WHERE id = ?");
    $query->execute(array($id));
    $db->query("UNLOCK TABLES");
}