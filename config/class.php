<?php

class MySQL { 
  public $conn;

  // construct start class
  public function __construct($host, $user, $pass, $db) {
    $this->conn = new mysqli($host, $user, $pass, $db);

    if ($this->conn->connect_error) {
      die("koneksi gagal:". $this->conn->connect_error);
    }
  }

  // mysql : select
  public function mysql_select($table, $where = "", $column = "*")
  {
    $sql = "SELECT $column FROM $table";

    if (!empty($where)) {
        $sql .= " WHERE $where";
    }

    $result = $this->conn->query($sql);

    if (!$result) {
        return [];
    }

    return $result->fetch_all(MYSQLI_ASSOC);
  }

  // mysql : insert
  public function mysql_insert($table, $column, $value) 
  {

    $stmt = $this->conn->prepare(
        "INSERT INTO $table ($column) VALUES ($value)"
    );

    // $stmt->bind_param("s", $value);

    return $stmt->execute();
  }

  // mysql : update
  public function mysql_update($table, $id, $new_name)
  {
    $stmt = $this->conn->prepare(
        "UPDATE $table SET 
        nama = ? 
        WHERE id = ?"
    );

    $stmt->bind_param(
        "si",
        $new_name,
        $id
    );

    return $stmt->execute();
  }
  
  public function add_kandidat($nama, $visi, $misi)
  {
    $stmt = $this->conn->prepare(
        "INSERT INTO tb_kardidat (nama, visi, misi)
         VALUES (?, ?, ?)"
    );

    if (!$stmt) {
        die("Prepare Error: " . $this->conn->error);
    }

    $stmt->bind_param("sss", $nama, $visi, $misi);

    if (!$stmt->execute()) {
        die("Execute Error: " . $stmt->error);
    }

    return true;
  }
  // mysql kardidat : delete 
  public function mysql_delete($table, $column, $id)
  {
    $stmt = $this->conn->prepare(
        "DELETE FROM $table WHERE $column = ?"
    );

    $stmt->bind_param("i", $id);

    return $stmt->execute();
  }
  
  // mysql kardidat : update  
  public function update_kardidat($id, $nama, $visi, $misi) 
  {
    $stmt = $this->conn->prepare(
          // SET nama = ? WHERE id = ?"
        "UPDATE tb_kardidat SET
        nama = ? , visi = ?, misi = ? 
        WHERE id = ?"
    );
    
    $stmt->bind_param("sssi", $nama, $visi, $misi, $id);

    return $stmt->execute();
  }

  // mysql siswa : voting
  public function voting_kardidat($id, $voted)
  {
    $stmt = $this->conn->prepare(
      "UPDATE tb_siswa SET
      status = 1,
      voted = ?
      WHERE token = ?"
    );

    $stmt->bind_param("is", $voted, $id);

    return $stmt->execute();
  }

  // Login : user 
  public function login_piketos($token)
  {
    $stmt = $this->conn->prepare(
        "SELECT * FROM tb_siswa
        WHERE token = ?"
    );

    if (!$stmt) {
        return false;
    }

    $stmt->bind_param("s", $token);
    $stmt->execute();

    $result = $stmt->get_result();

    if ($result->num_rows === 0) {
        return false;
    }

    return $result->fetch_assoc();
  }
  
  // login : admin
  public function login_admin($token)
  {
    $stmt = $this->conn->prepare(
        "SELECT * FROM tb_admin
        WHERE password = ?"
    );

    if (!$stmt) {
        return false;
    }

    $stmt->bind_param("s", $token);
    $stmt->execute();

    $result = $stmt->get_result();

    if ($result->num_rows === 0) {
        return false;
    }

    return $result->fetch_assoc();
  }

}

// $db->insert("siswa",["nama" => "Febri", "kelas" => "XI RPL 1"]);

$host = "localhost";
$user = "root";
$pass = "";
$base = "db_piketos";

$conn = new MySQL($host, $user, $pass, $base);
echo "koneksi berhasil";

?>
