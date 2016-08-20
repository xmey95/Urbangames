<?php

function set_user_credits($id, $credits){
    $db=  connect_users();
    $db->query("LOCK TABLES users{write}");
    $id=(int)$id;
    $query=$db->prepare("UPDATE users SET balance = balance + ? WHERE id = ?");
    $query->execute(array($credits, $id));
    $db->query("UNLOCK TABLES");
}
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

