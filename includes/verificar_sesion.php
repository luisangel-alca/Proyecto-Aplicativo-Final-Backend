<?php
// Debe incluirse ANTES de cualquier salida HTML en toda página protegida.
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['idusuario'])) {
    header('Location: /login.php');
    exit;
}
