<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Menghitung Base URL secara presisi berdasarkan posisi file header.php
$protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http";
$host = $_SERVER['HTTP_HOST'];

// Menghitung folder root tempat proyek ini berada (naik 1 level dari folder includes)
$doc_root = str_replace('\\', '/', $_SERVER['DOCUMENT_ROOT']);
$dir_path = str_replace('\\', '/', dirname(__DIR__));
$relative_path = str_replace($doc_root, '', $dir_path);

$base = rtrim($protocol . "://" . $host . $relative_path, '/') . '/';

$page_title = $page_title ?? 'SIMPUS Mini';
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $page_title; ?> - SIMPUS Mini</title>
    
    <!-- Panggilan CSS Dinamis -->
    <link rel="stylesheet" href="<?php echo $base; ?>assets/css/style.css">
</head>
<body>
    <header>
        <h1>SIMPUS Mini (PHP)</h1>
        <p>Sistem Informasi Manajemen Perpustakaan Mini</p>
        <button id="nav-toggle-btn" class="nav-toggle-label" aria-label="Buka menu">☰ Menu</button>
        <nav id="main-nav">
            <ul>
                <li><a href="<?php echo $base; ?>index.php">Beranda</a></li>
                <li><a href="<?php echo $base; ?>buku/list.php">Daftar Buku</a></li>
                <li><a href="<?php echo $base; ?>buku/tambah.php">Tambah Buku</a></li>
                <li><a href="<?php echo $base; ?>anggota/list.php">Daftar Anggota</a></li>
                <li><a href="<?php echo $base; ?>anggota/tambah.php">Tambah Anggota</a></li>
            </ul>
        </nav>
    </header>
    <main>