<?php
session_start();

// 1. Ambil dan bersihkan data input dari form
$judul     = trim($_POST['judul'] ?? '');
$pengarang = trim($_POST['pengarang'] ?? '');
$tahun     = $_POST['tahun'] ?? '';
$stok      = $_POST['stok'] ?? '';
$isbn      = trim($_POST['isbn'] ?? ''); // Input ISBN (opsional)

$errors = [];

// 2. Validasi Wajib Diisi & Rentang Nilai
if ($judul === '') {
    $errors[] = "Judul wajib diisi.";
}
if ($pengarang === '') {
    $errors[] = "Pengarang wajib diisi.";
}
if (!is_numeric($tahun) || $tahun < 1900 || $tahun > 2026) {
    $errors[] = "Tahun harus di antara 1900-2026.";
}
if (!is_numeric($stok) || $stok < 0) {
    $errors[] = "Stok tidak boleh negatif.";
}

// 3. Validasi ISBN (Soal 1): Jika diisi, hanya boleh angka dan tanda hubung (-)
if ($isbn !== '' && !preg_match('/^[0-9-]+$/', $isbn)) {
    $errors[] = "ISBN hanya boleh berisi angka dan tanda hubung (-).";
}

// 4. Penanganan Error (Jika ada error, kembalikan ke form)
if (!empty($errors)) {
    $_SESSION['flash'] = [
        'type' => 'error',
        'pesan' => implode(' ', $errors)
    ];
    header('Location: tambah.php');
    exit;
}

// 5. Simpan Data ke Session jika Valid
if (!isset($_SESSION['buku'])) {
    $_SESSION['buku'] = [];
}

$_SESSION['buku'][] = [
    'judul'     => $judul,
    'pengarang' => $pengarang,
    'tahun'     => (int) $tahun,
    'stok'      => (int) $stok,
    'isbn'      => $isbn
];

$_SESSION['flash'] = [
    'type'  => 'success',
    'pesan' => 'Buku berhasil ditambahkan.'
];

header('Location: list.php');
exit;