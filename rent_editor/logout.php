<?php
session_start();
$_SESSION['user_id'] = 0;
unset($_SESSION['user_name']);
unset($_SESSION['middle_name']);
unset($_SESSION['user_surname']);
unset($_SESSION['user_login']);
unset($_SESSION['department']);
?>
<script>document.location.href="../main.php"</script>