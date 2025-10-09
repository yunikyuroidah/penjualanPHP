<?php
//include verifikasi.php pada file Administrasi
include("../koneksi.php");
session_start();

require "../koneksi.php";
$id = $_GET['id'];
$query = mysqli_query($conn,"select * from transaksi where id='$id'");
while($data = mysqli_fetch_array($query)){
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Transaksi - Sistem Penjualan</title>
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
            <a href="index.php"><i class="fas fa-shopping-cart"></i> Form Transaksi</a>
            <a href="../barang/input_barang.php"><i class="fas fa-box"></i> Form Barang</a>
            <a href="view.php"><i class="fas fa-list"></i> Data Transaksi</a>
        </div>

        <h1><i class="fas fa-edit"></i> Edit Transaksi</h1>

        <div class="card">
            <div class="form-container">
                <form method="get" action="editsimpan.php">
                    <input name="id" type="hidden" value="<?php echo $data['id']; ?>"/>
                    
                    <div class="form-group">
                        <label>
                            <i class="fas fa-hashtag"></i> ID Transaksi
                        </label>
                        <input type="text" class="form-control" value="<?php echo $data['id']; ?>" disabled />
                        <small style="color: #666; font-size: 12px;">ID transaksi tidak dapat diubah</small>
                    </div>

                    <div class="form-group">
                        <label for="nama_barang">
                            <i class="fas fa-tag"></i> Nama Barang
                        </label>
                        <input type="text" id="nama_barang" name="nama_barang" class="form-control" 
                               value="<?php echo htmlspecialchars($data['nama_barang']); ?>" required />
                    </div>

                    <div class="form-group">
                        <label for="harga">
                            <i class="fas fa-money-bill-wave"></i> Harga (Rp)
                        </label>
                        <input type="number" id="harga" name="harga" class="form-control" 
                               value="<?php echo $data['harga']; ?>" required />
                    </div>

                    <div class="form-group">
                        <label for="jumlah">
                            <i class="fas fa-sort-numeric-up"></i> Jumlah (Quantity)
                        </label>
                        <input type="number" id="jumlah" name="jumlah" class="form-control" 
                               value="<?php echo $data['jumlah']; ?>" required />
                    </div>

                    <div class="form-group">
                        <label>
                            <i class="fas fa-users"></i> Status Pelanggan
                        </label>
                        <div style="display: flex; gap: 20px; margin-top: 10px;">
                            <label style="display: flex; align-items: center; cursor: pointer;">
                                <input type="radio" name="status" value="Pelanggan" 
                                       <?php echo ($data['status'] == 'Pelanggan') ? 'checked' : ''; ?>
                                       style="margin-right: 8px; transform: scale(1.2);" />
                                <span>Pelanggan</span>
                            </label>
                            <label style="display: flex; align-items: center; cursor: pointer;">
                                <input type="radio" name="status" value="Bukan pelanggan" 
                                       <?php echo ($data['status'] == 'Bukan pelanggan') ? 'checked' : ''; ?>
                                       style="margin-right: 8px; transform: scale(1.2);" />
                                <span>Bukan Pelanggan</span>
                            </label>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="ongkos">
                            <i class="fas fa-truck"></i> Ongkos Kirim (Rp)
                        </label>
                        <input type="number" id="ongkos" name="ongkos" class="form-control" 
                               value="<?php echo $data['ongkos']; ?>" required />
                    </div>

                    <div class="form-group" style="display: flex; gap: 15px; justify-content: center; margin-top: 30px;">
                        <button type="submit" class="btn btn-primary" style="min-width: 150px;">
                            <i class="fas fa-save"></i> Update Transaksi
                        </button>
                        <button type="reset" class="btn btn-warning" style="min-width: 150px;">
                            <i class="fas fa-redo"></i> Reset Form
                        </button>
                    </div>
                </form>
            </div>

            <div style="text-align: center; margin-top: 30px; padding-top: 20px; border-top: 2px solid #f0f0f0;">
                <a href="view.php" class="btn btn-success">
                    <i class="fas fa-arrow-left"></i> Kembali ke Data Transaksi
                </a>
            </div>
        </div>
    </div>
    <?php } ?>
</body>
</html>  



