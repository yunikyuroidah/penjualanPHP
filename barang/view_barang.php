<?php
include("../koneksi.php");
session_start();
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
            <a href="view_barang.php"><i class="fas fa-list"></i> Data Barang</a>
        </div>

        <h1><i class="fas fa-boxes"></i> Data Master Barang</h1>

        <div class="card">
            <!-- Search Form -->
            <div class="search-form">
                <form method="post" action="" style="display: flex; justify-content: center; align-items: center; gap: 10px; flex-wrap: wrap;">
                    <input type="text" name="search" placeholder="Cari berdasarkan nama barang..." value="<?php echo isset($_POST['search']) ? $_POST['search'] : ''; ?>">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-search"></i> Cari
                    </button>
                    <?php if(isset($_POST['search'])): ?>
                        <a href="view_barang.php" class="btn btn-warning">
                            <i class="fas fa-times"></i> Reset
                        </a>
                    <?php endif; ?>
                </form>
            </div>

            <!-- Table Container -->
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
                        <?php
                        $results_per_page = 10;

                        if (!isset($_GET['page'])) {
                            $page = 1;
                        } else {
                            $page = $_GET['page'];
                        }

                        $start_from = ($page - 1) * $results_per_page;

                        if(isset($_POST['search'])) {
                            $search = $_POST['search'];
                            $query = mysqli_query($conn, "SELECT * FROM barang WHERE nama_barang LIKE '%$search%' ORDER BY id_barang ASC LIMIT $start_from, $results_per_page");
                        } else {
                            $query = mysqli_query($conn, "SELECT * FROM barang ORDER BY id_barang ASC LIMIT $start_from, $results_per_page");
                        }

                        $total_pages_query = "SELECT COUNT(*) as total FROM barang";
                        $result = mysqli_query($conn, $total_pages_query);
                        $row = mysqli_fetch_assoc($result);
                        $total_pages = ceil($row["total"] / $results_per_page);

                        if(mysqli_num_rows($query) > 0):
                            $no = $start_from + 1;
                            while($data = mysqli_fetch_array($query)):
                        ?>
                                <tr>
                                    <td><?php echo $no; ?></td>
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
                        <?php 
                                $no++; 
                            endwhile; 
                        else: 
                        ?>
                            <tr>
                                <td colspan="4" style="text-align: center; padding: 40px; color: #999;">
                                    <i class="fas fa-inbox" style="font-size: 48px; margin-bottom: 15px; display: block;"></i>
                                    <?php if(isset($_POST['search'])): ?>
                                        Data dengan kata kunci "<?php echo htmlspecialchars($_POST['search']); ?>" tidak ditemukan
                                    <?php else: ?>
                                        Belum ada data barang
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <?php if($total_pages > 1): ?>
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
