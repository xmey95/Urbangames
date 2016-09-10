<?php
include ("admin/urbangames_functions.php");
include ("DB/connections.php");
include ("bin/getters_user.php");
$id=htmlspecialchars($_GET['id']);
session_start();
if(isset($_SESSION['username'])){
refuse_request($id);
}
?>
<script type="text/javascript">
javascript:history.back();
</script>