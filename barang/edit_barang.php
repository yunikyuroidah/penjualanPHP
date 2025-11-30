<?php
//include verifikasi.php pada file Administrasi
session_start();
require "../koneksi.php";
require_once "../hash_util.php";

$id_barang = isset($_GET['id_barang']) ? $_GET['id_barang'] : null;
if ($id_barang === null) {
    header('Location: view_barang.php');
    exit;
}

$detailQuery = mysqli_query($conn, "SELECT * FROM barang WHERE id_barang='" . mysqli_real_escape_string($conn, $id_barang) . "' LIMIT 1");
$data = mysqli_fetch_assoc($detailQuery);

if (!$data) {
    header('Location: view_barang.php?notfound=1');
    exit;
}

$allBarangQuery = mysqli_query($conn, "SELECT * FROM barang ORDER BY nama_barang ASC");
$barangRows = [];
while ($row = mysqli_fetch_assoc($allBarangQuery)) {
    $barangRows[] = $row;
}

$hashTable = buildHashTable($barangRows, 'nama_barang');
$flattenBarang = flattenHashTable($hashTable);
$lookupKeyword = '';
$lookupResults = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['lookup_keyword'])) {
    $lookupKeyword = trim($_POST['lookup_keyword']);
    $lookupResults = hashTableSearch($hashTable, $lookupKeyword, 'nama_barang');
    if ($lookupKeyword === '') {
        $lookupResults = array_slice($flattenBarang, 0, 5);
    }
} else {
    $lookupResults = array_slice($flattenBarang, 0, 5);
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Barang - Sistem Penjualan</title>
    <link rel="stylesheet" href="../style.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
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
            <a href="input_barang.php"><i class="fas fa-box"></i> Form Barang</a>
        </div>

        <h1><i class="fas fa-edit"></i> Edit Data Barang</h1>

        <div class="card" style="margin-bottom: 25px;">
            <h2 style="margin-bottom: 15px; color: #667eea; display: flex; align-items: center; gap: 10px;">
                <i class="fas fa-search"></i> Pencarian Barang Terkait
            </h2>
            <p style="margin-bottom: 20px; color: #555;">
                Pastikan konsistensi data dengan melihat barang lain yang serupa.
            </p>
            <form method="post" style="display: flex; flex-wrap: wrap; gap: 10px; margin-bottom: 20px;">
                <input type="text" name="lookup_keyword" class="form-control" placeholder="Masukkan nama barang" value="<?php echo htmlspecialchars($lookupKeyword); ?>" style="flex: 1 1 250px;">
                <button type="submit" class="btn btn-primary" style="display: flex; align-items: center; gap: 8px;">
                    <i class="fas fa-search"></i> Cari Barang
                </button>
            </form>
            <?php if(count($lookupResults) > 0): ?>
                <div class="table-container">
                    <table>
                        <thead>
                            <tr>
                                <th><i class="fas fa-tag"></i> Nama Barang</th>
                                <th><i class="fas fa-money-bill"></i> Harga</th>
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
            <div class="form-container">
                <form method="get" action="editsimpan_barang.php">
                    <input name="id_barang" type="hidden" value="<?php echo $data['id_barang']; ?>"/>
                    
                    <div class="form-group">
                        <label>
                            <i class="fas fa-hashtag"></i> ID Barang
                        </label>
                        <input type="text" class="form-control" value="<?php echo $data['id_barang']; ?>" disabled />
                        <small style="color: #666; font-size: 12px;">ID barang tidak dapat diubah</small>
                    </div>

                    <div class="form-group">
                        <label for="nama_barang">
                            <i class="fas fa-tag"></i> Nama Barang
                        </label>
                        <input type="text" id="nama_barang" name="nama_barang" class="form-control" 
                               value="<?php echo htmlspecialchars($data['nama_barang']); ?>" 
                               placeholder="Masukkan nama barang" required />
                    </div>

                    <div class="form-group">
                        <label for="harga_barang">
                            <i class="fas fa-money-bill-wave"></i> Harga Barang (Rp)
                        </label>
                        <input type="number" id="harga_barang" name="harga_barang" class="form-control" 
                               value="<?php echo $data['harga_barang']; ?>" 
                               placeholder="Masukkan harga barang" required />
                    </div>

                    <div class="form-group" style="display: flex; gap: 15px; justify-content: center; margin-top: 30px;">
                        <button type="submit" class="btn btn-primary" style="min-width: 150px;">
                            <i class="fas fa-save"></i> Update Barang
                        </button>
                        <button type="reset" class="btn btn-warning" style="min-width: 150px;">
                            <i class="fas fa-redo"></i> Reset Form
                        </button>
                    </div>
                </form>
            </div>

            <div style="text-align: center; margin-top: 30px; padding-top: 20px; border-top: 2px solid #f0f0f0;">
                <a href="view_barang.php" class="btn btn-success">
                    <i class="fas fa-arrow-left"></i> Kembali ke Data Barang
                </a>
            </div>
        </div>
    </div>
</body>
</html>  



