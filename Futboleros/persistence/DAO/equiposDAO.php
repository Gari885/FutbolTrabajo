<?php
require_once 'GenericDAO.php';

class UserDAO extends GenericDAO {

  // Nombre de la tabla
  const USER_TABLE = 'usuarios';

  public function selectAll() {
    $query = "SELECT * FROM " . self::USER_TABLE;
    $result = mysqli_query($this->conn, $query);
    $users = array();
    while ($userBD = mysqli_fetch_array($result)) {
      $users[] = array(
        'id' => $userBD["id"],
        'nombre' => $userBD["nombre"],
        'password' => $userBD["password"]
      );
    }
    return $users;
  }

  public function selectAllTeams() {
    $query = "SELECT * FROM " . self::EQUIPOS_TABLE;
    $result = mysqli_query($this->conn, $query);
    $teams = array();
    while ($userBD = mysqli_fetch_array($result)) {
      $users[] = array(
        'id' => $userBD["id_equipo"],
        'nombre' => $userBD["nombre"],
        'estadio' => $userBD["estadio"]
      );
    }
    return $users;
  }

  public function insert($nombre, $password) {
    $query = "INSERT INTO " . self::USER_TABLE . " (nombre, password) VALUES (?, ?)";
    $stmt = mysqli_prepare($this->conn, $query);
    mysqli_stmt_bind_param($stmt, 'ss', $nombre, $password);
    return mysqli_stmt_execute($stmt);
  }

  public function checkExists($nombre, $password) {
    $query = "SELECT * FROM " . self::USER_TABLE . " WHERE nombre=? AND password=?";
    $stmt = mysqli_prepare($this->conn, $query);
    mysqli_stmt_bind_param($stmt, 'ss', $nombre, $password);
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

