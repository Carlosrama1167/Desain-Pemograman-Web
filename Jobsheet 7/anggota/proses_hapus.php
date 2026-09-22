<?php
session_start();

// Pengecekan parameter index dari URL
if (isset($_GET['index']) && is_numeric($_GET['index'])) {
    $index = (int) $_GET['index'];

    // Pengecekan apakah data anggota dengan index tersebut ada di dalam session
    if (isset($_SESSION['anggota'][$index])) {
        // Hapus elemen array berdasarkan index
        unset($_SESSION['anggota'][$index]);

        // Urutkan kembali index array agar tidak loncat (misal 0, 1, 2, ...)
        $_SESSION['anggota'] = array_values($_SESSION['anggota']);

        $_SESSION['flash'] = [
            'type' => 'success', 
            'pesan' => 'Data anggota berhasil dihapus.'
        ];
    } else {
        $_SESSION['flash'] = [
            'type' => 'error', 
            'pesan' => 'Data anggota tidak ditemukan.'
        ];
    }
} else {
    $_SESSION['flash'] = [
        'type' => 'error', 
        'pesan' => 'Permintaan tidak valid.'
    ];
}

// Redirect kembali ke daftar anggota
header('Location: list.php');
exit;