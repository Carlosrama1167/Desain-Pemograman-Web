<?php
session_start();

// Pengecekan parameter index di URL
if (isset($_GET['index']) && is_numeric($_GET['index'])) {
    $index = (int) $_GET['index'];

    // Cek apakah data buku dengan index tersebut ada di session
    if (isset($_SESSION['buku'][$index])) {
        // Hapus elemen array berdasarkan index
        unset($_SESSION['buku'][$index]);

        // Re-index array agar urutan index tetap berurutan (0, 1, 2, ...)
        $_SESSION['buku'] = array_values($_SESSION['buku']);

        $_SESSION['flash'] = [
            'type' => 'success', 
            'pesan' => 'Buku berhasil dihapus.'
        ];
    } else {
        $_SESSION['flash'] = [
            'type' => 'error', 
            'pesan' => 'Data buku tidak ditemukan.'
        ];
    }
} else {
    $_SESSION['flash'] = [
        'type' => 'error', 
        'pesan' => 'Permintaan tidak valid.'
    ];
}

// Redirect kembali ke halaman list.php
header('Location: list.php');
exit;