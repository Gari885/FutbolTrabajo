<?php
  // Obtenemos el directorio del proyecto para establecer rutas relativas.
  $dir = __DIR__;
  $urlBase = "/FUTBOLENTREGA/Futboleros";
  require_once $dir . '/../utils/SessionHelper.php';

  ///
  /// Gestión de la sesión de usuario:
  ///

  // TODO Almacena en la variable $loggedin el valor retornado de la función loggedin de SessionHelper
$loggedin = SessionHelper::loggedIn();

if ($loggedin && isset($_SESSION['user'])) {
    $user = SessionHelper::obtenerUsuario();
}

?>
<head>
    <meta charset="utf-8">
    <title>FutbolStats</title>
    <meta name="viewport"
          content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
        <link rel="stylesheet" href="<?php echo $urlBase ?>/assets/css/bootstrap.min.css">
</head>
<body>

<?php
  // En caso de tener una sesión registrada con antelación mostramos las opciones avanzadas de la aplicación
  if ($loggedin)
  {
  ?>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <button class="navbar-toggler navbar-toggler-right" type="button"
                data-toggle="collapse" data-target="#navbarTogglerDemo02"
                aria-controls="navbarToggler" aria-expanded="false"
                aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <a class="navbar-brand" href="<?php echo $urlBase; ?>/index.php">FutbolStats</a>

        <div class="collapse navbar-collapse" id="navbarToggler">
            <ul class="navbar-nav mr-auto mt-2 mt-md-0">
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo $urlBase; ?>/app/logout.php">Salir</a>
                </li>
            </ul>
        </div>
    </nav>
  <?php
}
else {
  // En caso de ser usuario no registrado, (Invitado)
  ?>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <button class="navbar-toggler navbar-toggler-right" type="button"
                data-toggle="collapse" data-target="#navbarTogglerDemo02"
                aria-controls="navbarToggler" aria-expanded="false"
                aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <a class="navbar-brand" href="<?php echo $urlBase; ?>/index.php">FutbolStats</a>

        <div class="collapse navbar-collapse" id="navbarToggler">
            <ul class="navbar-nav mr-auto mt-2 mt-md-0">
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo $urlBase; ?>/app/equipos.php">Equipos</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo $urlBase; ?>/app/partidos.php">Partidos</a>
                </li>
            </ul>
        </div>
    </nav>
  <?php
}
?>

<!-- TODO Hay que incluir el Bootstrap en Assets -->
