<?php

function create_tournament($name, $players, $prize, $credits){
    $db= connect_urbangames();
    $db->query("LOCK TABLES torneo{write}");
    $query=$db->prepare("INSERT INTO torneo (name, players, prize, state, credits) VALUES (?, ?, ?, 0, ?)");
    $query->execute(array($name, $players, $prize, $credits));
    display_green_alert("Torneo creato");
    $db->query("UNLOCK TABLES");
}

function create_tournament_gt($name, $players, $prize, $credits){
    $db= connect_urbangames();
    $db->query("LOCK TABLES torneo{write}");
    $query=$db->prepare("INSERT INTO torneo (name, players, prize, state, credits, GT) VALUES (?, ?, ?, 0, ?, 1)");
    $query->execute(array($name, $players, $prize, $credits));
    display_green_alert("Torneo GT creato");
    $db->query("UNLOCK TABLES");
}

function create_tournament_sponsor($name, $players, $prize, $credits, $name_s, $mail, $facebook, $site){
    $db= connect_urbangames();
    $db->query("LOCK TABLES sponsor{write}");
    $query=$db->prepare("INSERT INTO sponsor (name, mail, facebook, site, img) VALUES (?, ?, ?, ?, 1)");
    $query->execute(array($name_s, $mail, $facebook, $site));
    $id_sponsor=$db->lastInsertId();
    set_sponsor_img($id_sponsor);
    $db->query("LOCK TABLES torneo{write}");
    $query=$db->prepare("INSERT INTO torneo (name, players, prize, state, credits, GT, id_sponsor) VALUES (?, ?, ?, 0, ?, 0, ?)");
    $query->execute(array($name, $players, $prize, $credits, $id_sponsor));
    display_green_alert("Torneo sponsorizzato creato");
    $db->query("UNLOCK TABLES");
}

function set_sponsor_img($id){
    $target_dir = "images/sponsor_images/";
    $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
    $uploadOk = 1;
    $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
    // Check if image file is a actual image or fake image
    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
    if($check !== false) {
        $uploadOk = 1;
    } else {
        display_red_alert("Il file non è un immagine, upload fallito!");
        $uploadOk = 0;
    }
// Check file size
if ($_FILES["fileToUpload"]["size"] > 20000000) {
        display_red_alert("File troppo grande, upload fallito!");
    $uploadOk = 0;
}
// Allow certain file formats
if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
&& $imageFileType != "gif" ) {
        display_red_alert("Ammesse solo immagini in formato png o jpeg, upload fallito!");
    $uploadOk = 0;
}
// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
// if everything is ok, try to upload file
} else {
    $temp = explode(".", $_FILES["fileToUpload"]["name"]);
    $newfilename = $id . '.' . end($temp);
    $target_file= $target_dir . basename($newfilename);
    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
        $db=  connect_urbangames();
        $db->query("LOCK TABLES sponsor{write}");
        $query=$db->prepare("UPDATE sponsor SET img = ? WHERE id = ?");
        $query->execute(array($newfilename, $id));
        echo("Fatto");
        $db->query("UNLOCK TABLES");
        echo "The file ". basename( $newfilename). " has been uploaded.";
    } else {
        display_red_alert("Siamo spiacenti, upload fallito!");
    }
}
}

function give_admin($id){
	$db=connect_users();
        $db->query("LOCK TABLES users{write}");
	if(get_admin($id)==1){
        display_yellow_alert("L'utente selezionato è già un admin, operazione fallita!");
                $db->query("UNLOCK TABLES");
		return;
	}
	$query=$db->prepare("UPDATE users SET admin=1 WHERE id = ?");
	$query->execute(array($id));
        $db->query("UNLOCK TABLES");
	return;
}


function revoke_admin($id){
    $db=connect_users();
    $db->query("LOCK TABLES users{write}");
	if(get_admin($id)==0){
		display_yellow_alert("L'utente selezionato non è un admin, operazione fallita!");
                $db->query("UNLOCK TABLES");
		return;
	}	
    $query=$db->prepare("UPDATE users SET admin=0 WHERE id = ?");
	$query->execute(array($id));
        $db->query("UNLOCK TABLES");
	return;
}

function display_request(){
    $db= connect_users();
$db->query("LOCK TABLES gt_request{read}");
$query=$db->query("SELECT * FROM gt_request");
    while($row=$query->fetch()){
        ?>
        <tr>
            <td><?php echo get_username($row['id_usr']); ?></td>
            <td><a href="accept_request.php?id=<?php echo $row['id']; ?>"><button type="button" class="btn btn-block btn-success btn-sm">Accetta</button></a></td>
            <td><a href="refuse_request.php?id=<?php echo $row['id']; ?>"><button type="button" class="btn btn-block btn-danger btn-sm">Rifiuta</button></a></td>
        </tr>
        <?php
    }
    $db->query("UNLOCK TABLES");
}

function display_gt_management(){
    $db= connect_users();
$db->query("LOCK TABLES gt_management{read}");
$query=$db->query("SELECT * FROM gt_management ORDER BY id_tor");
$torneo=-1;
    while($row=$query->fetch()){
        if($torneo != $row['id_tor']){
        ?>
        <tr>
            <td><h4><b><?php echo get_tournament_name_ub($row['id_tor']); ?></b></h4></td>
        </tr>
        <?php
        $torneo=$row['id_tor'];
        }
        ?>
        <tr>
            <td><?php echo get_username($row['id_admin']); ?></td>
            <td style="width: 10%"><?php echo $row['n_codes']; ?></td>
        </tr>
        <?php
    }
    $db->query("UNLOCK TABLES");
}

function display_codes(){
    $db= connect_users();
$db->query("LOCK TABLES codes{read}");
$query=$db->query("SELECT * FROM codes ORDER BY id_tor, id_admin");
$torneo=-1;
    while($row=$query->fetch()){
        if($torneo != $row['id_tor']){
        ?>
        <tr>
            <td><h4><b><?php echo get_tournament_name_ub($row['id_tor']); ?></b></h4></td>
        </tr>
        <?php
        $torneo=$row['id_tor'];
        }
        ?>
        <tr>
            <td style="width: 25%"><?php echo get_username($row['id_admin']); ?></td>
            <td><?php echo $row['codice']; ?></td>
            <td style="width: 10%"><a href="delete_code.php?id=<?php echo $row['id']; ?>"><button type="button" class="btn btn-block btn-danger btn-sm">Elimina</button></a></td>
        </tr>
        <?php
    }
    $db->query("UNLOCK TABLES");
}

function accept_request($id){
    $db=connect_users();
    if(get_admin(get_id($_SESSION['username'])) != 1){
        return;
    }
        $db->query("LOCK TABLES gt_request{write}, users{write}");
	if(get_ad_gt(get_request_user($id))==1){
        display_yellow_alert("L'utente selezionato è già un admin, operazione fallita!");
                $db->query("UNLOCK TABLES");
		return;
	}
	$query=$db->prepare("UPDATE users SET ad_gt=1 WHERE id = ?");
	$query->execute(array(get_request_user($id)));
        $query2=$db->prepare("DELETE FROM gt_request WHERE id = ?");
        $query2->execute(array($id));
        $db->query("UNLOCK TABLES");
	return;
}

function refuse_request($id){
    $db=connect_users();
    if(get_admin(get_id($_SESSION['username'])) != 1){
        return;
    }
    $db->query("LOCK TABLES gt_request{write}");
    $query2=$db->prepare("DELETE FROM gt_request WHERE id = ?");
    $query2->execute(array($id));
    $db->query("UNLOCK TABLES");
    return;
}

function delete_code($id){
    $db=connect_users();
    if(get_admin(get_id($_SESSION['username'])) != 1){
        return;
    }
    $db->query("LOCK TABLES codes{write}");
    $query2=$db->prepare("DELETE FROM codes WHERE id = ?");
    $query2->execute(array($id));
    $db->query("UNLOCK TABLES");
    return;
}

function revoke_ad_gt($id){
    $db=connect_users();
    $db->query("LOCK TABLES users{write}");
	if(get_ad_gt($id)==0){
            display_yellow_alert("L'utente non è un admin, operazione fallita!");
                $db->query("UNLOCK TABLES");
		return;
	}	
    $query=$db->prepare("UPDATE users SET ad_gt=0 WHERE id = ?");
	$query->execute(array($id));
        $db->query("UNLOCK TABLES");
        display_green_alert("Fatto!");
	return;
}