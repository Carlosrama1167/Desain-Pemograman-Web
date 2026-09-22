<?php
session_start();
require __DIR__ . '/../includes/koneksi.php';

$id         = $_POST['id'] ?? null;
$nama       = trim($_POST['nama'] ?? '');
$no_anggota = trim($_POST['no_anggota'] ?? '');
$alamat     = trim($_POST['alamat'] ?? '');
$no_hp      = trim($_POST['no_hp'] ?? '');

if (!$id) {
    header('Location: list.php');
    exit;
}

$errors = [];

if ($nama === '') {
    $errors[] = "Nama wajib diisi.";
}
if ($no_anggota === '') {
    $errors[] = "No. Anggota wajib diisi.";
}
if ($no_hp !== '' && !preg_match('/^[0-9]+$/', $no_hp)) {
    $errors[] = "No. HP hanya boleh berisi angka.";
}

if (!empty($errors)) {
    $_SESSION['flash'] = [
        'type' => 'error',
        'pesan' => $errors
    ];
    header('Location: edit.php?id=' . urlencode($id));
    exit;
}

try {
    // Jalankan Perintah UPDATE
    $stmt = $pdo->prepare(
        "UPDATE anggota 
         SET nama = :nama, no_anggota = :no_anggota, alamat = :alamat, no_hp = :no_hp 
         WHERE id = :id"
    );

    $stmt->execute([
        'nama'       => $nama,
        'no_anggota' => $no_anggota,
        'alamat'     => $alamat,
        'no_hp'      => $no_hp,
        'id'         => $id,
    ]);

    $_SESSION['flash'] = [
        'type' => 'success',
        'pesan' => 'Data anggota berhasil diperbarui.'
    ];

    header('Location: list.php');
    exit;

} catch (PDOException $e) {
    // Tangani error jika no_anggota bentrok dengan anggota lain
    if ($e->getCode() === '23505') {
        $_SESSION['flash'] = [
            'type' => 'error',
            'pesan' => "No. Anggota '{$no_anggota}' sudah digunakan oleh anggota lain."
        ];
    } else {
        $_SESSION['flash'] = [
            'type' => 'error',
            'pesan' => 'Gagal memperbarui data: ' . $e->getMessage()
        ];
    }
    header('Location: edit.php?id=' . urlencode($id));
    exit;
}