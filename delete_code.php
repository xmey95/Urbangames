<?php
include ("admin/urbangames_functions.php");
include ("DB/connections.php");
include ("bin/getters_user.php");
session_start();
$id=htmlspecialchars($_GET['id']);
if(isset($_SESSION['username'])){
delete_code($id);
}
?>
<script type="text/javascript">
javascript:history.back();
</script>