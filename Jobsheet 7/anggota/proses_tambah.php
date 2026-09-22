<?php
session_start();

$nama = trim($_POST['nama'] ?? '');
$no_anggota = trim($_POST['no_anggota'] ?? '');
$alamat = trim($_POST['alamat'] ?? '');
$no_hp = trim($_POST['no_hp'] ?? '');

$errors = [];

// Validasi tiap kolom secara terpisah
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

// Cek duplikasi No. Anggota
if ($no_anggota !== '') {
    $daftarAnggota = $_SESSION['anggota'] ?? [];
    foreach ($daftarAnggota as $item) {
        if (isset($item['no_anggota']) && $item['no_anggota'] === $no_anggota) {
            $errors[] = "No. Anggota sudah terdaftar.";
            break;
        }
    }
}

// Jika ada error, simpan array $errors ke session
if (!empty($errors)) {
    $_SESSION['flash'] = [
        'type' => 'error',
        'pesan' => $errors // Menyimpan array pesan error
    ];
    header('Location: tambah.php');
    exit;
}

// Jika sukses simpan data
if (!isset($_SESSION['anggota']) || !is_array($_SESSION['anggota'])) {
    $_SESSION['anggota'] = [];
}

$_SESSION['anggota'][] = [
    'nama' => $nama,
    'no_anggota' => $no_anggota,
    'alamat' => $alamat,
    'no_hp' => $no_hp,
];

$_SESSION['flash'] = [
    'type' => 'success',
    'pesan' => 'Anggota berhasil ditambahkan.'
];

header('Location: list.php');
exit;