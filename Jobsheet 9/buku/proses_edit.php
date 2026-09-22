<?php
session_start();
require __DIR__ . '/../includes/koneksi.php';

$id        = $_POST['id'] ?? null;
$judul     = trim($_POST['judul'] ?? '');
$pengarang = trim($_POST['pengarang'] ?? '');
$tahun     = trim($_POST['tahun'] ?? '');
$isbn      = trim($_POST['isbn'] ?? '');
$stok      = trim($_POST['stok'] ?? '');
$kategori  = trim($_POST['kategori'] ?? '');

if (!$id) {
    header('Location: list.php');
    exit;
}

$errors = [];

if ($judul === '') $errors[] = "Judul buku wajib diisi.";
if ($pengarang === '') $errors[] = "Pengarang wajib diisi.";
if ($tahun === '' || !is_numeric($tahun)) $errors[] = "Tahun terbit harus berupa angka.";
if ($stok === '' || !is_numeric($stok) || (int)$stok < 0) $errors[] = "Stok harus berupa angka non-negatif.";

if (!empty($errors)) {
    $_SESSION['flash'] = [
        'type' => 'error',
        'pesan' => $errors
    ];
    header('Location: edit.php?id=' . urlencode($id));
    exit;
}

// Jalankan Perintah UPDATE
$stmt = $pdo->prepare(
    "UPDATE buku 
     SET judul = :judul, pengarang = :pengarang, tahun = :tahun, 
         isbn = :isbn, stok = :stok, kategori = :kategori 
     WHERE id = :id"
);

$stmt->execute([
    'judul'     => $judul,
    'pengarang' => $pengarang,
    'tahun'     => (int) $tahun,
    'isbn'      => $isbn,
    'stok'      => (int) $stok,
    'kategori'  => $kategori,
    'id'        => $id,
]);

$_SESSION['flash'] = [
    'type' => 'success',
    'pesan' => 'Data buku berhasil diperbarui.'
];

header('Location: list.php');
exit;