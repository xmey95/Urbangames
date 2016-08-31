<?php

function create_tournament($name, $players, $prize, $credits){
    $db= connect_urbangames();
    $db->query("LOCK TABLES torneo{write}");
    $db->prepare("INSERT INTO torneo (name, players, prize, state, credits) VALUES (?, ?, ?, 0, ?)");
    $db->execute(array($name, $players, $prize, $credits));
    echo("Torneo creato");
    $db->query("UNLOCK TABLES");
}

