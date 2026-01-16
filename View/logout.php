<?php
session_start();
$_SESSION = array();
if (isset($_COOKIE[session_name()])) {
    setcookie(session_name(), '', time()-3600, '/');
}
setcookie('remember_user', '', time()-3600, '/');
setcookie('remember_role', '', time()-3600, '/');
session_destroy();
header("Location: ../Control/login.php");
exit();
?>
