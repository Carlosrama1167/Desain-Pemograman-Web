<?php
session_start();

// Memuat file koneksi database PostgreSQL
require __DIR__ . '/../includes/koneksi.php';

$nama       = trim($_POST['nama'] ?? '');
$no_anggota = trim($_POST['no_anggota'] ?? '');
$alamat     = trim($_POST['alamat'] ?? '');
$no_hp      = trim($_POST['no_hp'] ?? '');

$errors = [];

// Validasi tiap kolom secara terpisah (tetap sama dari Jobsheet 7)
if ($nama === '') {
    $errors[] = "Nama wajib diisi.";
}
if ($no_anggota === '') {
    $errors[] = "No. Anggota wajib diisi.";
}
if ($alamat === '') {
    $errors[] = "Alamat wajib diisi.";
}
if ($no_hp === '') {
    $errors[] = "No. HP wajib diisi.";
} elseif (!preg_match('/^[0-9]+$/', $no_hp)) {
    $errors[] = "No. HP hanya boleh berisi angka.";
}

// Jika ada error validasi, kembalikan ke form tambah
if (!empty($errors)) {
    $_SESSION['flash'] = [
        'type' => 'error',
        'pesan' => $errors
    ];
    header('Location: tambah.php');
    exit;
}

// MENYIMPAN KE DATABASE POSTGRESQL MENGGUNAKAN PREPARED STATEMENT
$stmt = $pdo->prepare(
    "INSERT INTO anggota (nama, no_anggota, alamat, no_hp) 
     VALUES (:nama, :no_anggota, :alamat, :no_hp) 
     RETURNING id"
);

$stmt->execute([
    'nama'       => $nama,
    'no_anggota' => $no_anggota,
    'alamat'     => $alamat,
    'no_hp'      => $no_hp,
]);

// Set notifikasi sukses
$_SESSION['flash'] = [
    'type' => 'success',
    'pesan' => 'Anggota berhasil ditambahkan.'
];

header('Location: list.php');
exit;