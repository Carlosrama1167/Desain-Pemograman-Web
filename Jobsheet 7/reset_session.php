<?php
// 1. Inisialisasi session yang sedang berjalan
session_start();

// 2. Kosongkan semua isi array $_SESSION
$_SESSION = array();

// 3. Hapus cookie session dari peramban/browser jika ada
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(
        session_name(),
        '',
        time() - 42000,
        $params["path"],
        $params["domain"],
        $params["secure"],
        $params["httponly"]
    );
}

// 4. Hancurkan data session di memori server
session_destroy();

// 5. Jalankan session baru khusus untuk mengirim flash message pemberitahuan
session_start();
$_SESSION['flash'] = [
    'type'  => 'success',
    'pesan' => 'Seluruh data session berhasil dibersihkan.'
];

// 6. Redirect kembali ke halaman debug_session.php
header('Location: debug_session.php');
exit;