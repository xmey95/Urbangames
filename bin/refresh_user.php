<?php

include ('login/register_functions.php');
include ('getters_user.php');

function password_confirm($var, $id){
    $var=md5($var);
    $db=  connect_users();
    $db->query("LOCK TABLES users{read}");
    $query=$db->prepare("SELECT password FROM users WHERE id LIKE ?");
    $query->execute(array($id));
    while($row=$query->fetch()){
        if(strcmp($var, $row['password'])==0){
            $db->query("UNLOCK TABLES");
            return 1;
        }
    }
    echo("Password errata");
    $db->query("UNLOCK TABLES");
    return 0;
}

function refresh_username($var, $password, $id){
    if(password_confirm($password, $id)){
        if(check_username($var)){
                $db=  connect_users();
                $db->query("LOCK TABLES users{write}");
                $query=$db->prepare("UPDATE users SET username = ? WHERE id = ?");
                $query->execute(array($var, $id));
                $_SESSION['username']=$var;
                $db->query("UNLOCK TABLES");
        }
        else{
                echo("username inalterato");
                $db->query("UNLOCK TABLES");
            }
    }
}

function refresh_mail($var, $password, $id){
    if(password_confirm($password, $id)){
        if(check_mail($var)){
                $db=  connect_users();
                $db->query("LOCK TABLES users{write}");
                $query=$db->prepare("UPDATE users SET mail = ? WHERE id = ?");
                $query->execute(array($var, $id));
                $db->query("UNLOCK TABLES");
        }
        else{
                echo("mail inalterata");
                $db->query("UNLOCK TABLES");
            }
    }
}

function refresh_telegram($var, $password, $id){
    if(password_confirm($password, $id)){
        if(check_telegram($var)){
                $db=  connect_users();
                $db->query("LOCK TABLES users{write}");
                $query=$db->prepare("UPDATE users SET telegram = ? WHERE id = ?");
                $query->execute(array($var, $id));
                $db->query("UNLOCK TABLES");
        }
        else{
                echo("telegram inalterato");
                $db->query("UNLOCK TABLES");
            }
    }
}

function refresh_id_ps4($var, $password, $id){
    if(password_confirm($password, $id)){
                $db=  connect_users();
                $db->query("LOCK TABLES users{write}");
                $query=$db->prepare("UPDATE users SET id_ps4 = ? WHERE id = ?");
                $query->execute(array($var, $id));
                $db->query("UNLOCK TABLES");
    }
    else{
                echo("id ps4 inalterato");
                $db->query("UNLOCK TABLES");
        }
}

function refresh_password($var, $var2, $password, $id){
    if(password_confirm($password, $id)){
        if(check_password($var, $var2)){
                $db=  connect_users();
                $db->query("LOCK TABLES users{write}");
                $var=md5($var);
                $query=$db->prepare("UPDATE users SET password = ? WHERE id = ?");
                $query->execute(array($var, $id));
                $db->query("UNLOCK TABLES");
        }
        else{
                echo("password inalterata");
                $db->query("UNLOCK TABLES");
            }
    }
}

function refresh_user_img($password, $id){
    if(password_confirm($password, $id)){
    $target_dir = "images/profile_images/";
    $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
    $uploadOk = 1;
    $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
    // Check if image file is a actual image or fake image
    if(isset($_POST["submit"])) {
    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
    if($check !== false) {
        echo "File is an image - " . $check["mime"] . ".";
        $uploadOk = 1;
    } else {
        echo "File is not an image.";
        $uploadOk = 0;
    }
}
// Check file size
if ($_FILES["fileToUpload"]["size"] > 20000000) {
    echo "Sorry, your file is too large.";
    $uploadOk = 0;
}
// Allow certain file formats
if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
&& $imageFileType != "gif" ) {
    echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
    $uploadOk = 0;
}
// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
    echo "Sorry, your file was not uploaded.";
// if everything is ok, try to upload file
} else {
    $path="images/profile_images/" . get_img(get_id($_SESSION['username']));
    if(strcmp(get_img(get_id($_SESSION['username'])), "Default")!=0){
    unlink($path);
    }
    $temp = explode(".", $_FILES["fileToUpload"]["name"]);
    $newfilename = get_id($_SESSION['username']) . '.' . end($temp);
    $target_file= $target_dir . basename($newfilename);
    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
        $db=  connect_users();
        $db->query("LOCK TABLES users{write}");
        $query=$db->prepare("UPDATE users SET img = ? WHERE id = ?");
        $query->execute(array($newfilename, get_id($_SESSION['username'])));
        $db->query("UNLOCK TABLES");
        echo "The file ". basename( $newfilename). " has been uploaded.";
    } else {
        echo "Sorry, there was an error uploading your file.";
    }
}
    }
}