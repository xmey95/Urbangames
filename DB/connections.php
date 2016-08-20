<?php
function connect_users(){
try {
      $users = new PDO('mysql:host=localhost;dbname=Users', "root", "");
    return $users;
} catch(PDOException $e) {
      die("Errore durante la connessione al database!: " . $e->getMessage());
}
              }
              
function connect_urbangames(){
try {
      $ub = new PDO('mysql:host=localhost;dbname=Urbangames', "root", "");
      return $ub;
} catch(PDOException $e) {
      die("Errore durante la connessione al database!: " . $e->getMessage());
}
              }
              
              

?>
