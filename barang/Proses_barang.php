<?php
//include verifikasi.php pada file Administrasi
include("../koneksi.php");
session_start();

require "../koneksi.php";

$nama_barang = $_POST['nama_barang'];  
$harga_barang = $_POST['harga_barang'];  

$sql = "INSERT INTO barang (nama_barang, harga_barang) VALUES ('$nama_barang', '$harga_barang')";
$success = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hasil Input Barang - Sistem Penjualan</title>
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

        <h1><i class="fas fa-check-circle"></i> Hasil Input Barang</h1>

        <div class="card">
            <?php if($success): ?>
                <div class="alert alert-success" style="margin-bottom: 30px;">
                    <i class="fas fa-check-circle"></i>
                    <strong>Berhasil!</strong> Data barang telah disimpan ke database.
                </div>
            <?php else: ?>
                <div class="alert alert-danger" style="margin-bottom: 30px;">
                    <i class="fas fa-exclamation-circle"></i>
                    <strong>Gagal!</strong> <?php echo mysqli_error($conn); ?>
                </div>
            <?php endif; ?>

            <!-- Info Card Style -->
            <div style="max-width: 400px; margin: 0 auto; background: white; border-radius: 15px; box-shadow: 0 8px 25px rgba(0,0,0,0.1); overflow: hidden;">
                
                <!-- Header -->
                <div style="background: linear-gradient(45deg, #56ab2f, #a8e6cf); color: white; padding: 25px; text-align: center;">
                    <h2 style="margin: 0; font-size: 24px;">
                        <i class="fas fa-box" style="margin-right: 10px;"></i>
                        DATA BARANG BARU
                    </h2>
                    <p style="margin: 5px 0 0 0; opacity: 0.9;">ID: BRG-<?php echo date('Ymd').'-'.time(); ?></p>
                </div>

                <!-- Content -->
                <div style="padding: 30px;">
                    <table style="width: 100%; border: none; background: transparent;">
                        <tr>
                            <td style="padding: 15px 0; border-bottom: 1px solid #f0f0f0; font-weight: 600; color: #555;">
                                <i class="fas fa-tag" style="margin-right: 8px; color: #56ab2f;"></i>Nama Barang
                            </td>
                            <td style="padding: 15px 0; border-bottom: 1px solid #f0f0f0; text-align: right;">
                                <strong><?php echo htmlspecialchars($nama_barang); ?></strong>
                            </td>
                        </tr>
                        <tr>
                            <td style="padding: 15px 0; font-weight: 600; color: #555;">
                                <i class="fas fa-money-bill-wave" style="margin-right: 8px; color: #56ab2f;"></i>Harga Barang
                            </td>
                            <td style="padding: 15px 0; text-align: right;">
                                <strong style="color: #56ab2f; font-size: 18px;">
                                    Rp <?php echo number_format($harga_barang, 0, ',', '.'); ?>
                                </strong>
                            </td>
                        </tr>
                    </table>
                </div>

                <!-- Footer -->
                <div style="background: #f8f9fa; padding: 20px; text-align: center; border-top: 1px solid #e9ecef;">
                    <p style="margin: 0; color: #666; font-size: 14px;">
                        <i class="fas fa-calendar-alt"></i> 
                        <?php echo date('d F Y, H:i:s'); ?>
                    </p>
                </div>
            </div>

            <!-- Actions -->
            <div style="text-align: center; margin-top: 30px;">
                <a href="input_barang.php" class="btn btn-primary" style="margin-right: 15px;">
                    <i class="fas fa-plus"></i> Tambah Barang Lagi
                </a>
                <a href="view_barang.php" class="btn btn-success">
                    <i class="fas fa-list"></i> Lihat Semua Barang
                </a>
            </div>
        </div>
    </div>
</body>
</html>  