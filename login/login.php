<?php
include ('login_functions.php');
session_start();
if(isset($_SESSION['username'])){
    session_destroy();
}
if(isset($_POST['login'])){
    if(check_username($_POST['username'])){
        if(check_password($_POST['password'], $_POST['username'])){
            login($_POST['username'], $_POST['password']);
        }
    }
}
else{
    ?>
    <form action="<?php echo $_SERVER["REQUEST_URI"]; ?>" method="POST">
    <input type="text" name="username" placeholder="username" required maxlenght="16"/>
    <input type="password" name="password" placeholder="password" required maxlenght="20"/>
    <input type="submit" name="login" value="Accedi" />
  </form>
<?php
}