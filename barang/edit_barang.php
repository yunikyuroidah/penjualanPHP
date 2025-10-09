<?php
//include verifikasi.php pada file Administrasi
include("../koneksi.php");
session_start();

require "../koneksi.php";
$id_barang = $_GET['id_barang'];
$query = mysqli_query($conn,"select * from barang where id_barang='$id_barang'");
while($data = mysqli_fetch_array($query)){
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
            <a href="view_barang.php"><i class="fas fa-list"></i> Data Barang</a>
        </div>

        <h1><i class="fas fa-edit"></i> Edit Data Barang</h1>

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
    <?php } ?>
</body>
</html>  



