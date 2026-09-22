<?php
$page_title = "Daftar Buku";
include __DIR__ . '/../includes/header.php';
require __DIR__ . '/../includes/koneksi.php';

$flash = $_SESSION['flash'] ?? null;
unset($_SESSION['flash']);

// 1. Pengaturan Pagination & Pencarian
$perPage = 5;
$page    = max(1, (int) ($_GET['page'] ?? 1));
$offset  = ($page - 1) * $perPage;
$keyword = trim($_GET['q'] ?? '');

// 2. Query Data Berdasarkan Keyword Pencarian
if ($keyword !== '') {
    // Hitung Total Data Terfilter
    $hitung = $pdo->prepare("SELECT COUNT(*) FROM buku WHERE judul ILIKE :kw");
    $hitung->execute(['kw' => '%' . $keyword . '%']);
    $totalRows = $hitung->fetchColumn();

    // Ambil Data Terfilter dengan LIMIT & OFFSET
    $stmt = $pdo->prepare("SELECT * FROM buku WHERE judul ILIKE :kw ORDER BY id DESC LIMIT :limit OFFSET :offset");
    $stmt->bindValue('kw', '%' . $keyword . '%');
} else {
    // Hitung Total Semua Data
    $totalRows = $pdo->query("SELECT COUNT(*) FROM buku")->fetchColumn();

    // Ambil Semua Data dengan LIMIT & OFFSET
    $stmt = $pdo->prepare("SELECT * FROM buku ORDER BY id DESC LIMIT :limit OFFSET :offset");
}

$stmt->bindValue('limit', $perPage, PDO::PARAM_INT);
$stmt->bindValue('offset', $offset, PDO::PARAM_INT);
$stmt->execute();
$daftarBuku = $stmt->fetchAll(PDO::FETCH_ASSOC);

$totalPages = max(1, (int) ceil($totalRows / $perPage));
?>

<section>
    <h2>Daftar Buku</h2>
    <?php if ($flash): ?>
        <p class="flash flash-<?php echo htmlspecialchars($flash['type']); ?>"><?php echo htmlspecialchars($flash['pesan']); ?></p>
    <?php endif; ?>

    <!-- Form Pencarian Sisi Server -->
    <div class="search-box">
        <form method="get" action="list.php">
            <div>
                <label for="search-input">Cari Judul Buku</label><br>
                <input type="text" id="search-input" name="q" value="<?php echo htmlspecialchars($keyword); ?>" placeholder="Ketik judul buku...">
            </div>
            <button type="submit">Cari</button>
        </form>
    </div>

    <div class="table-responsive">
    <table>
        <thead>
            <tr>
                <th>Judul</th>
                <th>Pengarang</th>
                <th>Tahun</th>
                <th>ISBN</th>
                <th>Stok</th>
                <th>Kategori</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($daftarBuku)): ?>
            <tr>
                <td colspan="7">Belum ada data buku.</td>
            </tr>
            <?php else: ?>
                <?php foreach ($daftarBuku as $buku): ?>
                <tr>
                    <td><?php echo htmlspecialchars($buku['judul']); ?></td>
                    <td><?php echo htmlspecialchars($buku['pengarang']); ?></td>
                    <td><?php echo htmlspecialchars($buku['tahun']); ?></td>
                    <!-- Pengecekan aman untuk ISBN (jika null/kosong diganti '-') -->
                    <td><?php echo htmlspecialchars(!empty($buku['isbn']) ? $buku['isbn'] : '-'); ?></td>
                    <td><?php echo htmlspecialchars($buku['stok']); ?></td>
                    <!-- Pengecekan aman untuk Kategori -->
                    <td><?php echo htmlspecialchars(!empty($buku['kategori']) ? $buku['kategori'] : '-'); ?></td>
                    <td>
                        <!-- Tautan Edit -->
                        <a href="edit.php?id=<?php echo $buku['id']; ?>" class="btn-edit">Edit</a>
                        
                        <!-- Form Hapus (Khusus POST demi keamanan) -->
                        <form class="form-hapus" method="post" action="hapus.php">
                            <input type="hidden" name="id" value="<?php echo $buku['id']; ?>">
                            <button type="submit" class="btn-hapus">Hapus</button>
                        </form>
                    </td>
                </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
    </div>

    <!-- Navigasi Pagination -->
    <?php if ($totalPages > 1): ?>
    <nav class="pagination">
        <?php for ($i = 1; $i <= $totalPages; $i++): ?>
            <a href="list.php?page=<?php echo $i; ?><?php echo $keyword !== '' ? '&q=' . urlencode($keyword) : ''; ?>"
               class="<?php echo $i === $page ? 'active' : ''; ?>">
                <?php echo $i; ?>
            </a>
        <?php endfor; ?>
    </nav>
    <?php endif; ?>
</section>

<?php include __DIR__ . '/../includes/footer.php'; ?>