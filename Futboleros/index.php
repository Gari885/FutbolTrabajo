<?php
session_start();

// Verificar si hay un equipo guardado en sesión
if (isset($_SESSION['ultimo_equipo_id'])) {
    // Redirigir a los partidos del último equipo consultado
    header("Location: /FUTBOLENTREGA/Futboleros/app/partidosEquipo.php?id=" . $_SESSION['ultimo_equipo_id']);
    exit;
} else {
    // Redirigir a la página de equipos
    header("Location: /FUTBOLENTREGA/Futboleros/app/equipos.php");
    exit;
}
?>

