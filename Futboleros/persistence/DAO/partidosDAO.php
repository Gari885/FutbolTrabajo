<?php
require_once 'GenericDAO.php';

class partidosDAO extends GenericDAO {

  // Nombre de la tabla
  private const PARTIDOS_TABLE = 'partidos';


public function getAllJornadas() {
    $query = "SELECT DISTINCT jornada FROM " . self::PARTIDOS_TABLE . " ORDER BY jornada ASC";
    $result = mysqli_query($this->conn, $query);

    $jornadas = array();

    while ($row = mysqli_fetch_assoc($result)) {
        $jornadas[] = $row['jornada']; // agregamos solo el valor de la jornada
    }
    return $jornadas;
}


public function getPartidosByJornada($jornada) {
    $query = "SELECT p.id_partido, e1.nombre AS local, e2.nombre AS visitante, p.resultado, p.estadio
              FROM " . self::PARTIDOS_TABLE . " p
              INNER JOIN equipos e1 ON p.id_local = e1.id_equipo
              INNER JOIN equipos e2 ON p.id_visitante = e2.id_equipo
              WHERE p.jornada = ?
              ORDER BY p.id_partido ASC";

    $stmt = mysqli_prepare($this->conn, $query);
    mysqli_stmt_bind_param($stmt, "i", $jornada);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    $partidos = array();
    while ($row = mysqli_fetch_assoc($result)) {
        $partidos[] = $row; // agregamos todo el registro
    }

    mysqli_stmt_close($stmt);
    return $partidos;
}



  public function insertTeam($nombre, $estadio) {
    $query = "INSERT INTO " . self::EQUIPOS_TABLE . " (nombre, estadio) VALUES (?, ?)";
    $stmt = mysqli_prepare($this->conn, $query);
    mysqli_stmt_bind_param($stmt, 'ss', $nombre, $estadio);
    return mysqli_stmt_execute($stmt);
  }


  public function checkExists($nombre, $estadio) {
    $query = "SELECT * FROM " . self::EQUIPOS_TABLE . " WHERE nombre=? AND estadio=?";
    $stmt = mysqli_prepare($this->conn, $query);
    mysqli_stmt_bind_param($stmt, 'ss', $nombre, $estadio);
    mysqli_stmt_execute($stmt);

    $result = mysqli_stmt_get_result($stmt);
    if ($result && mysqli_num_rows($result) > 0) {
      return true;
    } else {
      return false;
    }
  }

  public function selectById($id) {
    $query = "SELECT id, nombre, password FROM " . self::USER_TABLE . " WHERE id=?";
    $stmt = mysqli_prepare($this->conn, $query);
    mysqli_stmt_bind_param($stmt, 'i', $id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    return mysqli_fetch_assoc($result);
  }

  public function update($id, $nombre, $password) {
    $query = "UPDATE " . self::USER_TABLE . " SET nombre=?, password=? WHERE id=?";
    $stmt = mysqli_prepare($this->conn, $query);
    mysqli_stmt_bind_param($stmt, 'ssi', $nombre, $password, $id);
    return mysqli_stmt_execute($stmt);
  }

  public function delete($id) {
    $query = "DELETE FROM " . self::USER_TABLE . " WHERE id=?";
    $stmt = mysqli_prepare($this->conn, $query);
    mysqli_stmt_bind_param($stmt, 'i', $id);
    return mysqli_stmt_execute($stmt);
  }
}
?>
