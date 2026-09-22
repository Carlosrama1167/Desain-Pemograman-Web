<?php
$page_title = "Edit Buku";
include __DIR__ . '/../includes/header.php';
require __DIR__ . '/../includes/koneksi.php';

$flash = $_SESSION['flash'] ?? null;
unset($_SESSION['flash']);

$id = $_GET['id'] ?? null;
if (!$id) {
    header('Location: list.php');
    exit;
}

// Ambil data lama dari database
$stmt = $pdo->prepare("SELECT * FROM buku WHERE id = :id");
$stmt->execute(['id' => $id]);
$buku = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$buku) {
    header('Location: list.php');
    exit;
}
?>

<section>
    <h2>Edit Buku</h2>

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

    <form id="form-tambah" method="post" action="proses_edit.php">
        <!-- Input Tersembunyi untuk Membawa ID -->
        <input type="hidden" name="id" value="<?php echo $buku['id']; ?>">

        <p>
            <label for="judul">Judul Buku</label><br>
            <input type="text" id="judul" name="judul" value="<?php echo htmlspecialchars($buku['judul']); ?>" required>
        </p>
        <p>
            <label for="pengarang">Pengarang</label><br>
            <input type="text" id="pengarang" name="pengarang" value="<?php echo htmlspecialchars($buku['pengarang']); ?>" required>
        </p>
        <p>
            <label for="tahun">Tahun Terbit</label><br>
            <input type="number" id="tahun" name="tahun" value="<?php echo htmlspecialchars($buku['tahun']); ?>" required>
        </p>
        <p>
            <label for="isbn">ISBN</label><br>
            <input type="text" id="isbn" name="isbn" value="<?php echo htmlspecialchars($buku['isbn'] ?? ''); ?>">
        </p>
        <p>
            <label for="stok">Stok</label><br>
            <input type="number" id="stok" name="stok" value="<?php echo htmlspecialchars($buku['stok']); ?>" required>
        </p>
        <p>
            <label for="kategori">Kategori</label><br>
            <select id="kategori" name="kategori">
                <?php foreach (['fiksi' => 'Fiksi', 'non-fiksi' => 'Non-Fiksi', 'referensi' => 'Referensi'] as $value => $label): ?>
                    <option value="<?php echo $value; ?>" <?php echo $buku['kategori'] === $value ? 'selected' : ''; ?>>
                        <?php echo $label; ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </p>
        <p>
            <button type="submit">Simpan Perubahan</button>
            <a href="list.php">Batal</a>
        </p>
    </form>
</section>

<?php include __DIR__ . '/../includes/footer.php'; ?>