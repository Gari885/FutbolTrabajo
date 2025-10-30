<?php
$basePath = $_SERVER['DOCUMENT_ROOT'] . '/FUTBOLTRABAJO/Futboleros';

require_once $basePath . '/templates/header.php';
require_once $basePath . '/persistence/DAO/equiposDAO.php';
require_once $basePath . '/persistence/DAO/partidosDAO.php';  // Corregí "persistance" a "persistence"
require_once $basePath . '/persistence/conf/PersistentManager.php';
require_once $basePath . '/utils/SessionHelper.php';

SessionHelper::
?>