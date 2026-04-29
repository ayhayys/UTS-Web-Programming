<?php
require 'koneksi.php';
date_default_timezone_set('Asia/Jakarta');
$hari = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
$bulan = [1=>'Januari', 2=>'Februari', 3=>'Maret', 4=>'April', 5=>'Mei', 6=>'Juni', 7=>'Juli', 8=>'Agustus', 9=>'September', 10=>'Oktober', 11=>'November', 12=>'Desember'];
$sekarang = new DateTime();
$nama_hari = $hari[$sekarang->format('w')];
$tanggal = $sekarang->format('j');
$nama_bulan = $bulan[(int)$sekarang->format('n')];
$tahun = $sekarang->format('Y');
$jam = $sekarang->format('H:i');
$hari_tanggal = "$nama_hari, $tanggal $nama_bulan $tahun | $jam";

$judul = $_POST['judul'] ?? '';
$id_penulis = (int)$_POST['id_penulis'];
$id_kategori = (int)$_POST['id_kategori'];
$isi = $_POST['isi'] ?? '';
$gambar = '';

if (isset($_FILES['gambar']) && $_FILES['gambar']['error'] === 0) {
    $finfo = finfo_open(FILEINFO_MIME_TYPE);
    $mime = finfo_file($finfo, $_FILES['gambar']['tmp_name']);
    finfo_close($finfo);

    $allowed = ['image/jpeg', 'image/png', 'image/gif'];
    
    if (in_array($mime, $allowed) && $_FILES['gambar']['size'] <= 2097152) {
        $ext = pathinfo($_FILES['gambar']['name'], PATHINFO_EXTENSION);
        $gambar = uniqid() . '.' . $ext;
        move_uploaded_file($_FILES['gambar']['tmp_name'], 'uploads_artikel/' . $gambar);
    } else {
        echo json_encode(['status' => 'error', 'pesan' => 'Format file tidak diizinkan atau ukuran lebih dari 2MB']);
        exit;
    }
} else {
    echo json_encode(['status' => 'error', 'pesan' => 'Gambar artikel wajib diunggah']);
    exit;
}

$stmt = $conn->prepare("INSERT INTO artikel (id_penulis, id_kategori, judul, isi, gambar, hari_tanggal) VALUES (?, ?, ?, ?, ?, ?)");
$stmt->bind_param("iissss", $id_penulis, $id_kategori, $judul, $isi, $gambar, $hari_tanggal);
if ($stmt->execute()) echo json_encode(['status' => 'success']);
else echo json_encode(['status' => 'error', 'pesan' => $stmt->error]);
?>