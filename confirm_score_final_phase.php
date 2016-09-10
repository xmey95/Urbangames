<?php
include ("admin/urbangames_functions.php");
include ("DB/connections.php");
include ("bin/getters_user.php");
include ("urbangames/tournament_functions.php");
include ("bin/getters_ub.php");
session_start();
$id=htmlspecialchars($_GET['id']);
if(isset($_SESSION['username'])){
$id_user=get_id($_SESSION['username']);
confirm_score_final_phase($id, $id_user);
}
header('Location: match.php?id='.$id);
?>
