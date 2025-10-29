<?php
/**
 * @title: Proyecto integrador Ev01 - Registro en el sistema.
 * @description:  Script PHP para almacenar un nuevo usuario en la base de datos
 *
 * @version    0.2
 *
 * @author     Ander Frago & Miguel Goyena <miguel_goyena@cuatrovientos.org>
 */

//TODO completa los requiere que necesites


require_once '../templates/header.php';
require_once '../persistence/DAO/partidosDAO.php';
require_once '../persistence/conf/PersistentManager.php';
require_once '../utils/SessionHelper.php';

$gestionPartidos = new partidosDAO();
$jornadas = $gestionPartidos->getallJornadas();

// URL: partidos.php?jornada=2
$numjornada = isset($_GET['jornada']) ? (int)$_GET['jornada'] : 1;
$partidos = $gestionPartidos->getPartidosByJornada($numjornada);

?>

<div class="container mt-4">
  <h2 class="mb-4 text-center">Partidos por Jornada</h2>

  <!-- Nav Pills de jornadas -->
<ul class="nav nav-pills mb-3" role="tablist">
  <?php foreach ($jornadas as $jornada): ?>
    <li class="nav-item" role="presentation">
      <a href="partidos.php?jornada=<?= $jornada ?>" 
         class="nav-link <?= $jornada == $numjornada ? 'active' : '' ?>">
        Jornada <?= $jornada ?>
      </a>
    </li>
  <?php endforeach; ?>
</ul>


  <!-- Contenido de cada jornada -->
<div class="list-group">
  <?php 
    $partidos = $gestionPartidos->getPartidosByJornada($numjornada);
    foreach ($partidos as $p): 
  ?>
    <div class="list-group-item d-flex justify-content-between align-items-center">
      <?= htmlspecialchars($p['local']) ?> vs <?= htmlspecialchars($p['visitante']) ?>
      <span class="badge bg-primary rounded-pill"><?= $p['resultado'] ?></span>
    </div>
  <?php endforeach; ?>
</div>

