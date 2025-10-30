<?php
require_once 'GenericDAO.php';

class equiposDAO extends GenericDAO {

  // Nombre de la tabla
  private const EQUIPOS_TABLE = 'equipos';

  public function selectAllTeams() {
    $query = "SELECT * FROM " . self::EQUIPOS_TABLE;
    $result = mysqli_query($this->conn, $query);
    while ($equiposDAO = mysqli_fetch_array($result)) {
      $users[] = array(
        'id' => $equiposDAO["id_equipo"],
        'nombre' => $equiposDAO["nombre"],
        'estadio' => $equiposDAO["estadio"]
      );
    }
    return $users;
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

public function getEstadioByEquipoId($equipo1) {
    $query = "SELECT estadio FROM " . self::EQUIPOS_TABLE . " WHERE id_equipo = ?";
    $stmt = mysqli_prepare($this->conn, $query);
    mysqli_stmt_bind_param($stmt, "i", $equipo1);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    if ($row = mysqli_fetch_assoc($result)) {
        return $row['estadio'];
    }
    return null;
}


public function getEquipoById($id_equipo) {
    $query = "SELECT * FROM equipos WHERE id_equipo = ?";
    $stmt = mysqli_prepare($this->conn, $query);
    mysqli_stmt_bind_param($stmt, 'i', $id_equipo);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    return mysqli_fetch_assoc($result);
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

