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
    if (!$result) return [];
    return $result->fetch_all(MYSQLI_ASSOC);
  }

  // mysql query : update
  public function mysql_update($table, $id, $new_name)
  {
    $sql = "UPDATE $table SET nama = '$new_name' WHERE id = '$id'";
    return $this->conn->query($sql);
  }
  
  // mysql query : delete
  public function mysql_delete($table, $column, $id)
  {
    $sql = "DELETE FROM $table WHERE $column = '$id'";
    return $this->conn->query($sql);
  }
  
  // mysql kardidat : add
  public function add_kandidat($nama, $visi, $misi, $image)
  {
    $sql = "INSERT INTO tb_kardidat (nama, visi, misi, image) 
            VALUES ('$nama', '$visi', '$misi', '$image')";
    return $this->conn->query($sql);
  }

  // mysql kardidat : select
  public function select_kardidat($where = "", $column = "*")
  {
    $sql = "SELECT $column FROM tb_kardidat";
    if (!empty($where)) {
        $sql .= " WHERE $where";
    }
    $result = $this->conn->query($sql);
    if (!$result) return [];
    return $result->fetch_all(MYSQLI_ASSOC);
  }
  
  // mysql kardidat : update
  public function update_kardidat($id, $nama, $visi, $misi) 
  {
    $sql = "UPDATE tb_kardidat SET 
            nama = '$nama', visi = '$visi', misi = '$misi' 
            WHERE id = '$id'";
    return $this->conn->query($sql);
  }

  // mysql kardidat : delete
  public function delete_kardidat($id)
  {
    $sql_update = "UPDATE tb_siswa SET voted = 0, status = 0 WHERE voted = '$id'";
    $this->conn->query($sql_update);

    $sql_delete = "DELETE FROM tb_kardidat WHERE id = '$id'";
    return $this->conn->query($sql_delete);
  }

  // mysql siswa : add
  public function add_siswa($token, $nama, $kelas)
  {
    $sql = "INSERT INTO tb_siswa (token, nama, kelas, status, voted) 
            VALUES ('$token', '$nama', '$kelas', 0, 0)";
    return $this->conn->query($sql);
  }

  // mysql siswa : select
  public function select_siswa($where = "", $column = "*")
  {
    $sql = "SELECT $column FROM tb_siswa";
    if (!empty($where)) {
        $sql .= " WHERE $where";
    }
    $result = $this->conn->query($sql);
    if (!$result) return [];
    return $result->fetch_all(MYSQLI_ASSOC);
  }

  // mysql siswa : voting
  public function voting_kardidat($id, $voted)
  {
    $sql = "UPDATE tb_siswa SET status = 1, voted = '$voted' WHERE token = '$id'";
    return $this->conn->query($sql);
  }

  // mysql Login : siswa
  public function login_siswa($token)
  {
    if (empty($token)) return false;
    
    $sql = "SELECT * FROM tb_siswa WHERE BINARY token = '$token'";
    $result = $this->conn->query($sql);

    if (!$result || $result->num_rows === 0) return false;
    return $result->fetch_assoc();
  }
  
  // mysql login : admin
  public function login_admin($token)
  {
    $sql = "SELECT * FROM tb_admin WHERE password = '$token'";
    $result = $this->conn->query($sql);

    if (!$result || $result->num_rows === 0) return false;
    return $result->fetch_assoc();
  }

  // mysql image : upload 
  public function upload_image( $local_folder, $name_file, $post_file)
  {
    $file_name = $_FILES[$post_file]['name'];
    $file_size = $_FILES[$post_file]['size'];
    $file_tmp = $_FILES[$post_file]['tmp_name'];
    
    $extension = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
    $validasi_type = ['jpg', 'jpeg', 'png', 'webp'];
    
    if (!in_array($extension , $validasi_type)) return false;
    if ($file_size >= 2 * 1024 * 1024) return false;

    $new_name = "$name_file" . ".$extension";
    $destination = rtrim($local_folder, "/\\") . DIRECTORY_SEPARATOR . $new_name;
    
    if (move_uploaded_file($file_tmp, $destination)) {
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
    
    $kardidat_query = $this->conn->query("SELECT COUNT(*) as count FROM tb_kardidat");
    $kardidat = $kardidat_query->fetch_assoc()['count'];

    $persen_belum = ($total > 0) ? ($belum / $total) * 100 : 0;
    $persen_sudah = ($total > 0) ? ($sudah / $total) * 100 : 0;

    return [
        'total_siswa' => $total,
        'belum_voting' => $belum,
        'sudah_voting' => $sudah,
        'persen_belum' => round($persen_belum),
        'persen_sudah' => round($persen_sudah),
        'kardidat' => $kardidat
    ];
  }
  
  // mysql : grafik kardidat 
  public function get_data_grafik_voting() 
  {  
    $query = "SELECT k.nama AS nama_kand, COUNT(s.voted) AS total_suara 
              FROM tb_kardidat k 
              LEFT JOIN tb_siswa s ON k.id = s.voted AND s.status = 1 
              GROUP BY k.id, k.nama";
              
    $result = $this->conn->query($query);
    $nama_kandidat = [];
    $value_voted = [];
  
    if ($result) {
        while ($row = $result->fetch_assoc()) {
            $nama_kandidat[] = $row['nama_kand'];     
            $value_voted[] = (int)$row['total_suara']; 
        }
    }

    return [
        'nama' => $nama_kandidat,
        'value' => $value_voted
    ];
  }

  // mysql : get paslon results
  public function get_paslon_results() {
    $query = "SELECT k.id, k.nama AS nama_kand, COUNT(s.voted) AS total_suara 
              FROM tb_kardidat k 
              LEFT JOIN tb_siswa s ON k.id = s.voted AND s.status = 1 
              GROUP BY k.id, k.nama
              ORDER BY k.id ASC";
              
    $result = $this->conn->query($query);
    
    $temp_data = [];
    $total_semua_suara = 0;
    $color_list = ['#2563EB', '#FACC15', '#06B6D4', '#10B981', '#EF4444', '#8B5CF6'];

    if ($result) {
        $index = 0;
        while ($row = $result->fetch_assoc()) {
            $suara = (int)$row['total_suara'];
            $total_semua_suara += $suara;
            
            $temp_data[] = [
                'no_urut' => str_pad($index + 1, 2, '0', STR_PAD_LEFT),
                'nama'    => $row['nama_kand'],
                'suara'   => $suara,
                'persen'  => 0, 
                'warna'   => $color_list[$index % count($color_list)]
            ];
            $index++;
        }
    }

    $paslon_results = [];
    foreach ($temp_data as $data) {
        if ($total_semua_suara > 0) {
            $data['persen'] = round(($data['suara'] / $total_semua_suara) * 100, 1);
        }
        $paslon_results[] = $data;
    }
    return $paslon_results;
  }
}

$host = "localhost";
$user = "root";
$pass = "";
$base = "db_piketos";

$conn = new MySQL($host, $user, $pass, $base);
?>