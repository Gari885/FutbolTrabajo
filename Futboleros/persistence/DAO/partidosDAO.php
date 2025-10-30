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


public function checkPartidoExists($jornada, $equipo1, $equipo2) {
    $query = "SELECT id_partido 
              FROM " . self::PARTIDOS_TABLE . " 
              WHERE jornada = ? 
              AND (
                  (id_local = ? AND id_visitante = ?) 
                  OR (id_local = ? AND id_visitante = ?)
              )";

    $stmt = mysqli_prepare($this->conn, $query);
    mysqli_stmt_bind_param($stmt, 'iiiii', $jornada, $equipo1, $equipo2, $equipo2, $equipo1);
    mysqli_stmt_execute($stmt);

    $result = mysqli_stmt_get_result($stmt);
    $exists = ($result && mysqli_num_rows($result) > 0);

    mysqli_stmt_close($stmt);
    return $exists;
}

public function insertPartido($jornada, $equipo1, $equipo2, $resultado, $estadio) {
    $query = "INSERT INTO " . self::PARTIDOS_TABLE . " 
              (id_local, id_visitante, jornada, resultado, estadio) 
              VALUES (?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($this->conn, $query);
    mysqli_stmt_bind_param($stmt, 'iiiss', $equipo1, $equipo2, $jornada, $resultado, $estadio);
    
    $success = mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    
    return $success;
}


public function getPartidoById($id_equipo) {
    $query = "SELECT p.*, e1.nombre AS local, e2.nombre AS visitante, p.estadio
              FROM partidos p
              INNER JOIN equipos e1 ON p.id_local = e1.id_equipo
              INNER JOIN equipos e2 ON p.id_visitante = e2.id_equipo
              WHERE p.id_partido = ?";

    $stmt = mysqli_prepare($this->conn, $query);
    mysqli_stmt_bind_param($stmt, 'i', $id_equipo);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($row = mysqli_fetch_assoc($result)) {
        return $row; // devuelve el partido completo
    }
    return null;
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
