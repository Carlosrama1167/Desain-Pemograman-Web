<?php
$page_title = "Tambah Anggota";
include __DIR__ . '/../includes/header.php';

$flash = $_SESSION['flash'] ?? null;
unset($_SESSION['flash']);
?>
<section>
    <h2>Tambah Anggota</h2>

    <?php if ($flash): ?>
        <div class="flash flash-<?php echo htmlspecialchars($flash['type']); ?>">
            <?php if (is_array($flash['pesan'])): ?>
                <ul>
                    <?php foreach ($flash['pesan'] as $pesanError): ?>
                        <li><?php echo htmlspecialchars($pesanError); ?></li>
                    <?php endforeach; ?>
                </ul>
            <?php else: ?>
                <p><?php echo htmlspecialchars($flash['pesan']); ?></p>
            <?php endif; ?>
        </div>
    <?php endif; ?>

    <form id="form-tambah" method="post" action="proses_tambah.php">
        <p>
            <label for="nama">Nama</label><br>
            <input type="text" id="nama" name="nama">
        </p>
        <p>
            <label for="no_anggota">No. Anggota</label><br>
            <input type="text" id="no_anggota" name="no_anggota">
        </p>
        <p>
            <label for="alamat">Alamat</label><br>
            <input type="text" id="alamat" name="alamat">
        </p>
        <p>
            <label for="no_hp">No. HP</label><br>
            <input type="text" id="no_hp" name="no_hp">
        </p>
        <p>
            <button type="submit">Simpan</button>
        </p>
    </form>
</section>
<?php include __DIR__ . '/../includes/footer.php'; ?>