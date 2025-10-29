<?php
/**
 * @title: Proyecto integrador Ev01 - Acceso al sistema.
 * @description:  Script PHP para acceder al sistema
 * @version: 0.1
 * @author: ander_frago@cuatrovientos.org, miguel_goyena@cuatrovientos.org
 */

require_once '../templates/header.php';
require_once '../persistence/DAO/equiposDAO.php';
require_once '../persistence/conf/PersistentManager.php';
require_once '../utils/SessionHelper.php';

$gestionEquipos = new equiposDAO();
$equipos = $gestionEquipos->selectAllTeams();

// Capturamos el POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  
    $nombre = trim($_POST['nombre']);
    $estadio = trim($_POST['estadio']);
    if ($nombre !== '' and $estadio !== '') {
        if (!$gestionEquipos->checkExists($nombre,$estadio)) {
          $gestionEquipos->insertTeam($nombre, $estadio);
        } else{
          $mensaje = "El equipo ya existe en la base de datos.";
        }
    } else {
      $mensaje = "Debes completar ambos campos.";
    }


    // Volvemos a cargar los equipos para que aparezca el nuevo
    $equipos = $gestionEquipos->selectAllTeams();
}
?>

<div class="container mt-4">
  <h2 class="mb-4 text-center">Equipos de la competición</h2>

  <div class="row">
    <?php foreach ($equipos as $eq): ?>
      <div class="col-md-4 mb-3">
        <div class="card shadow-sm">
          <div class="card-body">
            <h5 class="card-title"><?= htmlspecialchars($eq['nombre']) ?></h5>
            <p class="card-text">
              <strong>Estadio:</strong> <?= htmlspecialchars($eq['estadio']) ?>
            </p>
            <a href="partidosEquipo.php" class="btn btn-primary btn-sm">
              Ver partidos
            </a>
          </div>
        </div>
      </div>
    <?php endforeach; ?>
  </div>
</div>
<div class="container mt-4">
      <h2 class="mb-4 text-center">Añadir Equipo</h2>
      <?php if (isset($mensaje)): ?>
      <div class="alert alert-info mt-3"><?= htmlspecialchars($mensaje) ?></div>
      <?php endif; ?>
        <form method="POST">
          <div class="mb-3">
            <label for="nombre" class="form-label">Nombre del Equipo</label>
            <input type="text" class="form-control" id="nombre" name="nombre" >
          </div>
          <div class="mb-3">
            <label for="estadio" class="form-label">Estadio</label>
            <input type="text" class="form-control" id="estadio" name="estadio" >
          </div>
          <button type="submit" class="btn btn-primary">Añadir equipo</button>
        </form>
</div>
