<?php

function check_telegram($var){
    if(strlen($var) > 32){
        display_yellow_alert("Telegram: id troppo lungo! (max 32 caratteri)");
        return 0;
    }
    if(substr($var, 0, 1) != '@'){
        display_yellow_alert("Telegram:l'Id deve cominciare con '@'!");
        return 0;
    }
    return 1;
}

function check_username($var){
    if(strlen($var) > 32){
    display_yellow_alert("Username troppo lungo! (max 32 caratteri)");
        return 0;
    }
    $db= connect_users();
    $db->query("LOCK TABLES users{read}");
    $query=$db->prepare("SELECT * FROM users WHERE username LIKE ?");
    $query->execute(array($var));
    if($query->rowCount() > 0){
        display_yellow_alert("Username già in uso!");
        $db->query("UNLOCK TABLES");
        return 0;
    }
    $pattern= '/^([a-zA-Z0-9])+$/';
    if(preg_match($pattern, $var)==0){
        display_yellow_alert("Username errato, sono ammessi solo numeri e lettere!");
        $db->query("UNLOCK TABLES");
        return 0;
    }
    $db->query("UNLOCK TABLES");
    return 1;
}

function check_mail($var){
    if(strlen($var) > 64){
        display_yellow_alert("Mail inserita troppo lunga!");
        return 0;
    }
    $db= connect_users();
    $db->query("LOCK TABLES users{read}");
    $query=$db->prepare("SELECT * FROM users WHERE mail LIKE ?");
    $query->execute(array($var));
    if($query->rowCount() > 0){
        display_yellow_alert("Mail inserita già esistente!");
        $db->query("UNLOCK TABLES");
        return 0;
    }
    $db->query("UNLOCK TABLES");
    return 1;
}

function check_password($var, $var2){
    if(strlen($var) < 6 || strlen($var) > 32){
        display_yellow_alert("La password deve essere compresa fra 6 e 32 caratteri, sono ammesi soltanto lettere e numeri!");
        echo("Lunghezza errata-Password");
        return 0;
    }
    if(strcmp($var,$var2)!= 0){
        display_yellow_alert("Le due password inserite non corrispondono!");
        return 0;
    }
    $pattern= '/^([a-zA-Z0-9])+$/';
    if(preg_match($pattern, $var)==0){
        display_yellow_alert("La password deve essere compresa fra 6 e 32 caratteri, sono ammesi soltanto lettere e numeri!");
        return 0;
    }
    return 1;
}

function register($username, $password, $mail, $telegram, $id_ps4){
    $password = md5($password);
    $ip = $_SERVER['REMOTE_ADDR'];
    $db= connect_users();
    $db->query("LOCK TABLES users{write}");
    $query=$db->prepare("INSERT INTO users (username, password, mail, telegram, balance, reg_ip, last_ip, reg_date, id_ps4, admin) VALUES (?, ?, ?, ?, 0, ?, ?, UNIX_TIMESTAMP(), ?, 0)");
    $query->execute(array($username, $password, $mail, $telegram, $ip, $ip, $id_ps4));
    display_green_alert("Registrazione effettuata!");
    $db->query("UNLOCK TABLES");
}

