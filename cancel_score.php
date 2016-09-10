<?php
include ("admin/urbangames_functions.php");
include ("DB/connections.php");
include ("bin/getters_user.php");
include ("bin/setters_user.php");
include ("urbangames/tournament_functions.php");
include ("bin/getters_ub.php");
session_start();
$id=htmlspecialchars($_GET['id']);
if(isset($_SESSION['username'])){
cancel_score($id);
}
header('Location: match.php?id='.$id);
?>
