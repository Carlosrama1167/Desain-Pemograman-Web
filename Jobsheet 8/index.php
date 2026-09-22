<?php
session_start();

$page_title = "Beranda";
include __DIR__ . '/includes/header.php';

// 1. Panggil koneksi database PostgreSQL
require __DIR__ . '/includes/koneksi.php';

// 2. Ambil total buku dan anggota lewat query COUNT(*)
$totalBuku = $pdo->query("SELECT COUNT(*) FROM buku")->fetchColumn();
$totalAnggota = $pdo->query("SELECT COUNT(*) FROM anggota")->fetchColumn();

// 3. TUTUP TAG PHP DENGAN SEBELUM MENULISKAN HTML

?>

<section>
    <h2>Selamat Datang di Sistem Perpustakaan Mini</h2>
    <p>Aplikasi sederhana untuk mengelola data buku dan anggota perpustakaan</p>
</section>

<section>
    <h2>Ringkasan</h2>
    <article>
        <h3>Total Buku</h3>
        <p><?php echo $totalBuku; ?></p>
    </article>
    <article>
        <h3>Total Anggota</h3>
        <p><?php echo $totalAnggota; ?></p>
    </article>
    <article>
        <h3>Sedang Pinjam</h3>
        <p>0</p>
    </article>
</section>

<?php include __DIR__ . '/includes/footer.php'; ?>