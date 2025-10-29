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
            <a href="partidosEquipo.php?id=<?= $eq['id_equipo'] ?>" class="btn btn-primary btn-sm">
              Ver partidos
            </a>
          </div>
        </div>
      </div>
    <?php endforeach; ?>
  </div>
</div>
