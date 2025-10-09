<?php
//include verifikasi.php pada file Administrasi
include("../koneksi.php");
session_start();
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Barang - Sistem Penjualan</title>
    <link rel="stylesheet" href="../style.css" />
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

        <h1><i class="fas fa-cube"></i> Form Input Barang</h1>

        <div class="card">
            <div class="form-container">
                <form method="post" action="Proses_barang.php">
                    <div class="form-group">
                        <label for="nama_barang">
                            <i class="fas fa-tag"></i> Nama Barang
                        </label>
                        <input type="text" id="nama_barang" name="nama_barang" class="form-control" 
                               placeholder="Masukkan nama barang" required />
                    </div>

                    <div class="form-group">
                        <label for="harga_barang">
                            <i class="fas fa-money-bill-wave"></i> Harga Barang (Rp)
                        </label>
                        <input type="number" id="harga_barang" name="harga_barang" class="form-control" 
                               placeholder="Masukkan harga barang" required />
                    </div>

                    <div class="form-group" style="display: flex; gap: 15px; justify-content: center; margin-top: 30px;">
                        <button type="submit" class="btn btn-primary" style="min-width: 150px;">
                            <i class="fas fa-save"></i> Simpan Barang
                        </button>
                        <button type="reset" class="btn btn-warning" style="min-width: 150px;">
                            <i class="fas fa-redo"></i> Reset Form
                        </button>
                    </div>
                </form>
            </div>

            <div style="text-align: center; margin-top: 30px; padding-top: 20px; border-top: 2px solid #f0f0f0;">
                <a href="view_barang.php" class="btn btn-success" style="min-width: 200px;">
                    <i class="fas fa-list-ul"></i> Lihat Data Barang
                </a>
            </div>
        </div>
    </div>
</body>
</html>