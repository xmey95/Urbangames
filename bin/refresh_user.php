<?php

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
    $db->query("UNLOCK TABLES");
    return 0;
}

function refresh_username($var, $password, $id){
    $db=  connect_users();
    if(password_confirm($password, $id)){
        if(check_username($var)){
                $db->query("LOCK TABLES users{write}");
                $query=$db->prepare("UPDATE users SET username = ? WHERE id = ?");
                $query->execute(array($var, $id));
                $_SESSION['username']=$var;
                display_green_alert("Fatto!");
                $db->query("UNLOCK TABLES");
        }
        else{
            }
    }
    else{
        display_yellow_alert("Password errata, Username inalterato!");
            }
}

function refresh_mail($var, $password, $id){
    $db=  connect_users();
    if(password_confirm($password, $id)){
        if(check_mail($var)){
                $db->query("LOCK TABLES users{write}");
                $query=$db->prepare("UPDATE users SET mail = ? WHERE id = ?");
                $query->execute(array($var, $id));
                $db->query("UNLOCK TABLES");
                display_green_alert("Fatto!");
        }
        else{
            }
    }
    else{
              display_yellow_alert("Password errata, Mail inalterata!");
            }
}

function refresh_telegram($var, $password, $id){
    $db=  connect_users();
    if(password_confirm($password, $id)){
        if(check_telegram($var)){
                $db->query("LOCK TABLES users{write}");
                $query=$db->prepare("UPDATE users SET telegram = ? WHERE id = ?");
                $query->execute(array($var, $id));
                $db->query("UNLOCK TABLES");
                display_green_alert("Fatto!");
        }
        else{
            }
    }
    else{
              display_yellow_alert("Password errata, ID Telegram inalterato!");            }
}


function refresh_id_ps4($var, $password, $id){
    $db=  connect_users();
    if(password_confirm($password, $id)){
                $db->query("LOCK TABLES users{write}");
                $query=$db->prepare("UPDATE users SET id_ps4 = ? WHERE id = ?");
                $query->execute(array($var, $id));
                $db->query("UNLOCK TABLES");
                display_green_alert("Fatto!");
    }
    else{
                display_yellow_alert("Password errata, ID PSN inalterato!");
        }
}

function refresh_password($var, $var2, $password, $id){
    if(password_confirm($password, $id)){
        $db= connect_users();
        if(check_password($var, $var2)){
                $db->query("LOCK TABLES users{write}");
                $var=md5($var);
                $query=$db->prepare("UPDATE users SET password = ? WHERE id = ?");
                $query->execute(array($var, $id));
                $db->query("UNLOCK TABLES");
        }
        else{
            }
    }
    else{
        display_yellow_alert("Password errata, operazione fallita!");
    }
}

function refresh_user_img($id){
    $target_dir = "images/profile_images/";
    $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
    $uploadOk = 1;
    $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
    // Check if image file is a actual image or fake image
    if(isset($_POST["submit"])) {
    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
    if($check !== false) {
        $uploadOk = 1;
    } else {
        display_yellow_alert("Il file non è un immagine, operazione fallita!");
        $uploadOk = 0;
    }
}
// Check file size
if ($_FILES["fileToUpload"]["size"] > 20000000) {
display_yellow_alert("Il file è troppo grande, operazione fallita");
    $uploadOk = 0;
}
// Allow certain file formats
if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
 ) {
display_yellow_alert("Ammessi solo file in formato png o jpeg, operazione fallita!");
    $uploadOk = 0;
}
// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
display_red_alert("Spiacenti, operazione fallita!");
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
        if(strcmp($imageFileType,'png')==0){
    $image_old=imagecreatefrompng($target_file);
}
else{
    $image_old=imagecreatefromjpeg($target_file);
}
        $height=imagesy($image_old);
        $width=imagesx($image_old);
        crop_image($height, $width, $target_file, end($temp));
        $db=  connect_users();
        $db->query("LOCK TABLES users{write}");
        $query=$db->prepare("UPDATE users SET img = ? WHERE id = ?");
        $query->execute(array($newfilename, get_id($_SESSION['username'])));
        echo("Fatto");
        $db->query("UNLOCK TABLES");
display_green_alert("Fatto!");
    } else {
display_red_alert("Spiacenti, operazione fallita");
    }
}
}

function crop_image($height, $width, $image, $imageFileType){
$nome_immagine=$image;
$dst_x = 0;
$dst_y = 0;
if($width > $height){
    $src_x = ($width-$height)/3;
    $src_y = 0;
    $dst_w = $height; // Larghezza nuova Immagine
    $dst_h = $height; // Altezza nuova Immagine
}
elseif($height > $width){
    $src_y = ($height-$width)/3;
    $src_x = 0;
    $dst_w = $width; // Larghezza nuova Immagine
    $dst_h = $width; // Altezza nuova Immagine
}
else{
    return;
}
// Se l'immagine dovesse venire schiacciata aggiungere dei valori a queste due variabili (come da esempio)
$src_w = $src_x + $dst_w; // $src_x + $dst_w + numero (150 ad esempio)
$src_h = $src_y + $dst_h; // $src_y + $dst_h + numero (100 ad esempio)
 
$dst_image = imagecreatetruecolor($dst_w,$dst_h);
if(strcmp($imageFileType,'png')==0){
    $src_image = imagecreatefrompng($nome_immagine); // Immagine primaria
}
else{
    $src_image = imagecreatefromjpeg($nome_immagine); // Immagine primaria
}
imagecopyresampled($dst_image, $src_image, $dst_x, $dst_y, $src_x, $src_y, $dst_w, $dst_h, $src_w, $src_h);
if($imageFileType == "png"){
   imagepng($dst_image,$nome_immagine); // Posizione Nuova Immagine (e nome file)
}
else{
imagejpeg($dst_image,$nome_immagine); // Posizione Nuova Immagine (e nome file)
}
}