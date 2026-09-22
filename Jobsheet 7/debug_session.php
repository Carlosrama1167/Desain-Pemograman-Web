<?php
session_start();

$page_title = "Debug Session";
include __DIR__ . '/includes/header.php';

$flash = $_SESSION['flash'] ?? null;
unset($_SESSION['flash']);
?>

<section>
    <h2>Debug Data Session Server</h2>

    <!-- Tampilkan Notifikasi Flash Message jika ada -->
    <?php if ($flash): ?>
        <p class="flash flash-<?php echo htmlspecialchars($flash['type']); ?>">
            <?php echo htmlspecialchars($flash['pesan']); ?>
        </p>
    <?php endif; ?>

    <p>Berikut adalah seluruh isi variabel <code>$_SESSION</code> saat ini:</p>

    <!-- Display Raw Session -->
    <pre style="background: #f4f4f4; padding: 15px; border: 1px solid #ccc; border-radius: 5px; overflow-x: auto;"><?php print_r($_SESSION); ?></pre>

    <p style="margin-top: 20px;">
        <!-- Tombol Reset Data (Soal 4) -->
        <a href="reset_session.php" onclick="return confirm('Apakah Anda yakin ingin menghapus seluruh data session?');">
            <button type="button" style="background-color: #d9534f; color: white; border: none; padding: 10px 15px; border-radius: 4px; cursor: pointer;">
                Reset Data Session
            </button>
        </a>
    </p>
</section>

<?php include __DIR__ . '/includes/footer.php'; ?>