<?php
include ('../DB/connections.php');

function login($username, $password){
    $db=  connect_users();
    $_SESSION['username']=$username;
    $ip = $_SERVER['REMOTE_ADDR'];
    $query= $db->prepare("UPDATE users SET last_ip = ? WHERE username LIKE ? AND password = ?");
    $query->execute(array($ip, $username, md5($password)));
    header('Location: ../index.php');
}

function check_username($var){
    $db=  connect_users();
    $query= $db->prepare("SELECT * FROM users WHERE username LIKE ?");
    $query->execute(array($var));

    if($query->rowCount() == 0){
     echo ("Username non trovato!");
     return 0;
    }
    return 1;
}

function check_password($var, $username){
    $db=  connect_users();
    $password = md5($var);
    $query= $db->prepare("SELECT * FROM users WHERE username LIKE ? AND password = ?");
    $query->execute(array($username, $password));
    if($query->rowCount() == 0){
        echo ("Password errata!");
        return 0;
    }
    return 1;
}
