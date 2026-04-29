<?php
require 'koneksi.php';
$id = isset($_POST['id']) ? (int)$_POST['id'] : 0;
$judul = $_POST['judul'] ?? '';
$id_penulis = (int)$_POST['id_penulis'];
$id_kategori = (int)$_POST['id_kategori'];
$isi = $_POST['isi'] ?? '';

$stmtLama = $conn->prepare("SELECT gambar FROM artikel WHERE id = ?");
$stmtLama->bind_param("i", $id);
$stmtLama->execute();
$gambar = $stmtLama->get_result()->fetch_assoc()['gambar'];

if (isset($_FILES['gambar']) && $_FILES['gambar']['error'] === 0) {
    $finfo = finfo_open(FILEINFO_MIME_TYPE);
    $mime = finfo_file($finfo, $_FILES['gambar']['tmp_name']);
    finfo_close($finfo);

    $allowed = ['image/jpeg', 'image/png', 'image/gif'];
    
    if (in_array($mime, $allowed) && $_FILES['gambar']['size'] <= 2097152) { 
        $ext = pathinfo($_FILES['gambar']['name'], PATHINFO_EXTENSION);
        $gambarBaru = uniqid() . '.' . $ext;
        
        if (move_uploaded_file($_FILES['gambar']['tmp_name'], 'uploads_artikel/' . $gambarBaru)) {
            if (file_exists('uploads_artikel/' . $gambar)) {
                unlink('uploads_artikel/' . $gambar);
            }
            $gambar = $gambarBaru;
        }
    }
}

$stmt = $conn->prepare("UPDATE artikel SET id_penulis=?, id_kategori=?, judul=?, isi=?, gambar=? WHERE id=?");
$stmt->bind_param("iisssi", $id_penulis, $id_kategori, $judul, $isi, $gambar, $id);
if ($stmt->execute()) echo json_encode(['status' => 'success']);
else echo json_encode(['status' => 'error']);
?>