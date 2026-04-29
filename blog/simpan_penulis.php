<?php
require 'koneksi.php';
$depan = $_POST['nama_depan'] ?? '';
$belakang = $_POST['nama_belakang'] ?? '';
$username = $_POST['user_name'] ?? '';
$password = password_hash($_POST['password'], PASSWORD_BCRYPT);
$foto = 'default.png';

if (isset($_FILES['foto']) && $_FILES['foto']['error'] === 0) {
    $finfo = finfo_open(FILEINFO_MIME_TYPE);
    $mime = finfo_file($finfo, $_FILES['foto']['tmp_name']);
    finfo_close($finfo);

    $allowed = ['image/jpeg', 'image/png', 'image/gif'];
    
    if (in_array($mime, $allowed) && $_FILES['foto']['size'] <= 2097152) {
        $ext = pathinfo($_FILES['foto']['name'], PATHINFO_EXTENSION);
        $foto = uniqid() . '.' . $ext;
        move_uploaded_file($_FILES['foto']['tmp_name'], 'uploads_penulis/' . $foto);
    }
}

$stmt = $conn->prepare("INSERT INTO penulis (nama_depan, nama_belakang, user_name, password, foto) VALUES (?, ?, ?, ?, ?)");
$stmt->bind_param("sssss", $depan, $belakang, $username, $password, $foto);
if ($stmt->execute()) {
    echo json_encode(['status' => 'success']);
} else {
    echo json_encode(['status' => 'error', 'pesan' => $stmt->error]);
}
?>