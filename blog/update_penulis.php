<?php
require 'koneksi.php';
$id = isset($_POST['id']) ? (int)$_POST['id'] : 0;
$depan = $_POST['nama_depan'] ?? '';
$belakang = $_POST['nama_belakang'] ?? '';
$username = $_POST['user_name'] ?? '';

$stmtLama = $conn->prepare("SELECT password, foto FROM penulis WHERE id = ?");
$stmtLama->bind_param("i", $id);
$stmtLama->execute();
$dataLama = $stmtLama->get_result()->fetch_assoc();

$password = !empty($_POST['password']) ? password_hash($_POST['password'], PASSWORD_BCRYPT) : $dataLama['password'];
$foto = $dataLama['foto'];

if (isset($_FILES['foto']) && $_FILES['foto']['error'] === 0) {
    $finfo = finfo_open(FILEINFO_MIME_TYPE);
    $mime = finfo_file($finfo, $_FILES['foto']['tmp_name']);
    finfo_close($finfo);

    $allowed = ['image/jpeg', 'image/png', 'image/gif'];
    
    if (in_array($mime, $allowed) && $_FILES['foto']['size'] <= 2097152) {
        $ext = pathinfo($_FILES['foto']['name'], PATHINFO_EXTENSION);
        $fotoBaru = uniqid() . '.' . $ext;
        
        if (move_uploaded_file($_FILES['foto']['tmp_name'], 'uploads_penulis/' . $fotoBaru)) {
            if ($foto != 'default.png' && file_exists('uploads_penulis/' . $foto)) {
                unlink('uploads_penulis/' . $foto);
            }
            $foto = $fotoBaru;
        }
    }
}

$stmt = $conn->prepare("UPDATE penulis SET nama_depan=?, nama_belakang=?, user_name=?, password=?, foto=? WHERE id=?");
$stmt->bind_param("sssssi", $depan, $belakang, $username, $password, $foto, $id);
if ($stmt->execute()) echo json_encode(['status' => 'success']);
else echo json_encode(['status' => 'error', 'pesan' => $stmt->error]);
?>