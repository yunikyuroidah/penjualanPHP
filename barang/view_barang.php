<?php
session_start();
require "../koneksi.php";
require_once "../hash_util.php";

$results_per_page = 10;
$page = isset($_GET['page']) ? (int) $_GET['page'] : 1;
$page = $page < 1 ? 1 : $page;

$allBarangQuery = mysqli_query($conn, "SELECT * FROM barang ORDER BY id_barang ASC");
$barangRows = [];
while ($row = mysqli_fetch_assoc($allBarangQuery)) {
    $barangRows[] = $row;
}

$hashTable = buildHashTable($barangRows, 'nama_barang');
$flattenBarang = flattenHashTable($hashTable);
$lookupKeyword = '';
$lookupResults = array_slice($flattenBarang, 0, 5);

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['lookup_keyword'])) {
    $lookupKeyword = trim($_POST['lookup_keyword']);
    $lookupResults = hashTableSearch($hashTable, $lookupKeyword, 'nama_barang');
    if ($lookupKeyword === '') {
        $lookupResults = array_slice($flattenBarang, 0, 5);
    }
}

$total_records = count($barangRows);
$total_pages = $total_records > 0 ? (int) ceil($total_records / $results_per_page) : 1;

if ($page > $total_pages) {
    $page = $total_pages;
}

$start_from = ($page - 1) * $results_per_page;
$displayedBarang = array_slice($barangRows, $start_from, $results_per_page);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Barang - Sistem Penjualan</title>
    <link rel="stylesheet" href="../style.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <script>
        function confirmDelete() {
            return confirm("Apakah Anda yakin ingin menghapus data ini?");
        }
    </script>
</head>
<body>
    <div class="container">
        <div class="header">
            <div class="welcome-text">
                <i class="fas fa-user"></i>
                Selamat Datang, <strong><?php echo $_SESSION['username']; ?></strong>!
            </div>
            <a href="../logout.php" class="logout-btn">
                <i class="fas fa-sign-out-alt"></i> Keluar
            </a>
        </div>

        <div id="nav">
            <a href="../transaksi/index.php"><i class="fas fa-shopping-cart"></i> Form Transaksi</a>
            <a href="input_barang.php"><i class="fas fa-plus"></i> Form Barang</a>
        </div>

        <h1><i class="fas fa-boxes"></i> Data Master Barang</h1>

        <div class="card" style="margin-bottom: 25px;">
            <h2 style="margin-bottom: 15px; color: #667eea; display: flex; align-items: center; gap: 10px;">
                <i class="fas fa-search"></i> Cari Barang Cepat
            </h2>
            <p style="margin-bottom: 20px; color: #555;">
                Gunakan pencarian ini untuk referensi singkat tanpa mengubah daftar utama.
            </p>
            <form method="post" style="display: flex; flex-wrap: wrap; gap: 10px; margin-bottom: 20px;">
                <input type="text" name="lookup_keyword" class="form-control" placeholder="Masukkan nama barang" value="<?php echo htmlspecialchars($lookupKeyword); ?>" style="flex: 1 1 250px;">
                <button type="submit" class="btn btn-primary" style="display: flex; align-items: center; gap: 8px;">
                    <i class="fas fa-search"></i> Cari Barang
                </button>
                <?php if($lookupKeyword !== ''): ?>
                    <a href="view_barang.php" class="btn btn-warning" style="display: flex; align-items: center; gap: 8px;">
                        <i class="fas fa-undo"></i> Muat Semua
                    </a>
                <?php endif; ?>
            </form>
            <?php if(count($lookupResults) > 0): ?>
                <div class="table-container">
                    <table>
                        <thead>
                            <tr>
                                <th><i class="fas fa-tag"></i> Nama Barang</th>
                                <th><i class="fas fa-money-bill"></i> Harga Barang</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($lookupResults as $row): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($row['nama_barang']); ?></td>
                                    <td>Rp <?php echo number_format($row['harga_barang'], 0, ',', '.'); ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php else: ?>
                <div class="alert alert-danger" style="margin-top: 15px;">
                    <i class="fas fa-exclamation-circle"></i> Barang dengan kata kunci "<?php echo htmlspecialchars($lookupKeyword); ?>" tidak ditemukan.
                </div>
            <?php endif; ?>
        </div>

        <div class="card">
            <div class="table-container">
                <table>
                    <thead>
                        <tr>
                            <th><i class="fas fa-hashtag"></i> No</th>
                            <th><i class="fas fa-tag"></i> Nama Barang</th>
                            <th><i class="fas fa-money-bill-wave"></i> Harga Barang</th>
                            <th><i class="fas fa-cogs"></i> Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(count($displayedBarang) > 0): ?>
                            <?php foreach ($displayedBarang as $index => $data): ?>
                                <tr>
                                    <td><?php echo $start_from + $index + 1; ?></td>
                                    <td><?php echo htmlspecialchars($data["nama_barang"]); ?></td>
                                    <td>Rp <?php echo number_format($data["harga_barang"], 0, ',', '.'); ?></td>
                                    <td>
                                        <div style="display: flex; gap: 5px;">
                                            <a href="edit_barang.php?id_barang=<?php echo $data['id_barang']; ?>" 
                                               class="action-btn btn-warning" title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <a href="delete_barang.php?id_barang=<?php echo $data['id_barang']; ?>" 
                                               class="action-btn btn-danger" onclick="return confirmDelete();" title="Hapus">
                                                <i class="fas fa-trash"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="5" style="text-align: center; padding: 40px; color: #999;">
                                    <i class="fas fa-inbox" style="font-size: 48px; margin-bottom: 15px; display: block;"></i>
                                    Belum ada data barang
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <?php if($total_pages > 1 && $total_records > 0): ?>
                <div class="pagination">
                    <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                        <a href="?page=<?php echo $i; ?>" <?php echo ($i == $page) ? 'class="active"' : ''; ?>>
                            <?php echo $i; ?>
                        </a>
                    <?php endfor; ?>
                </div>
            <?php endif; ?>

            <!-- Actions -->
            <div style="text-align: center; margin-top: 30px; padding-top: 20px; border-top: 2px solid #f0f0f0;">
                <a href="input_barang.php" class="btn btn-primary" style="margin-right: 15px;">
                    <i class="fas fa-plus"></i> Tambah Barang Baru
                </a>
                <a href="rekap.php" class="btn btn-success" style="margin-right: 15px;">
                    <i class="fas fa-chart-bar"></i> Lihat Rekap
                </a>
                <a href="../admin.php" class="btn btn-warning">
                    <i class="fas fa-home"></i> Kembali ke Dashboard
                </a>
            </div>
        </div>
    </div>
</body>
</html>
