<?php
session_start();

session_destroy();

header("Location: /Pedidos/templates/login.php");
exit();
?>
