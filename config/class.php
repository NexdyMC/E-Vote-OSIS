<?php

class MySQL { 
  public $conn;
  private $host;
  private $user;
  private $pass;
  private $base;

  // construct start class
  public function __construct($host, $user, $pass, $db) 
  {
    $this->host = "localhost";
    $this->user = "localhost";
    $this->pass = "localhost";
    $this->base = "localhost";

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
  
  // mysql : delete 
  public function mysql_delete($table, $column, $id)
  {
    $stmt = $this->conn->prepare(
        "DELETE FROM $table WHERE $column = ?"
    );

    $stmt->bind_param("i", $id);

    return $stmt->execute();
  }
  
  // mysql kardidat : add 
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

  // mysql kardidat : delete
  public function delete_kardidat($id)
  {

    // ubah value voted menjadi 0
    $stmt = $this->conn->prepare(
      "UPDATE tb_siswa SET voted = 0 WHERE voted = ?");
    $stmt->bind_param('i', $id);
    $stmt->execute();

    // delete kardidat
    $stmt = $this->conn->prepare(
        "DELETE FROM tb_kardidat WHERE id = ?"
      );
    $stmt->bind_param("i", $id);
    return $stmt->execute();
  }

  // mysql siswa : add
  public function add_siswa($token, $nama, $kelas)
  {
    $stmt = $this->conn->prepare(
      "INSERT INTO tb_siswa 
      (token, nama, kelas, status, voted) VALUE (?, ?, ?, 0, 0)");

    $stmt->bind_param("sss", $token, $nama, $kelas);
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

  // mysql Login : user 
  public function login_siswa($token)
  {

    if (empty($token)) {
      return false;
    }
    
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
  
  // mysql login : admin
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

  // mysql image : upload file
  public function upload_image( $local_folder, $name_file, $post_file,)
  {
    $file_name = $_FILES[$post_file]['name'];
    $file_size = $_FILES[$post_file]['size'];
    $file_tmp = $_FILES[$post_file]['tmp_name'];
    
    $extension = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
    $validasi_type = ['jpg', 'jpeg', 'png', 'webp'];
    
    if (!in_array($extension , $validasi_type)) {
      return false;
    }

    if ($file_size >= 2 * 1024 * 1024) {
      return false;
    }

    $new_name = "$name_file" . ".$extension";

    $destination =rtrim($local_folder, "/\\") . DIRECTORY_SEPARATOR . $new_name;
    
    if (move_uploaded_file($file_tmp, $destination))
    {
      return $new_name;
    }

  }
  
  // mysql image : delete file
  public function delete_image($folder, $file_name)
  {
    $path = rtrim($folder, "/\\") . DIRECTORY_SEPARATOR . $file_name;

    if (file_exists($path)) {
        return unlink($path);
    }

    return false;
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
