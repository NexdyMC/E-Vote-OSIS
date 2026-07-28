<?php

// random for id
function random_id($length = 12) {
  $array = [ "a", "b", "c", "d", "e", "f", "g", "h", "i", "j", "k", "l", "m", "n",
 "o", "p", "q", "r", "s", "t", "u", "v", "w", "x", "y", "z" ];
 
  $cuid = "";

  for ($i = 0 ; $i < $length ; $i++) {
      
      $biner_x = rand(0, 1);
      $biner_y = rand(0, 1);
      $indexHuruf = rand(0, 25);

      
      if ($biner_x == 1) {
          $cuid .= strtoupper($array[$indexHuruf]);
      } else {
          $cuid .= rand(0, 9); 
      }
  }
  
  return $cuid;

}

class MySQL { 
  public $conn;

  // start construct class
  public function __construct($host, $user, $pass, $db) 
  {

    $this->conn = new mysqli($host, $user, $pass, $db);

    if ($this->conn->connect_error) {
      die("koneksi gagal:". $this->conn->connect_error);
    }
  }

  // mysql query : select
  public function mysql_select($table, $column = "*", $where = "")
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

  // mysql query : update
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
    $data = $stmt->execute();
    $stmt->close();
    return $data;
  }
  
  // mysql query : delete 
  public function mysql_delete($table, $column, $id)
  {
    $stmt = $this->conn->prepare(
        "DELETE FROM $table WHERE $column = ?"
    );

    $stmt->bind_param("i", $id);
    $data = $stmt->execute();
    $stmt->close();
    return $data;
  }
  
  // mysql kardidat : add 
  public function add_kandidat($nama, $visi, $misi, $image)
  {
    $stmt = $this->conn->prepare(
        "INSERT INTO tb_kardidat (nama, visi, misi, image)
         VALUES (?, ?, ?, ?)"
    );

    if (!$stmt) {
        die("Prepare Error: " . $this->conn->error);
    }

    $stmt->bind_param("ssss", $nama, $visi, $misi, $image);

    if (!$stmt->execute()) {
        die("Execute Error: " . $stmt->error);
    }
    $stmt->close();
    return true;
  }

  // mysql kardidat : select
  public function select_kardidat($where = "", $column = "*")
  {
    $sql = "SELECT $column FROM tb_kardidat";

    if (!empty($where)) {
        $sql .= " WHERE $where";
    }

    $result = $this->conn->query($sql);

    if (!$result)
    {
        return [];
    }

    return $result->fetch_all(MYSQLI_ASSOC);
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
    $data = $stmt->execute();
    $stmt->close();
    return $data;
  }

  // mysql kardidat : delete
  public function delete_kardidat($id)
  {

    // ubah value voted menjadi 0
    $stmt = $this->conn->prepare(
      "UPDATE tb_siswa SET voted = 0, status = 0 WHERE voted = ?");
    $stmt->bind_param('i', $id);
    $stmt->execute();

    // delete kardidat
    $stmt = $this->conn->prepare(
        "DELETE FROM tb_kardidat WHERE id = ?"
      );
    $stmt->bind_param("i", $id);
    $data = $stmt->execute();
    $stmt->close();
    return $data;
  }

  // mysql siswa : add
  public function add_siswa($token, $nama, $kelas)
  {
    $stmt = $this->conn->prepare(
      "INSERT INTO tb_siswa 
      (token, nama, kelas, status, voted) VALUE (?, ?, ?, 0, 0)");

    $stmt->bind_param("sss", $token, $nama, $kelas);
    $data = $stmt->execute();
    $stmt->close();
    return $data;
  }

  // mysql siswa : select
  public function select_siswa($where = "", $column = "*")
  {
    $sql = "SELECT $column FROM tb_siswa";

    if (!empty($where)) {
        $sql .= " WHERE $where";
    }

    $result = $this->conn->query($sql);

    if (!$result)
    {
        return [];
    }
    
    return $result->fetch_all(MYSQLI_ASSOC);
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
    $data = $stmt->execute();
    $stmt->close();
    return $data;
  }

  // mysql Login : siswa
  public function login_siswa($token)
  {

    if (empty($token)) {
      return false;
    }
    
    $stmt = $this->conn->prepare(
        "SELECT * FROM tb_siswa
        WHERE BINARY token = ?"
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
    $data = $result->fetch_assoc();
    $stmt->close();
    return $data;
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
    $data = $result->fetch_assoc();
    $stmt->close();
    return $data;
  }

  // mysql image : upload
  public function upload_image( $local_folder, $name_file, $post_file)
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

  // mysql fitur : voting persen
  public function persen_voting_siswa() 
  {
    $total_query = $this->conn->query("SELECT COUNT(*) as total FROM tb_siswa");
    $total = $total_query->fetch_assoc()['total'];

    $belum_query = $this->conn->query("SELECT COUNT(*) as count FROM tb_siswa WHERE status = 0");
    $belum = $belum_query->fetch_assoc()['count'];

    $sudah_query = $this->conn->query("SELECT COUNT(*) as count FROM tb_siswa WHERE status = 1");
    $sudah = $sudah_query->fetch_assoc()['count'];

    $persen_belum = ($total > 0) ? ($belum / $total) * 100 : 0;
    $persen_sudah = ($total > 0) ? ($sudah / $total) * 100 : 0;

    return [
        'total_siswa' => $total,
        'belum_voting' => $belum,
        'sudah_voting' => $sudah,
        'persen_belum' => round($persen_belum),
        'persen_sudah' => round($persen_sudah)
    ];
  }
  
  // mysql fitur : grafik
  public function get_data_grafik_voting() {
    
  // Query menggabungkan tb_kardidat dan menghitung jumlah suara dari tb_siswa berdasarkan 'voted'
    $query = "SELECT k.nama AS nama_kand, COUNT(s.voted) AS total_suara 
              FROM tb_kardidat k 
              LEFT JOIN tb_siswa s ON k.id = s.voted AND s.status = 1 
              GROUP BY k.id, k.nama";
              
    $result = $this->conn->query($query);
    
    $nama_kandidat = [];
    $value_voted = [];

    while ($row = $result->fetch_assoc()) {
        $nama_kandidat[] = $row['nama_kand'];     // Masukin nama kandidat ke array
        $value_voted[] = (int)$row['total_suara']; // Masukin jumlah suara ke array (dikonversi ke angka)
    }

    // Mengembalikan array yang berisi 2 array (nama dan value)
    return [
        'nama' => $nama_kandidat,
        'value' => $value_voted
    ];
  }
}

$host = "localhost";
$user = "root";
$pass = "";
$base = "db_piketos";

$conn = new MySQL($host, $user, $pass, $base);
