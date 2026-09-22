<?php
session_start();

// Memuat file koneksi database
require __DIR__ . '/../includes/koneksi.php';

$judul     = trim($_POST['judul'] ?? '');
$pengarang = trim($_POST['pengarang'] ?? '');
$tahun     = trim($_POST['tahun'] ?? '');
$isbn      = trim($_POST['isbn'] ?? '');
$stok       = trim($_POST['stok'] ?? '');
$kategori  = trim($_POST['kategori'] ?? '');

$errors = [];

// Validasi input (tidak berubah dari Jobsheet 07)
if ($judul === '') {
    $errors[] = "Judul buku wajib diisi.";
}
if ($pengarang === '') {
    $errors[] = "Pengarang wajib diisi.";
}
if ($tahun === '') {
    $errors[] = "Tahun terbit wajib diisi.";
} elseif (!is_numeric($tahun)) {
    $errors[] = "Tahun terbit harus berupa angka.";
}
if ($stok === '') {
    $errors[] = "Stok wajib diisi.";
} elseif (!is_numeric($stok) || (int)$stok < 0) {
    $errors[] = "Stok harus berupa angka non-negatif.";
}

// Jika terdapat error validasi
if (!empty($errors)) {
    $_SESSION['flash'] = [
        'type' => 'error',
        'pesan' => $errors
    ];
    header('Location: tambah.php');
    exit;
}

// SIMPAN KE DATABASE POSTGRESQL MENGGUNAKAN PREPARED STATEMENT
$stmt = $pdo->prepare(
    "INSERT INTO buku (judul, pengarang, tahun, isbn, stok, kategori) 
     VALUES (:judul, :pengarang, :tahun, :isbn, :stok, :kategori) 
     RETURNING id"
);

$stmt->execute([
    'judul'     => $judul,
    'pengarang' => $pengarang,
    'tahun'     => (int) $tahun,
    'isbn'      => $isbn,
    'stok'      => (int) $stok,
    'kategori'  => $kategori,
]);

// Set flash message sukses
$_SESSION['flash'] = [
    'type' => 'success',
    'pesan' => 'Buku berhasil ditambahkan.'
];

header('Location: list.php');
exit;