<?php
$basePath = $_SERVER['DOCUMENT_ROOT'] . '/FUTBOLENTREGA/Futboleros';

require_once $basePath . '/templates/header.php';
require_once $basePath . '/persistence/DAO/equiposDAO.php';
require_once $basePath . '/persistence/DAO/partidosDAO.php';  
require_once $basePath . '/utils/SessionHelper.php';

SessionHelper::startSessionIfNotStarted();
$gestionPartidos = new partidosDAO();
$gestionEquipos = new equiposDAO();

if (!isset($_GET['id'])) {
    echo "<div class='alert alert-danger'>No se ha especificado ningún equipo.</div>";
    exit;
}

$partidos = $gestionPartidos->getPartidoById($_GET['id']);
$equipos = $gestionEquipos->getEquipoById($_GET['id']);

$id_equipo = (int)$_GET['id'];
$_SESSION['ultimo_equipo_id'] = $id_equipo;

?>

<div class="container mt-4">
  <h2 class="text-center mb-4">Partidos de <?= htmlspecialchars($equipos['nombre']) ?></h2>

  <?php if (empty($partidos)): ?>
    <div class="alert alert-warning text-center">No hay partidos registrados para este equipo.</div>
  <?php else: ?>
    <?php 
    // Agrupar partidos por jornada
    $partidosPorJornada = [];
    foreach ($partidos as $p) {
        $jornada = $p['jornada'];
        if (!isset($partidosPorJornada[$jornada])) {
            $partidosPorJornada[$jornada] = [];
        }
        $partidosPorJornada[$jornada][] = $p;
    }
    
    // Ordenar por jornada
    ksort($partidosPorJornada);
    
    // Mostrar partidos agrupados por jornada
    foreach ($partidosPorJornada as $jornada => $partidosJornada): 
    ?>
      <h4 class="mt-4 mb-3">Jornada <?= $jornada ?></h4>
      <div class="list-group mb-4">
        <?php foreach ($partidosJornada as $p): ?>
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
    <?php endforeach; ?>
    
  <?php endif; ?>
</div>