<?php
session_start();
include 'koneksi.php';

if (!isset($_SESSION['login']) || $_SESSION['role'] != 'admin') {
    header("Location: index.php");
    exit();
}

if (isset($_GET['aksi']) && isset($_GET['id'])) {
    $aksi = $_GET['aksi'];
    $id   = $_GET['id'];

    if ($aksi == 'terima') {
        mysqli_query($koneksi, "UPDATE pembayaran SET status='diterima' WHERE id=$id");
        $p = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM pembayaran WHERE id=$id"));
        mysqli_query($koneksi, "UPDATE users SET kamar=kamar WHERE id={$p['user_id']}");
    } elseif ($aksi == 'tolak') {
        mysqli_query($koneksi, "UPDATE pembayaran SET status='ditolak' WHERE id=$id");
    }

    header("Location: admin.php?hal=pembayaran");
    exit();
}

$total_kamar   = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(*) as total FROM kamar"))['total'];
$kamar_terisi  = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(*) as total FROM kamar WHERE status='terisi'"))['total'];
$tunggakan     = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(*) as total FROM pembayaran WHERE status='menunggu'"))['total'];

$data_kamar = mysqli_query($koneksi, "SELECT * FROM kamar ORDER BY no_kamar");

$data_penghuni = mysqli_query($koneksi, "
    SELECT u.nama, u.kamar,
        CASE
            WHEN (SELECT COUNT(*) FROM pembayaran p WHERE p.user_id = u.id AND p.status = 'menunggu') > 0
            THEN 'menunggak'
            ELSE 'lunas'
        END as status_bayar
    FROM users u
    WHERE u.role = 'user' AND u.kamar IS NOT NULL
    ORDER BY u.kamar
");

$data_pembayaran = mysqli_query($koneksi, "
    SELECT p.*, u.nama, u.kamar
    FROM pembayaran p
    JOIN users u ON p.user_id = u.id
    WHERE p.status = 'menunggu'
    ORDER BY p.tanggal DESC
");

$data_laporan = mysqli_query($koneksi, "
    SELECT l.*, u.nama, u.kamar
    FROM laporan l
    JOIN users u ON l.user_id = u.id
    ORDER BY l.tanggal DESC
");

$hal_aktif = isset($_GET['hal']) ? $_GET['hal'] : 'dashboard';

$pesan_profil = "";
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['simpan_profil'])) {
    $nama  = $_POST['nama'];
    $email = $_POST['email'];
    $hp    = $_POST['hp'];
    $id    = $_SESSION['id'];

    mysqli_query($koneksi, "UPDATE users SET nama='$nama', email='$email', hp='$hp' WHERE id=$id");

    $_SESSION['nama']  = $nama;
    $_SESSION['email'] = $email;
    $_SESSION['hp']    = $hp;

    $pesan_profil = "✅ Profil berhasil disimpan!";
    $hal_aktif = 'profil';
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SakuKost - Admin</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="main-layout">

    <nav class="sidebar">
        <div class="sidebar-header">
            <div class="logo-icon">🏠</div>
            <h3>SakuKost</h3>
            <p>Panel Admin</p>
        </div>

        <div class="sidebar-user">
            <div class="avatar">A</div>
            <div class="info">
                <div class="nama"><?= $_SESSION['nama'] ?></div>
                <div class="role">Pemilik Kost</div>
            </div>
        </div>
