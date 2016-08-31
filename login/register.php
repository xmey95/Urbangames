<?php
include ('register_functions.php');
session_start();
if(isset($_SESSION['username'])){
    session_destroy();
}
if(isset($_POST['register'])){
if(check_username($_POST['username']) && check_mail($_POST['mail']) && check_password($_POST['password'], $_POST['password2']) && check_telegram($_POST['telegram'])){
    register($_POST['username'], $_POST['password'], $_POST['mail'], $_POST['telegram'], $_POST['id_ps4']);
}
else{
    echo("Registrazione fallita!");
}

}
else{
    ?>
    <form action="<?php echo $_SERVER["REQUEST_URI"]; ?>" method="POST">
    <input type="text" name="username" placeholder="username" required maxlenght="32"/>
    <input type="password" name="password" placeholder="password" required maxlenght="32"/>
    <input type="password" name="password2" placeholder="password2" required maxlenght="32"/>
    <input type="email" name="mail" placeholder="mail" required maxlenght="64"/>
    <input type="text" name="telegram" placeholder="telegram" required maxlenght="32"/>
    <input type="text" name="id_ps4" placeholder="id_ps4" required maxlenght="32"/>
    <input type="submit" name="register" value="Registra" />
  </form>
<?php
}


