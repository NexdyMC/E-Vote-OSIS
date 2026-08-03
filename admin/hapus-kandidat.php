<?php

require_once __DIR__ . '/../api/conn.php';

$folderTujuan = __DIR__ . '/../upload/photo';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['id'])) {
    $id = (int) $_POST['id'];
    
    $kandidat = $conn->select_kandidat("id = $id LIMIT 1");
    
    if (!empty($kandidat)) {
        foreach ($kandidat as $key) {

            if (!empty($key['image'])) {
                $conn->delete_image($folderTujuan, $key['image']);
            }
        }
    }
    
    $conn->delete_kandidat($id);
}

header('Location: kandidat.php?v=true');
exit;