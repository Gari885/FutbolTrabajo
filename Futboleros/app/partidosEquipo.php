<?php
$basePath = $_SERVER['DOCUMENT_ROOT'] . '/FUTBOLTRABAJO/Futboleros';

require_once $basePath . '/templates/header.php';
require_once $basePath . '/persistence/DAO/equiposDAO.php';
require_once $basePath . '/persistence/DAO/partidosDAO.php';  
require_once $basePath . '/persistence/conf/PersistentManager.php';
require_once $basePath . '/utils/SessionHelper.php';

SessionHelper::startSessionIfNotStarted();
$gestionPartidos = new partidosDAO();
$gestionEquipos = new equiposDAO();

if (!isset($_GET['id_equipo'])) {
    echo "<div class='alert alert-danger'>No se ha especificado ningún equipo.</div>";
    exit;
}

$partidos = $gestionPartidos->getPartidoById($_GET['id_equipo']);
$equipos = $gestionPartidos->getEquipooById($_GET['id_equipo']);

?>

<div class="container mt-4">
  <h2 class="text-center mb-4">Partidos de <?= htmlspecialchars($equipo['nombre']) ?></h2>

  <?php if (empty($partidos)): ?>
    <div class="alert alert-warning text-center">No hay partidos registrados para este equipo.</div>
  <?php else: ?>
    <div class="list-group">
      <?php foreach ($partidos as $p): ?>
        <div class="list-group-item">
          <div class="d-flex justify-content-between align-items-center">
            <div>
              <strong><?= htmlspecialchars($p['local']) ?></strong>
              <span class="text-muted">vs</span>
              <strong><?= htmlspecialchars($p['visitante']) ?></strong>
            </div>
            <span class="badge bg-primary rounded-pill"><?= htmlspecialchars($p['resultado']) ?></span>
          </div>
          <small class="text-secondary">Estadio: <?= htmlspecialchars($p['estadio']) ?></small>
        </div>
      <?php endforeach; ?>
    </div>
  <?php endif; ?>
</div>