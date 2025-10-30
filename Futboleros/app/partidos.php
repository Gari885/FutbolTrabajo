<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

$basePath = $_SERVER['DOCUMENT_ROOT'] . '/FUTBOLTRABAJO/Futboleros';

require_once $basePath . '/templates/header.php';
require_once $basePath . '/persistence/DAO/equiposDAO.php';
require_once $basePath . '/persistence/DAO/partidosDAO.php';  // Corregí "persistance" a "persistence"
require_once $basePath . '/persistence/conf/PersistentManager.php';
require_once $basePath . '/utils/SessionHelper.php';


$gestionPartidos = new partidosDAO();
$gestionEquipos = new equiposDAO();

$jornadas = $gestionPartidos->getallJornadas();
$equipos = $gestionEquipos->selectAllTeams();

// URL: partidos.php?jornada=2
$numjornada = isset($_GET['jornada']) ? (int)$_GET['jornada'] : 1;
$partidos = $gestionPartidos->getPartidosByJornada($numjornada);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $jornada  = (int) $_POST['jornada'];
    $equipo1  = $_POST['equipo1'];
    $equipo2  = $_POST['equipo2'];
    $resultado = $_POST['resultado'];
    $estadio = $gestionEquipos->getEstadioByEquipoId($equipo1);
    $valid = true; // indicador general de si todo va bien

    // Validación de jornada
    if ($jornada < 1 || $jornada > 38) {
        $mensaje = "La jornada debe estar entre 1 y 38.";
        $valid = false;
    }

    // Validación de equipos distintos
    if ($equipo1 === $equipo2) {
      if (!$equipo1 === "Selecciona equipo" && !$equipo === "Selecciona equipo") {
          $mensaje = "No puedes elegir el mismo equipo dos veces.";
        $valid = false;
      }
    }

    // Comprobar si el partido ya existe
    if ($gestionPartidos->checkPartidoExists($jornada, $equipo1, $equipo2)) {
        $mensaje = "Ya existe un partido entre estos equipos en la jornada $jornada.";
        $valid = false;
    }

    // Si todo está bien, insertamos
    if ($valid) {
        $insertOk = $gestionPartidos->insertPartido($jornada, $equipo1, $equipo2, $resultado, $estadio);
        if ($insertOk) {
            $alerta = "Partido añadido correctamente.";
        } else {
            $mensaje = "Error al insertar el partido en la base de datos.";
        }
    }
}

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
        <div class="list-group-item">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <strong><?= htmlspecialchars($p['local']) ?></strong>
                    <span class="text-muted">vs</span>
                    <strong><?= htmlspecialchars($p['visitante']) ?></strong>
                </div>
                <span class="badge bg-primary rounded-pill">
                    <?= htmlspecialchars($p['resultado']) ?>
                </span>
            </div>
            <small class="text-secondary">
                Estadio: <?= htmlspecialchars($p['estadio']) ?>
            </small>
        </div>
        <?php endforeach; ?>
    </div>


    <div class="container mt-4">
        <h2 class="mb-4 text-center">Añadir Partido</h2>
        <?php if (isset($mensaje)): ?>
          <div class="alert alert-info mt-3"><?= htmlspecialchars($mensaje) ?></div>
        <?php endif; ?>
        <?php if (isset($mensaje)): ?>
            <div class='alert alert-success'><?= htmlspecialchars($mensaje) ?></div>
        <?php endif; ?>
        <form method="POST" class="p-4 border rounded shadow-sm bg-light">
            <div class="row mb-3">
                <div class="col-md-4">
                    <label for="jornada" class="form-label">Jornada</label>
                    <input type="number" class="form-control" id="jornada" name="jornada">
                </div>
            </div>

            <div class="row mb-3">
                <!-- Equipo Local -->
                <div class="col-md-6">
                    <label for="equipo1" class="form-label">Equipo Local</label>
                    <select name="equipo1" id="equipo1" class="form-select">
                        <option value="">Selecciona equipo</option>
                        <?php if (!empty($equipos) && is_array($equipos)): ?>
                        <?php foreach ($equipos as $eq): ?>
                        <option
                            value="<?php echo isset($eq['id']) ? htmlspecialchars($eq['id']) : ''; ?>">
                            <?php echo isset($eq['nombre']) ? htmlspecialchars($eq['nombre']) : 'Sin nombre'; ?>
                        </option>
                        <?php endforeach; ?>
                        <?php else: ?>
                        <option value="">No hay equipos disponibles</option>
                        <?php endif; ?>
                    </select>
                </div>

                <!-- Equipo Visitante -->
                <div class="col-md-6">
                    <label for="equipo2" class="form-label">Equipo Visitante</label>
                    <select name="equipo2" id="equipo2" class="form-select">
                        <option value="">Selecciona equipo</option>
                        <?php if (!empty($equipos) && is_array($equipos)): ?>
                        <?php foreach ($equipos as $eq): ?>
                        <option
                            value="<?php echo isset($eq['id']) ? htmlspecialchars($eq['id']) : ''; ?>">
                            <?php echo isset($eq['nombre']) ? htmlspecialchars($eq['nombre']) : 'Sin nombre'; ?>
                        </option>
                        <?php endforeach; ?>
                        <?php else: ?>
                        <option value="">No hay equipos disponibles</option>
                        <?php endif; ?>
                    </select>
                </div>
            </div>

            <div class="row mb-4">
                <div class="col-md-4">
                    <label for="resultado" class="form-label">Resultado</label>
                    <select class="form-select" id="resultado" name="resultado">
                        <option value="">Selecciona resultado</option>
                        <option value="1">1 (Gana local)</option>
                        <option value="X">X (Empate)</option>
                        <option value="2">2 (Gana visitante)</option>
                    </select>
                </div>
            </div>

            <button type="submit" class="btn btn-primary">Añadir Partido</button>
        </form>
    </div>